<?php
require_once("../Class/year.class.php");
use Years\Year;
$addYear = new Year();
$response=$addYear->addyear($_POST["course"],$_POST["year"]);
echo $response;