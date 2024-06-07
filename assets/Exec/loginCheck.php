<?php
require_once("../Class/User.class.php");
use Users\User;
$token = explode(" ", apache_request_headers()['Authorization'])[1];
$user=new User();
$response=$user->loginCheck($token);
echo $response;