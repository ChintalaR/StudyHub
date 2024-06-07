<?php
require_once("../Class/sems.class.php");
use Sems\Sem;
$addSem = new Sem();
$response=$addSem->addsem($_POST["year"],$_POST["sem"]);
echo $response;