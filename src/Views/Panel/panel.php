<?php
require('../../../vendor/autoload.php');

use Core\SessionManager;
use Database\{Database};

$SessionManager = new SessionManager;
$SessionManager->redirectNotLoggedIn();
$Database = new Database('portfolio-II', 'root', '');
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
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-around">
        <aside class="aside col-11 col-md-4 text-light">
            <header class="p-3">
                <i class="fa-solid fa-screwdriver-wrench fa-lg mr-1"></i>
                <h1 class="d-inline ubuntu-regular">Painel Administrador</h1>
            </header>
            <hr>
            <section class="p-3" id="panel-info">
                <p class="poppins-regular">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi justo ante, auctor nec turpis eget, rutrum scelerisque dolor.
                </p>
            </section>
            <hr>
            <section class="p-3" id="panel-nav">
                <nav>
                    <a class="d-inline-block btn btn-primary poppins-bold w-49" href="updateUser.php">Editar dados</a>
                    <a class="d-inline-block btn btn-danger poppins-regular w-49" href="logout.php">Logout</a>
                </nav>
            </section>
        </aside>

        <main class="main col-11 col-md-7 text-light">
            <header class="p-3 d-flex justify-content-between">
                <div>
                    <i class="fa-solid fa-newspaper fa-lg mr-1"></i>
                    <h1 class="d-inline ubuntu-regular">Atividade</h1>
                </div>
            </header>
            <hr>
            <section class="p-3" id="pesquisa">
                <form method="POST" class="ubuntu-regular">
                    <div class="form-group">
                        <input class="form-control w-100" type="search" name="pesquisa" placeholder="Pesquisar">
                    </div>
                </form>

                <a class="d-inline-block mb-3 btn btn-primary poppins-bold w-100" href="newActivity.php">Nova Atividade</a>

                <article class="p-3 mb-3">
                    <a href="article.php?id=">
                        <header>
                            <small class="mr-2"><i class="fa-solid fa-calendar fa-sm mr-1"></i> 20/10/2025</small>
                            <small class="mr-2"><i class="fa-solid fa-clock fa-sm mr-1"></i> 3 min</small>
                            <small class="mr-2"><i class="fa-solid fa-eye fa-sm mr-1"></i> 20</small>
                            <a href="updateActivity.php?id="><small class="mr-2 green float-right"><i class="fa-solid fa-pen-to-square fa-lg mr-1"></i></small></a>
                            <h1 class="ubuntu-regular clear">Título do artigo que pode ser bem grande</h1>
                            <p class="poppins-regular">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi justo ante, auctor nec turpis eget, rutrum scelerisque dolor.
                            </p>
                        </header>
                    </a>
                </article>
                <hr>
                <article class="p-3 my-3">
                    <a href="article.php?id=">
                        <header>
                            <small class="mr-2"><i class="fa-solid fa-calendar fa-sm mr-1"></i> 20/10/2025</small>
                            <small class="mr-2"><i class="fa-solid fa-clock fa-sm mr-1"></i> 3 min</small>
                            <small class="mr-2"><i class="fa-solid fa-eye fa-sm mr-1"></i> 20</small>
                            <a href="updateActivity.php?id="><small class="mr-2 green float-right"><i class="fa-solid fa-pen-to-square fa-lg mr-1"></i></small></a>
                            <h1 class="ubuntu-regular">Título do artigo que pode ser bem grande mesmo, até qebraralinhaqueloucura</h1>
                            <p class="poppins-regular">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi justo ante, auctor nec turpis eget, rutrum scelerisque dolor.
                            </p>
                            <figure class="pt-3 m-0">
                                <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                                <figcaption class="poppins-light-italic">
                                    Imagem tal
                                </figcaption>
                            </figure>
                        </header>
                    </a>
                </article>
            </section>
        </main>
    </div>
</div>
</body>
</html>