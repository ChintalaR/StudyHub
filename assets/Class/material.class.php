<?php

namespace Materials;
require_once('db.class.php');

use Db;
use PDO;
use PDOException;

class Material
{
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }
    public function getmaterial($id)
    {
        $query = $this->conn->prepare("SELECT id,name,file FROM materials where category=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    private function create($material,$category,$file)
    {
        try {
            $target_dir = "../uploads/";
            $target_file = $target_dir .time(). basename($_FILES["file"]["name"]);
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            $name=str_replace("../","",$target_file);
            $material_file=ASSET.$name;
            $query = $this->conn->prepare("INSERT INTO materials(name,category,file) VALUES(:material,:category,:file)");
            $query->bindParam(":material", $material);
            $query->bindParam(":category", $category);
            $query->bindParam(":file", $material_file);
            $result = $query->execute();
            if (@$result) {
                return json_encode(["status" => 1, "message" => "Material added successfully"]);
            } else {
                return json_encode(["status" => 0, "message" => "Something went wrong"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }

    public function addmaterial($material, $category, $file)
    {
        try {
            $query = $this->conn->prepare("SELECT * from materials where name=:material and category=:category");
            $query->bindParam(':material', $material, PDO::PARAM_STR);
            $query->bindParam(':category', $category, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                $response=$this->create($material, $category, $file);
                $response_data=json_decode($response,true);
                return json_encode(["status" => $response_data["status"], "message" => $response_data["message"]]);
            }else{
                return json_encode(["status" => 0, "message" => "Material Already Exists"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => $e->getMessage()]);
        }
    }
}