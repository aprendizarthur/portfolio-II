<?php
declare(strict_types=1);
namespace Core;

class SessionManager
{
    public function __construct(){
        session_start();
    }

    public function redirectNotLoggedIn(){
        if(!isset($_SESSION['user-username'])){ header('Location: login.php'); }
    }

    public function redirectLoggedIn(){
        if(isset($_SESSION['user-username'])){ header('Location: panel.php'); }
    }
}