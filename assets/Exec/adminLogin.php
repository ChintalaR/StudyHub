<?php
session_start();
require_once("../Class/User.class.php");
use Users\User;
extract($_POST);
if(!@$email){
    return json_encode(["status"=>0,"message"=>"email is required"]);
}elseif (!@$password){
    return json_encode(["status"=>0,"message"=>"password is required"]);
}else{
    $user = new User();
    $login=$user->adminlogin($email,$password);
    $response=json_decode($login);
    if($response->status==1){
        $_SESSION["admin_token"]=$response->token;
        $_SESSION["flash"]=$response->message;
        echo json_encode(["status"=>$response->status,"message"=>$response->message,"token"=>true]);
    }else{
        echo json_encode(["status"=>$response->status,"message"=>$response->message,"error"=>@$response->error]);
    }
}