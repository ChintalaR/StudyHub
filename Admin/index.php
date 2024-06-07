<?php
session_start();
if(@$_SESSION["admin_token"]){
    header("Location:home");
}else{
    header("Location:login");
}
?>