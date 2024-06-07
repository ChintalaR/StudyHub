<?php
require_once("../Class/User.class.php");
use Users\User;
extract($_POST);
if(!@$email){
    return json_encode(["status"=>0,"message"=>"email is required"]);
}elseif (!@$password){
    return json_encode(["status"=>0,"message"=>"password is required"]);
}else{
    $user = new User();
    $login=$user->login($email,$password);
    $response=json_decode($login);
    if($response->status==1){
        $_SESSION['token']=$response->token;
        $_SESSION['flash']=$response->message;
        $_SESSION["year"]=$response->year;
        echo json_encode(["status"=>$response->status,"message"=>$response->message,"token"=>true]);
    }else{
        echo json_encode(["status"=>$response->status,"message"=>$response->message,"error"=>@$response->error]);
    }
}