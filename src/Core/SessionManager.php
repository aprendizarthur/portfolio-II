<?php
declare(strict_types=1);
namespace Core;

class SessionManager
{
    public function __construct(){
        session_start();
    }

    public function logout() : void {
        session_unset();
        session_destroy();
        header('Location: ../../../index.php');
        exit();
    }

    public function redirectNotLoggedIn(){
        if(!isset($_SESSION['user-username'])){ header('Location: login.php'); }
    }

    public function redirectLoggedIn(){
        if(isset($_SESSION['user-username'])){ header('Location: panel.php'); }
    }

    public function saveDataOnSession(array $data, string $prefix) : void{
        foreach($data as $key => $value){
            $_SESSION[$prefix.$key] = $value;
        }
    }

    public function sendActivityMetaTagsToSession(string $title, string $description) : void{
        $_SESSION['meta-title'] = $title;
        $_SESSION['meta-description'] = $description;
    }

    public function createRelativeLinkForActivity(int $id) : string{
        if(empty($_SESSION['user-username'])){
            return "src/Views/activity.php?id=$id";
        } else {
            return "../activity.php?id=$id";
        }
    }

    public function createRelativeLinkForActivityNavegation(int $activityId) : string{
        $navegation = isset($_SESSION['user-username']) ?
            "<a class=\"d-inline-block btn btn-primary poppins-bold w-100\" href=\"Panel/panel.php\"><i class=\"fa-solid fa-arrow-left mr-2\"></i>Voltar</a>
             <a class=\"d-inline-block btn mt-2 btn-success poppins-bold w-100\" href=\"Panel/updateActivity.php?id=$activityId\">Editar</a>"
            :
            "<a class=\"d-inline-block btn btn-primary poppins-bold w-100\" href=\"../../index.php\"><i class=\"fa-solid fa-lg fa-house\"></i></a>";

        return $navegation;
    }

    public function saveInputModelsOnSessionForCreateActivity(){
        $_SESSION['content-model'] = "
                    <section id=\"1-0\" class=\"p-3\">
                        <h2 class=\"ubuntu-bold\">1.0 - Título Primário</h2>
                        <p class=\"poppins-regular\">
                            Conteúdo   
                        </p>
                    </section>

                    <section id=\"2-0\" class=\"p-3\">
                        <h2 class=\"ubuntu-bold\">2.0 - Título Primário</h2>
                        <p class=\"poppins-regular\">
                            Conteúdo
                        </p>
                    </section>

                    <section id=\"2-1\" class=\"px-4 py-3\">
                        <h3 class=\"ubuntu-bold\">2.1 - Título Secundário</h3>
                        <p class=\"poppins-regular\">
                            Conteúdo
                        </p>

                        <figure class=\"mb-0\">
                            <img src=\"https://miro.medium.com/v2/resize:fit:1400/1*_VoqIhRr7qxIdq2NQj4Zfg.png\">
                            <figcaption class=\"poppins-light-italicmb-0\">Legenda imagem</figcaption>
                        </figure>
                    </section>
        ";

        $_SESSION['summary-model'] = "
            <a class=\"d-block\" href=\"activity.php?id=activity-id#1-0\">
                1.0 - Título 
            </a>
            <a class=\"d-block\" href=\"activity.php?id=activity-id#2-0\">
                2.0 - Título 
            </a>
            <a class=\"d-block mr-1\" href=\"activity.php?id=activity-id#2-1\">
                2.1 - Título 
            </a>
        ";
    }

}