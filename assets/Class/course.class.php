<?php

namespace Courses;
require_once("db.class.php");
use Db;
use PDO;
use PDOException;

class Course
{
    public $conn;

    public function __construct()
    {
        $conn = new Db();
        $this->conn = $conn;
    }


    public function select()
    {
        try {
            $query=$this->conn->prepare("SELECT id,name FROM course");
            $query->execute();
            return json_encode(["status" => 1, "message" => $query->fetchAll(PDO::FETCH_ASSOC)]);
        }catch (PDOException $e){
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

    private function create($course)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO course (name) VALUES (:course)");
            $query->bindParam(':course', $course);
            $result = $query->execute();
            if ($result) {
                return json_encode(["status" => 1, "message" => "Course added successfully"]);
            } else {
                return json_encode(["status" => 0, "message" => "Something went wrong"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

    public function add($course)
    {
        try {
            $query = $this->conn->prepare("SELECT * from course where name=:course");
            $query->bindParam(':course', $course, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                $response=$this->create($course);
                $response_data=json_decode($response,true);
                return json_encode(["status" => $response_data["status"], "message" => $response_data["message"]]);
            }else{
                return json_encode(["status" => 0, "message" => "Course Already Exists"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }
}