<?php
require_once("../Class/User.class.php");
use Users\User;
extract($_POST);
if(!@$email){
    return json_encode(["status"=>0,"message"=>"email is required","error"=>"undefined Email"]);
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    return json_encode(["status"=>0,"message"=>"Invalid email format","error"=>"Invalid email format"]);
}elseif (!@$password){
    return json_encode(["status"=>0,"message"=>"Password is required","error"=>"undefined Password"]);
}elseif (!@$year){
    return json_encode(["status"=>0,"message"=>"Select Year","error"=>"undefined Password"]);
}else{
    $user = new User();
    $signup=$user->signup($email,$password,$year);
    $response=json_decode($signup);
    if($response->status==1){
        echo json_encode(["status"=>$response->status,"message"=>$response->message]);
    }else{
        echo json_encode(["status"=>$response->status,"message"=>$response->message]);
    }
}