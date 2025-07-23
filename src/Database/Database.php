<?php
declare(strict_types=1);
namespace Database;

use PDO;
use PDOException;

class Database
{
    public static $pdo;
    private string $dsn = "mysql:host=localhost;dbname=portfolio-II";
    private string $username = 'root';
    private string $password = '';

    public function getPDO(): PDO {
        if(self::$pdo == null) {
            try{
                self::$pdo = new PDO($this->dsn, $this->username, $this->password);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$pdo;
    }
}