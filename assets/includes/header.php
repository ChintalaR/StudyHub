<?php
session_start();
require_once("assets/Class/notification.class.php");
use Notifications\Notification;
$notification = new Notification();
$notifications=$notification->getNotification($_SESSION['year']);
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<base target="_self">
<link rel="icon" href="assets/Photos/StudyHub.png">
<link rel="stylesheet" href="assets/css/style.css">
<!-- App Css-->
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css"/>
<title>Study Hub</title>

<!--Body Starts Here-->
<body id="body">
<div id="menu" class="text-end">
    <button id="notification" class="icons fa fa-bell"></button>
    <a href="logout">
        <button class="icons fa fa-sign-out-alt"></button>
    </a>
</div>
<div id="notifications" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body text-start">
                    <ul>
                    <?php foreach ($notifications as $notification){ ?>
                        <li><?php echo $notification["content"] ?></li>
                    <?php } ?>
                    </ul>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
<!--            </form>-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function (){
        $(document).on("click","#notification",function (){
            $("#notifications").modal("show");
        });
    });
</script>