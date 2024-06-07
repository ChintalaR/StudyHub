<?php
require_once('../Class/course.class.php');
use Courses\Course;
$course = new Course();
$courses=$course->select();
echo $courses;