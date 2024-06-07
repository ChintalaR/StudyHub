<?php
namespace Subjects;
require_once('db.class.php');

use Db;
use PDO;
use PDOException;
class Subject {
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }

    private function create($sem,$subject)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO subject(sem,name) VALUES(:sem,:subject)");
            $query->bindParam(":sem", $sem);
            $query->bindParam(":subject", $subject);
            $result = $query->execute();
            if (@$result) {
                return json_encode(["status" => 1, "message" => "Subject added successfully"]);
            } else {
                return json_encode(["status" => 0, "message" => "Something went wrong"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }
    public function getsubjects($sem)
    {
        $query=$this->conn->prepare("SELECT id,name FROM subject WHERE sem=:sem");
        $query->bindParam(':sem',$sem);
        $query->execute();
        $subjects = $query->fetchAll(PDO::FETCH_ASSOC);
        return $subjects;
    }


    public function addsubject($sem, $subject)
    {
        try {
            $query = $this->conn->prepare("SELECT * from subject where name=:subject and sem=:sem");
            $query->bindParam(':subject', $subject, PDO::PARAM_STR);
            $query->bindParam(':sem', $sem, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                $response=$this->create($sem, $subject);
                $response_data=json_decode($response,true);
                return json_encode(["status" => $response_data["status"], "message" => $response_data["message"]]);
            }else{
                return json_encode(["status" => 0, "message" => "Subject Already Exists"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

}