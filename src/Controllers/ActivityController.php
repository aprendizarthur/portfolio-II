<?php
declare(strict_types=1);
namespace Controllers;

use Core\SessionManager;
use Database\ActivityDAO;
use Database\ActivityViewDAO;
use Models\ActivityModel;

class ActivityController
{
    private ActivityModel $activityModel;
    private ActivityDAO $activityDAO;
    private ActivityViewController $activityViewController;
    private ActivityViewDAO $activityViewDAO;
    private SessionManager $sessionManager;

    public function Create(ActivityModel $activityModel, ActivityDAO $activityDAO, SessionManager $sessionManager, array $DataCreateFromPost) : void{
        $this->activityModel = $activityModel;
        $this->activityDAO = $activityDAO;
        $this->sessionManager = $sessionManager;

        $this->sessionManager->saveInputModelsOnSessionForCreateActivity();

        if(!empty($DataCreateFromPost)){
            if(!$this->activityModel->AuthLength($DataCreateFromPost['meta-title'], 70)){
                $this->sessionManager->saveDataOnSession($DataCreateFromPost, 'create-');
                throw new \Exception("Meta Title muito grande (maximo 70 caracteres)");
            }

            if(!$this->activityModel->AuthLength($DataCreateFromPost['meta-description'], 160)){
                $this->sessionManager->saveDataOnSession($DataCreateFromPost, 'create-');
                throw new \Exception("Meta Description muito grande (maximo 160 caracteres)");
            }

            if(!$this->activityModel->AuthLength($DataCreateFromPost['title'], 70)){
                $this->sessionManager->saveDataOnSession($DataCreateFromPost, 'create-');
                throw new \Exception("Título muito grande (maximo 70 caracteres)");
            }

            if(!$this->activityModel->AuthLength($DataCreateFromPost['description'], 160)){
                $this->sessionManager->saveDataOnSession($DataCreateFromPost, 'create-');
                throw new \Exception("Descrição muito grande (maximo 160 caracteres)");
            }

            $DataCreateFromPost["reading-time"] = $this->activityModel->calculateReadingTime($DataCreateFromPost["content"]);

            if(!$this->activityDAO->Create($DataCreateFromPost)){
                $this->sessionManager->saveDataOnSession($DataCreateFromPost, 'create-');
                throw new \Exception("Erro ao cadastrar, tente novamente");
            }

            header("Location: panel.php");
            exit();
        }
    }

    public function ReadActivityContent(ActivityViewController $activityViewController, ActivityViewDAO $activityViewDAO, ActivityDAO $activityDAO, ActivityModel $activityModel, SessionManager $sessionManager) : void{
        $this->activityDAO = $activityDAO;
        $this->activityModel = $activityModel;
        $this->activityViewController = $activityViewController;
        $this->activityViewDAO = $activityViewDAO;
        $this->sessionManager = $sessionManager;

        if(!empty($_GET['id'])){
            if(!$this->activityDAO->existsActivityId((int)$_GET['id'])){
                header("Location: ../../public/index.php");
                exit();
            }

            if(!$activityData = $this->activityDAO->getActivityDataById((int)$_GET['id'])){
                throw new \Exception("Erro ao encontrar dados, tente novamente");
            }

            $this->sessionManager->sendActivityMetaTagsToSession($activityData['metaTitle'], $activityData['metaDescription']);

            $activityNavegation = $this->sessionManager->createRelativeLinkForActivityNavegation($activityData['id']);

            $activitySummaryFormated = str_replace('activity-id', (string)$activityData['id'], $activityData['summary']);

            $activityCover = !empty($activityData["cover"]) ? "<figure> <img src=\"$activityData[cover]\"> </figure>" : "";

            $activityData["views"] = $this->activityViewController->getActivityViews($activityData['id'], $activityViewDAO);

            echo "
                <aside class=\"aside col-11 col-md-4 col-lg-3 text-light\">
                    <header class=\"p-3\">
                        <i class=\"fa-solid fa-newspaper fa-lg mr-1\"></i>
                        <h1 class=\"d-inline ubuntu-regular\">Atividade</h1>
                    </header>
                    <hr>
                    <section class=\"p-3\">
                        <nav>
                            $activityNavegation
                        </nav>
                    </section>
                    <hr>
                    <section class=\"p-3\" id=\"summary\">
                        <details class=\"p-2\">
                            <summary class=\"text-center pt-1\">
                                <h3 class=\"d-inline ubuntu-regular\">Sumário<h2>
                            </summary>
                            
                            <div class='p-2'>
                                $activitySummaryFormated
                            </div>
                        </details>
                    </section>
                </aside>
            
                <main class=\"main col-11 col-md-7 col-lg-8 p-3 text-light\">      
                    <section id=\"activity\">
                        <article>
                            <header class=\"p-3\">
                                <small class=\"mr-2\"><i class=\"fa-solid fa-calendar fa-sm mr-1\"></i>$activityData[date]</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-clock fa-sm mr-1\"></i>$activityData[readingTime] min</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-eye fa-sm mr-1\"></i>$activityData[views]</small>
                                <h1 class=\"ubuntu-bold\">$activityData[title]</h1>
                                <p class=\"poppins-regular\">
                                    $activityData[description]
                                </p>
                                $activityCover
                            </header>
                            <hr>
                            $activityData[content]
                        </article>
                    </section>
                    <section id=\"pesquisa\" class='mt-3' style=\"background-color: #1E1E1F; border-radius: 5px; border: solid 1px #383838\">
                        <header class=\"p-3\" style='background-color: #1E1E1F;'>
                        <i class=\"fa-solid fa-wand-magic-sparkles mr-1 \"></i>
                        <h1 class=\"d-inline ubuntu-regular\">Recomendado</h1>
                        </header>
                        <hr>
                        <div class='px-3 pb-3'>
                    ";

                    $this->Recommendation($activityViewController, $activityViewDAO, $activityDAO, $activityModel);
            echo "</div></section></main>";

        } else {
            header("Location: ../../public/index.php");
            exit();
        }
    }

