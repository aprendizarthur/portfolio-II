<?php
    require('../../../vendor/autoload.php');

    use Core\SessionManager;

    $SessionManager = new SessionManager;
    $SessionManager->Logout();

