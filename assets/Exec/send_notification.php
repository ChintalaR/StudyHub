<?php
require_once("../Class/notification.class.php");
use Notifications\Notification;
$addNotification = new Notification();
if($_POST["content"]=="<p><br></p>"){
    echo json_encode(["status"=>0,"message"=>"Notification cannot be Empty!"]);
}elseif(!@$_POST["years"]){
    echo json_encode(["status"=>0,"message"=>"Select Year!"]);
}else{
$response=$addNotification->sendNotification($_POST["content"],$_POST["years"]);
echo $response;
}