    public function Read(ActivityViewController $activityViewController, ActivityViewDAO $activityViewDAO, ActivityDAO $activityDAO, SessionManager $sessionManager){
        $this->activityViewController = $activityViewController;
        $this->activityDAO = $activityDAO;
        $this->activityViewDAO = $activityViewDAO;
        $this->sessionManager = $sessionManager;

        if(!isset($_GET['search']) || $_GET['search'] === "all"){
            $activitiesData = $this->activityDAO->getAllActivitiesData();

            if($activitiesData === false){
                throw new \Exception("Erro ao carregar atividades, tente novamente.");
            }
            if(empty($activitiesData)){
                throw new \Exception("Nenhuma atividade encontrada");
            }

            foreach($activitiesData as $activityData){
                $activityRelativeLink = $this->sessionManager->createRelativeLinkForActivity($activityData['id']);
                $activityCover = empty($activityData['cover']) ? "" : "<figure class=\"pt-3 m-0\"><img src=\"$activityData[cover]\"></figure>";
                $activityData["views"] = $this->activityViewController->getActivityViews($activityData['id'], $this->activityViewDAO);

                echo "
                    <article class=\"p-3\">
                        <a href=\"$activityRelativeLink\">
                            <header>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-calendar fa-sm mr-1\"></i>$activityData[date]</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-clock fa-sm mr-1\"></i>$activityData[readingTime] min</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-eye fa-sm mr-1\"></i>$activityData[views]</small>
                                <h1 class=\"ubuntu-bold\">$activityData[title]</h1>
                                <p class=\"poppins-regular\">$activityData[description]</p>
                            </header>
                            $activityCover
                        </a>
                    </article>
                    <hr> 
                ";
            }
        }
    }

