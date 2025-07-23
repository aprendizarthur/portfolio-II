<?php
require('../../vendor/autoload.php');

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
    <title><?php if(isset($_SESSION['meta-title'])){echo $_SESSION['meta-title'];}?></title>
    <link rel="icon" type="image/x-icon" href="">
    <meta name="description" content="<?php if(isset($_SESSION['meta-description'])){echo $_SESSION['meta-description'];}?>">
    <meta name="theme-color" content="#FFFFFF">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/6afdaad939.js" crossorigin="anonymous">      </script>
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://unpkg.com/normalize.css">
    <!-- Folha CSS-->
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row d-flex justify-content-around">
        <?php
            try{
                $ActivityController->ReadActivityContent($ActivityDAO, $ActivityModel, $SessionManager);
            } catch (Exception $e) {
                echo "<p class=\"col-11 poppins-regular pt-3 red\">".$e->getMessage()."</p>";
            }
        ?>
    </div>
</div>
</body>
</html>