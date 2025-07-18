<?php
require('../../../vendor/autoload.php');

use Core\SessionManager;

$SessionManager = new SessionManager;
$SessionManager->redirectNotLoggedIn();


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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/6afdaad939.js" crossorigin="anonymous"></script>
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://unpkg.com/normalize.css">
    <!-- Folha CSS-->
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-around">
        <aside class="aside col-11 col-md-4 text-light">
            <header class="p-3">
                <i class="fa-solid fa-newspaper fa-lg mr-1"></i>
                <h1 class="d-inline ubuntu-regular">Atividade</h1>
            </header>
            <hr>
            <section class="p-3" id="title-description">
                <p class="poppins-regular">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi justo ante, auctor nec turpis eget,
                    rutrum scelerisque dolor.
                </p>
            </section>
            <hr class="d-sm-none d-md-block">
            <section class="p-3 d-flex justify-content-around d-sm-none d-md-flex" id="contact">
                <a href=""><i class="fa-solid fa-envelope fa-lg"></i></a>
                <a href=""><i class="fa-brands fa-whatsapp fa-xl"></i></a>
                <a href=""><i class="fa-brands fa-instagram fa-xl"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                <a href=""><i class="fa-brands fa-github fa-xl"></i></a>
            </section>
        </aside>

        <main class="main col-11 col-md-7 text-light">
            <section id="activity">
                <article>
                    <header class="p-3">
                        <small class="mr-2"><i class="fa-solid fa-calendar fa-sm mr-1"></i> 20/10/2025</small>
                        <small class="mr-2"><i class="fa-solid fa-clock fa-sm mr-1"></i> 3 min</small>
                        <small class="mr-2"><i class="fa-solid fa-eye fa-sm mr-1"></i> 20</small>
                        <h1 class="ubuntu-bold">Título do artigo que pode ser bem grande</h1>
                        <p class="poppins-regular">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi justo ante, auctor nec turpis
                            eget, rutrum scelerisque dolor.
                        </p>

                        <figure>
                            <img
                                src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D">
                            <figcaption class="poppins-light-italic">
                                Imagem tal
                            </figcaption>
                        </figure>

                    </header>
                    <hr>
                    <section id="1-0" class="p-3">
                        <h2 class="ubuntu-bold">1.0 - Título do artigo que pode ser bem grande</h2>
                        <p class="poppins-regular">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi justo ante, auctor nec turpis
                            eget, rutrum scelerisque dolor.
                        </p>
                    </section>

                    <section id="2-0" class="p-3">
                        <h2 class="ubuntu-bold">2.0 - Título do artigo que pode ser bem grande</h2>
                        <p class="poppins-regular">
                            Lorem ipsum dolor sit amet, consectetur <a href="">adipiscing elit</a>. Morbi justo ante,
                            auctor nec turpis eget, rutrum scelerisque dolor.
                        </p>
                    </section>

                    <section id="2-1" class="p-4">
                        <h3 class="ubuntu-bold">2.1 - Título do artigo que pode ser bem grande</h3>
                        <p class="poppins-regular">
                            Lorem ipsum dolor sit amet, consectetur <a href="">adipiscing elit</a>. Morbi justo ante,
                            auctor nec turpis eget, rutrum scelerisque dolor.
                        </p>

                        <figure>
                            <img src="https://miro.medium.com/v2/resize:fit:1400/1*_VoqIhRr7qxIdq2NQj4Zfg.png">
                            <figcaption class="poppins-light-italic">
                                Imagem tal
                            </figcaption>
                        </figure>
                    </section>

                    <section id="2-2" class="p-4">
                        <h3 class="ubuntu-bold">2.1 - Título do artigo que pode ser bem grande</h3>
                        <p class="poppins-regular">
                            Lorem ipsum dolor sit amet, consectetur <a href="">adipiscing elit</a>. Morbi justo ante,
                            auctor nec turpis eget, rutrum scelerisque dolor.
                        </p>
                    </section>

                    <section id="3-0" class="p-3">
                        <h2 class="ubuntu-bold">3.0 - Título do artigo que pode ser bem grande</h2>
                        <p class="poppins-regular">
                            Lorem ipsum dolor sit amet, consectetur <a href="">adipiscing elit</a>. Morbi justo ante,
                            auctor nec turpis eget, rutrum scelerisque dolor.
                        </p>
                    </section>
                </article>
            </section>
        </main>
    </div>
</div>
</body>
</html>