<?php
declare(strict_types=1);
namespace Database;

use Database\Database;
use PDOException;

class UserDAO
{
    private Database $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function existsUsernameDatabase(string $username): bool|null {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $statement->bindValue(':username', $username);
            $statement->execute();
            if($statement->rowCount() <= 0){ return false; } else { return true; }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function verifyUserPassword(string $password, string $username): bool|null {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT password FROM users WHERE username = :username");
            $statement->bindValue(':username', $username);
            $statement->execute();
            $result = $statement->fetch();
            if(!password_verify($password, $result['password'])){
                return false;
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getUserDataForSession(string $username) : array|null {
        try {
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT * FROM users WHERE username = ':username'");
            $statement->bindValue(':username', $username);
            $statement->execute();
            $result = $statement->fetch();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getUserIdByUsername(string $username) : int|null {
        try {
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT id FROM users WHERE username = :username");
            $statement->bindValue(':username', $username);
            $statement->execute();
            $result = $statement->fetch();
            return (int)$result['id'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getAllUserDataById(int $id) : array|null {
        try {
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT id, username, email, about, studying, numberWhatsapp, userInstagram, userX, userGithub FROM users WHERE id = :id");
            $statement->bindValue(':id', $id);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getUserPasswordByID(int $id) : string|null {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT password FROM users WHERE id = :id");
            $statement->bindValue(':id', $id);
            $statement->execute();
            $result = $statement->fetch();
            return $result['password'];
        } catch (PDOException $e){
            echo $e->getMessage();
            return null;
        }
    }

    public function updateUserData(array $data, int $id) : bool{
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("UPDATE users SET email = :email, 
                 username = :username, 
                 about = :about,
                 studying = :studying,
                 numberWhatsapp = :numberWhatsapp,
                 userInstagram = :userInstagram,
                 userX = :userX,
                 userGithub = :userGithub
                 WHERE id = :id");
            $statement->bindValue(':id', $id);
            $statement->bindValue(':email', $data['email']);
            $statement->bindValue(':username', $data['username']);
            $statement->bindValue(':about', $data['about']);
            $statement->bindValue(':studying', $data['studying']);
            $statement->bindValue(':numberWhatsapp', $data['whatsapp']);
            $statement->bindValue(':userInstagram', $data['userInstagram']);
            $statement->bindValue(':userX', $data['userX']);
            $statement->bindValue(':userGithub', $data['userGithub']);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}