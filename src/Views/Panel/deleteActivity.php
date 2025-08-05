<?php
require('../../../vendor/autoload.php');

use Core\SessionManager;
use Database\{Database, ActivityDAO};
use Models\ActivityModel;
use Controllers\ActivityController;

$SessionManager = new SessionManager;
$SessionManager->redirectNotLoggedIn();
$Database = new Database;

$ActivityDAO = new ActivityDAO($Database);
$ActivityModel = new ActivityModel;
$ActivityController = new ActivityController;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Charset e viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título, Ícone, Descrição e Cor de tema p/ navegador -->
    <title>Excluir Atividade</title>
    <link rel="icon" type="image/x-icon" href="">
    <meta name="description" content="">
    <meta name="theme-color" content="#ff7e7e">
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
                <h1 class="d-inline ubuntu-regular">Excluir Atividade</h1>
            </header>
            <hr>
            <section class="p-3" id="panel-nav">
                <nav>
                    <a class="d-inline-block btn btn-primary poppins-bold w-100" href="panel.php">Cancelar</a>
                    <form method="POST" class="form">
                        <button type="submit" name="submit" class="btn btn-danger d-inline-block mt-2 poppins-bold w-100">Confirmar</button>
                    </form>
                </nav>
            </section>
        </aside>

        <main class="main col-11 col-md-7 col-lg-8 text-light">
            <header class="p-3 d-flex justify-content-between">
                <div>
                    <i class="fa-solid fa-id-card fa-lg mr-1"></i>
                    <h1 class="d-inline ubuntu-regular">Confirmar exclusão</h1>
                </div>
            </header>
            <hr>
            <section class="p-3" id="update-user">
                <?php
                try{
                    $ActivityController->Delete($ActivityDAO, $SessionManager);
                } catch (Exception $e){
                    echo "<p class=\"mb-3 poppins-regular red\"><i class=\"pulse red fa-solid fa-circle fa-xs mr-2\"></i>".$e->getMessage()."</p>";
                }
                ?>
            </section>
        </main>
    </div>
</div>
</body>
</html>