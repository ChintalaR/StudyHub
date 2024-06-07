<?php
include("assets/includes/cdns.php");
?>
<script>
    $(document).ready(function(){
        var token = sessionStorage.getItem("token");
        if (!token) {
            window.location.href = 'login';
        }else{
            window.location.href='home';
        }
    });
</script>
