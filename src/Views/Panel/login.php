<?php
require('../../../vendor/autoload.php');

use Core\SessionManager;
use Database\{Database, UserDAO};
use Models\UserModel;
use Controllers\UserController;

$SessionManager = new SessionManager;
$SessionManager->redirectLoggedIn();

$Database = new Database('portfolio-II', 'root', '');

$UserDAO = new UserDAO($Database);
$UserModel = new UserModel;
$UserController = new UserController;

try{
$UserController->Login($UserModel, $UserDAO, $UserModel->getDataLoginFromPost());
} catch (Exception $e){
    $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Charset e viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título, Ícone, Descrição e Cor de tema p/ navegador -->
    <title>Login</title>
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
        <aside class="aside mt-5 col-11 col-md-4 text-light">
            <header class="p-3">
                <i class="fa-solid fa-address-card fa-lg  mr-1"></i>
                <h1 class="d-inline ubuntu-regular">Login</h1>
            </header>
            <hr>
            <section class="p-3" id="login">
                <form method="POST" class="form poppins-regular">
                    <div class="form-group">
                        <label for="username">Usuário</label>
                        <input required class="form-control" type="text" name="username">
                        <small class="poppins-light red">
                            <?php if(isset($_SESSION['username-error'])){ echo $_SESSION['username-error']; unset($_SESSION['username-error']); } ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input required class="form-control" type="password" name="password">
                        <small class="poppins-light red">
                            <?php if(isset($_SESSION['password-error'])){ echo $_SESSION['password-error']; unset($_SESSION['password-error']); } ?>
                        </small>
                    </div>
                    <button class="btn mt-1 btn-primary poppins-bold w-100" type="submit" name="submit">Entrar</button>
                </form>
            </section>
        </aside>
    </div>
</div>
</body>
</html>