<?php
require_once("../Class/subject.class.php");
use Subjects\Subject;
$addSubject = new Subject();
$response=$addSubject->addsubject($_POST["sem"],$_POST["subject"]);
echo $response;