    public function Update(ActivityModel $activityModel, ActivityDAO $activityDAO, SessionManager $sessionManager, array $DataUpdateFromPost){
        $this->activityModel = $activityModel;
        $this->activityDAO = $activityDAO;
        $this->sessionManager = $sessionManager;

        if(isset($_POST['submit'])){
            $DataUpdateFromPost["reading-time"] = $this->activityModel->calculateReadingTime($DataUpdateFromPost["content"]);
            $DataUpdateFromPost["id"] = (int)$_GET['id'];

            if(!$this->activityDAO->Update($DataUpdateFromPost)){
                throw new \Exception("Erro ao atualizar atividade, tente novamente");
            }

            $this->sessionManager->sendActivityMetaTagsToSession($DataUpdateFromPost['meta-title'], $DataUpdateFromPost['meta-description']);

            header("Location: ../activity.php?id=".$_GET['id']);
            exit();
        }

        if(!empty($_GET['id'])){
            if(!$this->activityDAO->existsActivityId((int)$_GET['id'])){
                throw new \Exception("Atividade não existe ou foi excluida");
            }

            if(!$activityData = $this->activityDAO->getActivityDataById((int)$_GET['id'])){
                throw new \Exception("Erro ao encontrar dados, tente novamente");
            }

            echo "
                <form method=\"POST\" class=\"form poppins-regular\">

                    <details class=\"p-2\">
                        <summary class=\"text-center pt-1\">
                            <h3 class=\"d-inline ubuntu-regular\">SEO<h2>
                        </summary>

                        <div class=\"form-group px-2\">
                            <label for=\"meta-title\">Meta Title</label>
                            <textarea placeholder=\"Até 70 caracteres\" required class=\"form-control\" spellcheck=\"true\" name=\"meta-title\" id=\"meta-title\" rows=\"2\">$activityData[metaTitle]</textarea>
                        </div>

                        <div class=\"form-group px-2\">
                            <label for=\"meta-description\">Meta Description</label>
                            <textarea required placeholder=\"Até 160 caracteres\" class=\"form-control\" spellcheck=\"true\" name=\"meta-description\" id=\"meta-description\" rows=\"4\">$activityData[metaDescription]</textarea>
                        </div>
                    </details>

                    <details class=\"p-2\">
                        <summary class=\"text-center pt-1\">
                            <h3 class=\"d-inline ubuntu-regular\">Apresentação<h2>
                        </summary>

                        <div class=\"form-group px-2\">
                            <label for=\"cover-image\">Imagem de capa (opcional)</label>
                            <textarea placeholder=\"URL da imagem\" class=\"form-control\" spellcheck=\"true\" name=\"cover-image\" id=\"cover-image\" rows=\"1\">$activityData[cover]</textarea>
                        </div>

                        <div class=\"form-group px-2\">
                            <label for=\"title\">Título</label>
                            <textarea required placeholder=\"Até 70 caracteres\" class=\"form-control\" spellcheck=\"true\" name=\"title\" id=\"title\" rows=\"2\">$activityData[title]</textarea>
                        </div>

                        <div class=\"form-group px-2\">
                            <label for=\"description\">Descrição</label>
                            <textarea required placeholder=\"Até 160 caracteres\" class=\"form-control\" spellcheck=\"true\" name=\"description\" id=\"description\" rows=\"4\">$activityData[description]</textarea>
                        </div>

                        <div class=\"form-group px-2\">
                            <label for=\"summary\">Sumário</label>
                            <textarea required placeholder=\"Âncoras para as sections\" class=\"form-control\" spellcheck=\"true\" name=\"summary\" id=\"summary\" rows=\"10\">$activityData[summary]</textarea>
                        </div>
                    </details>

                    <div class=\"form-group\">
                        <label for=\"content\">Conteúdo</label>
                        <textarea required placeholder=\"HTML puro\" class=\"form-control\" spellcheck=\"true\" name=\"content\" id=\"content\" rows=\"15\">$activityData[content]</textarea>
                    </div>

                    <button type=\"submit\" name=\"submit\" class=\"btn btn-primary mt-1 poppins-bold w-100\">Atualizar</button>
                </form>
            ";
        } else {
            throw new \Exception("Atividade não existe ou foi excluida");
        }
    }

    public function Delete(ActivityDAO $activityDAO, SessionManager $sessionManager){
        $this->activityDAO = $activityDAO;
        $this->sessionManager = $sessionManager;

        if(!empty($_GET['id'])){
            if(!$this->activityDAO->existsActivityId((int)$_GET['id'])){
                header("Location: panel.php");
                exit();
            }

            if(!$activityData = $this->activityDAO->getActivityDataById((int)$_GET['id'])){
                throw new \Exception("Erro ao encontrar dados, tente novamente");
            }

            $activityCover = empty($activityData['cover']) ? "" : "<figure class=\"pt-3 m-0\"><img src=\"$activityData[cover]\"></figure>";

            echo "
                    <article class=\"p-3\">
                            <header>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-calendar fa-sm mr-1\"></i>$activityData[date]</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-clock fa-sm mr-1\"></i>$activityData[readingTime] min</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-eye fa-sm mr-1\"></i> 20</small>
                                <h1 class=\"ubuntu-bold\">$activityData[title]</h1>
                                <p class=\"poppins-regular\">$activityData[description]</p>
                            </header>
                            $activityCover
                    </article>
                ";
        }

        if(isset($_POST['submit'])){
            if(!$this->activityDAO->Delete($activityData['id'])){
                throw new \Exception("Erro ao apagar dados, tente novamente");
            }

            header("Location: panel.php");
            exit();
        }
    }

