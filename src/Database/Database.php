<?php
declare(strict_types=1);
namespace Database;

use PDO;
use PDOException;

class Database
{
    public static $pdo;
    private string $dsn;
    private string $username;
    private string $password;

    public function __construct(string $dbname, string $username, string $password){
        $this->dsn = "mysql:host=localhost;dbname=".$dbname;
        $this->username = $username;
        $this->password = $password;
    }

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