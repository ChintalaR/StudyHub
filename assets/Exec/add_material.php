<?php
require_once("../Class/material.class.php");
use Materials\Material;
$addMaterial = new Material();
$name=$_POST["material"];
$file=$_FILES["file"];
$response=$addMaterial->addmaterial($_POST["material"],$_POST["category"],$file);
echo $response;