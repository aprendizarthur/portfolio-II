<?php
require('../../../vendor/autoload.php');

use Core\SessionManager;
use Database\{Database, UserDAO};
use Models\UserModel;
use Controllers\UserController;

$SessionManager = new SessionManager;
$SessionManager->redirectNotLoggedIn();
$Database = new Database;

$UserDAO = new UserDAO($Database);
$UserModel = new UserModel;
$UserController = new UserController;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Charset e viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título, Ícone, Descrição e Cor de tema p/ navegador -->
    <title>Atualizar dados</title>
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
                <h1 class="d-inline ubuntu-regular">Editar Dados</h1>
            </header>
            <hr>
            <section class="p-3" id="panel-nav">
                    <?php
                        if(isset($_SESSION['update-success'])){
                            echo "<p class=\"mb-3 poppins-regular green\"><i class=\"pulse green fa-solid fa-circle fa-xs mr-2\"></i>Dados atualizados</p>";
                            unset($_SESSION['update-success']);
                        }

                        try{
                            $UserController->Update($UserModel, $UserDAO, $UserModel->getDataUpdateFromPost());
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
                    <h1 class="d-inline ubuntu-regular">Meus dados</h1>
                </div>
            </header>
            <hr>
            <?php
                try{
                    $UserController->Read($UserDAO);
                } catch (Exception $e){
                    echo $e->getMessage();
                }
            ?>
        </main>
    </div>
</div>
</body>
</html>