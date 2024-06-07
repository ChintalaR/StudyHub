<?php

namespace Sems;
require_once('db.class.php');

use Db;
use PDO;
use PDOException;

class Sem
{
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }

    public function getsems($year)
    {
        $query=$this->conn->prepare("SELECT id,name FROM sems WHERE year=:year");
        $query->bindParam(':year',$year);
        $query->execute();
        $sems = $query->fetchAll(PDO::FETCH_ASSOC);
        return $sems;
    }

    private function create($year,$sem)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO sems(year,name) VALUES(:year,:sem)");
            $query->bindParam(":year", $year);
            $query->bindParam(":sem", $sem);
            $result = $query->execute();
            if (@$result) {
                return json_encode(["status" => 1, "message" => "Sem added successfully"]);
            } else {
                return json_encode(["status" => 0, "message" => "Something went wrong"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }

    }

    public function addsem($year,$sem){
        try {
            $query = $this->conn->prepare("SELECT * from sems where name=:sem and year=:year");
            $query->bindParam(':sem', $sem, PDO::PARAM_STR);
            $query->bindParam(':year', $year, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                $response=$this->create($year,$sem);
                $response_data=json_decode($response,true);
                return json_encode(["status" => $response_data["status"], "message" => $response_data["message"]]);
            }else{
                return json_encode(["status" => 0, "message" => "Sem Already Exists"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }
}