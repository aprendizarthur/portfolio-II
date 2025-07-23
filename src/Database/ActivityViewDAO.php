<?php
declare(strict_types=1);
namespace Database;

use PDOException;

class ActivityViewDAO
{
    private Database $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function Create(array $activityData) : bool{
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("INSERT INTO activitiesviews 
            (activityId, userAgent, userIp)
            VALUES (:activityId, :userAgent, :userIp)");
            $statement->bindParam(':activityId', $activityData['activityId']);
            $statement->bindParam(':userAgent', $activityData['userAgent']);
            $statement->bindParam(':userIp', $activityData['userIp']);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTotalActivityViews(int $activityId): int{
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT COUNT(*) AS total FROM activitiesviews WHERE activityId = :activityId");
            $statement->bindParam(':activityId', $activityId);
            $statement->execute();
            $result = $statement->fetch();
            return (int)$result['total'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    public function existsActivityView(int $activityId) : bool{
        try{
            $pdo = $this->db->getPDO();
            $statement = $pdo->prepare("SELECT * FROM `activitiesviews` WHERE `activityId` = :activityId");
            $statement->bindParam(':activityId', $activityId);
            $statement->execute();
            $result = $statement->fetch();
            $bool = empty($result) ? false : true;
            return $bool;
        } catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
}