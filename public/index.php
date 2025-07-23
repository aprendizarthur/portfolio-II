<?php
require('../vendor/autoload.php');

use Core\SessionManager;
use Database\{Database, ActivityDAO};
use Models\ActivityModel;
use Controllers\ActivityController;

$SessionManager = new SessionManager;
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
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="">
    <meta name="description" content="">
    <meta name="theme-color" content="#FFFFFF">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/6afdaad939.js" crossorigin="anonymous">      </script>
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://unpkg.com/normalize.css">
    <!-- Folha CSS-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
                        <i class="fa-solid fa-address-card fa-lg  mr-1"></i>
                        <h1 class="d-inline ubuntu-regular">Sobre mim</h1>
                </header>
                <hr>
                <section class="p-3" id="about-me">
                    <div class="text-center">
                        <img id="logo" src="assets/images/logo.jpg">
                        <h2 class="ubuntu-bold">Arthur Vieira</h2>
                    </div>
                    <p class="poppins-regular">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi justo ante, auctor nec turpis eget, rutrum scelerisque dolor.
                    </p>
                    <p class="poppins-regular">
                        Estudando:
                    </p>
                    <ul class="popping-regular m-0 p-0">
                        <li>- Arquitetura MVC</li>
                        <li>- CodeIgniter</li>
                    </ul>
                </section>
                <hr>
                <section class="p-3 d-flex justify-content-around" id="contact">
                        <a href=""><i class="fa-solid fa-envelope fa-lg"></i></a>
                        <a href=""><i class="fa-brands fa-whatsapp fa-xl"></i></a>
                        <a href=""><i class="fa-brands fa-instagram fa-xl"></i></a>
                        <a href=""><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                        <a href=""><i class="fa-brands fa-github fa-xl"></i></a>
                </section>
                <hr>
                <section class="p-3 text-center" id="status">
                    <span class="ubuntu-regular m-0 green"><i class="pulse fa-solid fa-circle fa-xs mr-2"></i>Disponível para trabalho</span>
                </section>
            </aside>

            <main class="main col-11 col-md-7 col-lg-8 text-light">
                <header class="p-3 d-flex justify-content-between">
                    <div>
                        <i class="fa-solid fa-newspaper fa-lg mr-1"></i>
                        <h1 class="d-inline ubuntu-regular">Atividade</h1>
                    </div>
                </header>
                <hr>
                <section class="p-3" id="pesquisa">
                    <form method="GET" class="ubuntu-regular">
                        <div class="form-group">
                            <label for="search" class="d-none d-md-block"><small><kbd>Alt</kbd> + <kbd>\</kbd></small></label>
                            <input class="form-control w-100 d-inline-block" type="search" name="search" placeholder="Pesquisa"  accesskey="\">
                        </div>
                    </form>
                    <?php
                        try{
                            $ActivityController->Search($ActivityDAO, $SessionManager);
                        } catch (Exception $e) {
                            echo "<p class=\"poppins-regular red\">".$e->getMessage()."</p>";
                        }

                        try{
                            $ActivityController->Read($ActivityDAO, $SessionManager);
                        } catch (Exception $e) {
                            echo "<p class=\"poppins-regular red\">".$e->getMessage()."</p>";
                        }
                    ?>
                </section>
            </main>
        </div>
    </div>
</body>
</html>