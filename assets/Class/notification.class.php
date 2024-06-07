<?php

namespace Notifications;
require_once('db.class.php');

use Db;
use PDO;
use PDOException;

class Notification
{
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }

    public function select()
    {
        $query=$this->conn->query("SELECT notifications.id,content,year.name as year,course.name as course,notifications.updated_at FROM notifications JOIN year ON year.id = notifications.year JOIN course ON course.id = year.course");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendNotification($content, $years)
    {
        try {
            foreach ($years as $year) {
                $query = $this->conn->prepare("INSERT INTO `notifications` (`content`, `year`) VALUES (:content, :year)");
                $query->bindParam(':content', $content);
                $query->bindParam(':year', $year);
                $query->execute();
            }
            return json_encode(["status" => 1, "message" => "Notification Added Successfully"]);
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

    public function delete($id){
        try {
            $query = $this->conn->prepare("DELETE FROM notifications WHERE id=:id");
            $query->bindParam(':id', $id);
            $query->execute();
            return json_encode(["status" => 1, "message" => "Notification Deleted Successfully"]);
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

    public function getNotification($year){
        $query=$this->conn->prepare("SELECT content FROM notifications WHERE year=:year");
        $query->bindParam(':year', $year);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}