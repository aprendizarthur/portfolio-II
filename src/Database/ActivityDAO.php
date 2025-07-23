<?php
declare(strict_types=1);
namespace Database;

use Database\Database;
use PDO;
use PDOException;

class ActivityDAO
{
    private Database $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function Create(array $activityData) : bool{
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("INSERT INTO activities 
            (summary, title, metaTitle, description, metaDescription, cover, content, readingTime) 
            VALUES (:summary, :title, :metaTitle, :description, :metaDescription, :cover, :content, :readingTime)");
            $statement->bindValue(':summary', $activityData['summary']);
            $statement->bindValue(':title', $activityData['title']);
            $statement->bindValue(':metaTitle', $activityData['meta-title']);
            $statement->bindValue(':description', $activityData['description']);
            $statement->bindValue(':metaDescription', $activityData['meta-description']);
            $statement->bindValue(':cover', $activityData['cover-image']);
            $statement->bindValue(':content', $activityData['content']);
            $statement->bindValue(':readingTime', $activityData['reading-time']);
            $statement->execute();
            return true;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function Update(array $activityData) : bool{
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("UPDATE activities SET 
                      summary = :summary, metaTitle = :metaTitle, title = :title, metaDescription = :metaDescription, description = :description, cover = :cover, content = :content, readingTime = :readingTime
                      WHERE id = :id");
            $statement->bindValue(':id', $activityData['id']);
            $statement->bindValue(':summary', $activityData['summary']);
            $statement->bindValue(':title', $activityData['title']);
            $statement->bindValue(':metaTitle', $activityData['meta-title']);
            $statement->bindValue(':title', $activityData['title']);
            $statement->bindValue(':description', $activityData['description']);
            $statement->bindValue(':metaDescription', $activityData['meta-description']);
            $statement->bindValue(':description', $activityData['description']);
            $statement->bindValue(':cover', $activityData['cover-image']);
            $statement->bindValue(':content', $activityData['content']);
            $statement->bindValue(':readingTime', $activityData['reading-time']);
            $statement->execute();
            return true;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function Delete(int $id) : bool {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("DELETE FROM activities WHERE id = :id");
            $statement->bindValue(':id', $id);
            $statement->execute();
            return true;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function Search(string $search) : array|bool{
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT * FROM activities WHERE title LIKE :search OR description LIKE :search");
            $statement->bindValue(':search', $search);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result ?? false;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getActivityDataById(int $id) : array|bool {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT * FROM activities WHERE id = :id");
            $statement->bindValue(':id', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    public function getAllActivitiesData() : array|bool {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT id, date, title, description, cover, readingTime FROM activities ORDER BY date DESC");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result ?? [];
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getAllActivitiesID() : array|bool {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT id FROM activities ORDER BY date DESC");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result ?? [];
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function existsActivityId(int $id) : bool {
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT id FROM activities WHERE id = :id");
            $statement->bindValue(':id', $id);
            $statement->execute();
            $result = $statement->fetch();
            if(!empty($result)){
                return true;
            }
            return false;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
}