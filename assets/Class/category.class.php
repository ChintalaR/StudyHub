<?php
namespace Categories;
require_once('db.class.php');

use Db;
use PDO;
use PDOException;
class Category {
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }

    private function create($subject, $category)
    {
        try {
            $query = $this->conn->prepare("INSERT INTO category(subject,name) VALUES(:subject,:category)");
            $query->bindParam(":subject", $subject);
            $query->bindParam(":category", $category);
            $result = $query->execute();
            if (@$result) {
                return json_encode(["status" => 1, "message" => "Category added successfully"]);
            } else {
                return json_encode(["status" => 0, "message" => "Something went wrong"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }
    public function getcategory($subject)
    {
        $query=$this->conn->prepare("SELECT id,name FROM category WHERE subject=:subject");
        $query->bindParam(':subject',$subject);
        $query->execute();
        $subjects = $query->fetchAll(PDO::FETCH_ASSOC);
        return $subjects;
    }


    public function addcategory($subject, $category)
    {
        try {
            $query = $this->conn->prepare("SELECT * from category where name=:category and subject=:subject");
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(':subject', $subject, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                $response=$this->create($subject, $category);
                $response_data=json_decode($response,true);
                return json_encode(["status" => $response_data["status"], "message" => $response_data["message"]]);
            }else{
                return json_encode(["status" => 0, "message" => "Category Already Exists"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

}