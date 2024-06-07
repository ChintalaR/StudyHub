<?php

namespace Years;
require_once('db.class.php');

use Db;
use PDO;
use PDOException;

class Year
{
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }


    private function create($course, $year)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO year(course,name) VALUES(:course,:year)");
            $query->bindParam(":course", $course);
            $query->bindParam(":year", $year);
            $result = $query->execute();
            if (@$result) {
                return json_encode(["status" => 1, "message" => "Year added successfully"]);
            } else {
                return json_encode(["status" => 0, "message" => "Something went wrong"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

    public function select(){
        $query = $this->conn->prepare("SELECT year.id,year.name,(SELECT course.name from course where course.id=year.course) as course FROM year ORDER BY course");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getyear($id)
    {
        $query = $this->conn->prepare("SELECT id,name FROM year where course=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $years = $query->fetchAll(PDO::FETCH_ASSOC);
        return $years;
    }

    public function addyear($course, $year)
    {
        try {
            $query = $this->conn->prepare("SELECT * from year where name=:year and course=:course");
            $query->bindParam(':year', $year, PDO::PARAM_STR);
            $query->bindParam(':course', $course, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                $response=$this->create($course, $year);
                $response_data=json_decode($response,true);
                return json_encode(["status" => $response_data["status"], "message" => $response_data["message"]]);
            }else{
                return json_encode(["status" => 0, "message" => "Year Already Exists"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }
}

?>