<?php
session_start();
if(@$_SESSION['admin_token']){
    header("Location:index");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../assets/Photos/StudyHub.png">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <?php
    include("../assets/includes/cdns.php");
    ?>
</head>
<body>
<div class="loaderClass">
    <img src="../assets/Photos/loading.gif" alt="Loading...">
</div>
<div class="content">
    <form id="login" method="post">
        <table>
            <tr>
                <td><h1>Login</h1></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><input type="text" name="email" placeholder="Email" autocomplete="email"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="password" name="password" placeholder="Password"
                                       autocomplete="current-password"></td>
            </tr>
            <tr>
                <td colspan="2" class="text-end"><input type="submit" name="submit" value="Login"></td>
            </tr>
    </form>
</div>
</body>
<script>
    $(document).ready(function () {
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
        $("#login").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "Email is required"
                },
                password: {
                    required: "Password is required"
                },
            },
            errorClass: "text-danger",
            errorElement: "small",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/adminLogin.php",
                    data: data,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    async: true,
                    cache: false,
                    beforeSend: function () {
                        $(".loaderClass").css("display", "flex");
                    },
                    success: function (data) {
                        $(".loaderClass").css("display", "none");
                        if (data.status == 1) {
                            // toastr.success(data.message);
                            window.location.href = 'home';
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