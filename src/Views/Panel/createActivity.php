<?php
require('../../../vendor/autoload.php');

use Core\SessionManager;
use Database\{Database, ActivityDAO};
use Models\ActivityModel;
use Controllers\{ActivityController, SitemapController};

$SessionManager = new SessionManager;
$SessionManager->redirectNotLoggedIn();
$Database = new Database;

$ActivityDAO = new ActivityDAO($Database);
$ActivityModel = new ActivityModel;
$ActivityController = new ActivityController;

$SitemapController = new SitemapController;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Charset e viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título, Ícone, Descrição e Cor de tema p/ navegador -->
    <title>Criar Atividade</title>
    <link rel="icon" type="image/x-icon" href="../../../public/assets/images/favicon.ico">
    <meta name="description" content="">
    <meta name="theme-color" content="green">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/6afdaad939.js" crossorigin="anonymous">      </script>
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://unpkg.com/normalize.css">
    <!-- Folha CSS-->
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-around">
        <aside class="aside col-11 col-md-4 col-lg-3 text-light">
            <header class="p-3">
                <i class="fa-solid fa-screwdriver-wrench fa-lg mr-1"></i>
                <h1 class="d-inline ubuntu-regular">Nova Atividade</h1>
            </header>
            <hr>
            <section class="p-3" id="panel-nav">
                <?php
                    try{
                        $ActivityController->Create($ActivityModel, $ActivityDAO, $SessionManager, $ActivityModel->getDataCreateFromPost(), $SitemapController);
                    } catch (Exception $e){
                        echo "<p class=\"mb-3 poppins-regular red\"><i class=\"pulse red fa-solid fa-circle fa-xs mr-2\"></i>".$e->getMessage()."</p>";
                    }
                ?>
                <nav>
                    <a class="d-inline-block btn btn-danger poppins-regular w-100" href="panel.php">Cancelar</a>
                </nav>
            </section>
        </aside>

        <main class="main col-11 col-md-7 col-lg-8 text-light">
            <header class="p-3 d-flex justify-content-between">
                <div>
                    <i class="fa-solid fa-id-card fa-lg mr-1"></i>
                    <h1 class="d-inline ubuntu-regular">Dados Atividade</h1>
                </div>
            </header>
            <hr>
            <section class="p-3" id="update-user">
                <form method="POST" class="form poppins-regular">

                    <details class="p-2">
                        <summary class="text-center pt-1">
                            <h3 class="d-inline ubuntu-regular">SEO<h2>
                        </summary>

                        <div class="form-group px-2">
                            <label for="meta-title">Meta Title</label>
                            <textarea placeholder="Até 70 caracteres" required class="form-control" spellcheck="true" name="meta-title" id="meta-title" rows="2"><?php if(isset($_SESSION['create-meta-title'])){echo $_SESSION['create-meta-title']; unset($_SESSION['create-meta-title']);}?></textarea>
                        </div>

                        <div class="form-group px-2">
                            <label for="meta-description">Meta Description</label>
                            <textarea required placeholder="Até 160 caracteres" class="form-control" spellcheck="true" name="meta-description" id="meta-description" rows="4"><?php if(isset($_SESSION['create-meta-description'])){echo $_SESSION['create-meta-description']; unset($_SESSION['create-meta-description']);}?></textarea>
                        </div>
                    </details>

                    <details class="p-2">
                        <summary class="text-center pt-1">
                            <h3 class="d-inline ubuntu-regular">Apresentação<h2>
                        </summary>

                        <div class="form-group px-2">
                            <label for="cover-image">Imagem de capa (opcional)</label>
                            <textarea placeholder="URL da imagem" class="form-control" spellcheck="true" name="cover-image" id="cover-image" rows="1"><?php if(isset($_SESSION['create-cover-image'])){echo $_SESSION['create-cover-image']; unset($_SESSION['create-cover-image']);}?></textarea>
                        </div>

                        <div class="form-group px-2">
                            <label for="title">Título</label>
                            <textarea required placeholder="Até 70 caracteres" class="form-control" spellcheck="true" name="title" id="title" rows="2"><?php if(isset($_SESSION['create-title'])){echo $_SESSION['create-title']; unset($_SESSION['create-title']);}?></textarea>
                        </div>

                        <div class="form-group px-2">
                            <label for="description">Descrição</label>
                            <textarea required placeholder="Até 160 caracteres" class="form-control" spellcheck="true" name="description" id="description" rows="4"><?php if(isset($_SESSION['create-description'])){echo $_SESSION['create-description']; unset($_SESSION['create-description']);}?></textarea>
                        </div>

                        <div class="form-group px-2">
                            <label for="summary">Sumário</label>
                            <textarea required placeholder="Âncoras para as sections" class="form-control" spellcheck="true" name="summary" id="summary" rows="10"><?php if(isset($_SESSION['create-summary'])){echo $_SESSION['create-summary']; unset($_SESSION['create-summary']);} else { echo $_SESSION['summary-model'];}?></textarea>
                        </div>
                    </details>

                    <div class="form-group">
                        <label for="content">Conteúdo</label>
                        <textarea required placeholder="HTML puro" class="form-control" spellcheck="true" name="content" id="content" rows="15"><?php if(isset($_SESSION['create-content'])){echo $_SESSION['create-content']; unset($_SESSION['create-content']);} else{echo $_SESSION['content-model'];}?></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mt-1 poppins-bold w-100">Criar</button>
                </form>
            </section>
        </main>
    </div>
</div>
</body>
</html>