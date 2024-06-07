<?php

use Years\Year;

require_once("assets/Class/year.class.php");
$year = new Year();
$years=$year->select();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/Photos/StudyHub.png">
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <?php
    include("assets/includes/cdns.php");
    ?>
</head>

<body>

<div class="loaderClass">
    <img src="assets/Photos/loading.gif" alt="Loading...">
</div>
<div class="content">
    <form id="signup" method="post">
        <table>
            <tr>
                <td>
                    <h1>Sign Up</h1>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="email" placeholder="Email"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <select name="year">
                        <option value="">Select Year</option>
                        <?php
                        foreach ($years as $year) {
                            echo "<option value='".$year["id"]."'>".$year["course"]."-".$year["name"]."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="password" id="password" name="password" placeholder="Password"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="submit" value="Sign Up">
                </td>
                <td>
                    <a href="login"><label>Login</label></a>
                </td>
            </tr>
            <table>
    </form>
</div>
</body>
<script>
    $(document).ready(function(){
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "3000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        $(".loaderClass").css("display", "none");
        $("#signup").validate({
            rules: {
                email: {
                    required: true,
                    email:true
                },
                year:{
                    required:true,
                },
                password: {
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                email: {
                    required: "Email is required"
                },
                year:{
                    required:"Select Year",
                },
                password: {
                    required: "Password is required",
                },
                confirm_password: {
                    required: "Confirm Password is required",
                    equalTo: "Password doesn't match"
                },
            },
            errorClass: "text-danger",
            errorElement:"small",
            submitHandler: function(form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "assets/Exec/signup.php",
                    data: data,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    async: true,
                    cache: false,
                    beforeSend: function() {
                        $(".loaderClass").css("display", "flex");
                    },
                    success: function(data) {
                        $(".loaderClass").css("display", "none");
                        if (data.status == 1) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });
    });
</script>
</html>
