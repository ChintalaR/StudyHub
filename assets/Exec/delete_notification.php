<?php
require_once("../Class/notification.class.php");

use Notifications\Notification;
$addNotification = new Notification();
$response = $addNotification->delete($_POST["id"]);
echo $response;