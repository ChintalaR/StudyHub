<?php
require_once("../Class/category.class.php");
use Categories\Category;
$addCategory = new Category();
$response=$addCategory->addcategory($_POST["subject"],$_POST["category"]);
echo $response;