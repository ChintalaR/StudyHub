<?php
session_start();
require_once('../Class/course.class.php');

use Courses\Course;
extract($_POST);
$courses = new Course();
if (@$_SESSION["admin_token"]) {
    if (@$course) {
        $response=$courses->add($course);
        echo $response;
    } else {
        echo json_encode(["status" => 0, "message" => "Course Name is Required"]);
    }
} else {
    echo "forbidden access";
}