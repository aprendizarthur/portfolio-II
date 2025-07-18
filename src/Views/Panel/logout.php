<?php
    require('../../../vendor/autoload.php');

    use Core\SessionManager;
    use Controllers\UserController;

    $SessionManager = new SessionManager;
    $UserController = new UserController;
    $UserController->Logout();