    public function Search(ActivityViewController $activityViewController, ActivityViewDAO $activityViewDAO, ActivityDAO $activityDAO, SessionManager $sessionManager){
        $this->activityDAO = $activityDAO;
        $this->activityViewController = $activityViewController;
        $this->activityViewDAO = $activityViewDAO;
        $this->sessionManager = $sessionManager;

        if(isset($_GET['search'])){
            if(strlen($_GET['search']) < 3){
                throw new \Exception("A pesquisa precisa ter pelo menos 3 caracteres.");
            }

            $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

            if($search == "all"){
                $this->Read($activityViewController, $activityViewDAO, $activityDAO, $sessionManager);
                exit();
            }

            $formatedSearch = '%'.htmlspecialchars($search).'%';

            if(!$searchResult = $this->activityDAO->Search($formatedSearch)){
                throw new \Exception("Nenhum resultado encontrado.");
            }

            if($searchResult === []){
                echo "<p class=\"poppins-regular\">Nenhum resultado encontrado.</p>";
            }

            $totalResults = count($searchResult);

            echo "<p class=\"poppins-regular\" style=\"color: #383838 !important;\">Foram encontrados ($totalResults) resultado(s)</p>";

            foreach($searchResult as $activityData){
                $activityRelativeLink = $this->sessionManager->createRelativeLinkForActivity($activityData['id']);
                $activityCover = empty($activityData['cover']) ? "" : "<figure class=\"pt-3 m-0\"><img src=\"$activityData[cover]\"></figure>";
                $activityData['views'] = $this->activityViewController->getActivityViews($activityData['id'], $activityViewDAO);

                echo "
                    <article class=\"p-3\">
                        <a href=\"$activityRelativeLink\">
                            <header>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-calendar fa-sm mr-1\"></i>$activityData[date]</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-clock fa-sm mr-1\"></i>$activityData[readingTime] min</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-eye fa-sm mr-1\"></i>$activityData[views]</small>
                                <h1 class=\"ubuntu-bold\">$activityData[title]</h1>
                                <p class=\"poppins-regular\">$activityData[description]</p>
                            </header>
                            $activityCover
                        </a>
                    </article>
                    <hr> 
                ";
            }
        }
    }

    public function Recommendation(ActivityViewController $activityViewController, ActivityViewDAO $activityViewDAO, ActivityDAO $activityDAO, ActivityModel $activityModel) : void {
        $this->activityDAO = $activityDAO;
        $this->activityViewController = $activityViewController;
        $this->activityViewDAO = $activityViewDAO;
        $this->activityModel = $activityModel;

        if(!$allActivitiesIds =$this->activityDAO->getAllActivitiesID()){
            throw new \Exception("Erro ao carregar recomendações.");
        }

        if($allActivitiesIds === [] || (int)count($allActivitiesIds) === 1){
            throw new \Exception("Nenhuma atividade encontrada para recomendar.");
        }

        $randomIds = $this->activityModel->returnDifferentRandomIds($allActivitiesIds, (int)$_GET['id']);

        foreach($randomIds as $activityID){
            if(!$activityData = $this->activityDAO->getActivityDataById($activityID)){
                throw new \Exception("Erro ao carregar recomendação.");
            }
                $activityCover = empty($activityData['cover']) ? "" : "<figure class=\"pt-3 m-0\"><img src=\"$activityData[cover]\"></figure>";
                $activityData['views'] = $this->activityViewController->getActivityViews($activityID, $activityViewDAO);

            echo "
                    <article class=\"p-3\">
                        <a href=\"activity.php?id=$activityData[id]\">
                            <header>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-calendar fa-sm mr-1\"></i>$activityData[date]</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-clock fa-sm mr-1\"></i>$activityData[readingTime] min</small>
                                <small class=\"mr-2\"><i class=\"fa-solid fa-eye fa-sm mr-1\"></i> $activityData[views]</small>
                                <h1 class=\"ubuntu-bold\">$activityData[title]</h1>
                                <p class=\"poppins-regular\">$activityData[description]</p>
                            </header>
                            $activityCover
                        </a>
                    </article>
                    <hr> 
            ";
        }
    }
}