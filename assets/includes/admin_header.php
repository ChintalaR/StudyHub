<?php
session_start();
if(!@$_SESSION["admin_token"]){
    header("location:login");
    die();
}?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/apps-calendar-month-grid.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 17 May 2024 08:52:56 GMT -->

<head>

    <meta charset="utf-8" />
    <title>StudyHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/Photos/StudyHub.png">

    <!-- Layout config Js -->
    <script src="../assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- quill css -->
    <link href="../assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />
    <!--datatable css-->
<!--    <link rel="stylesheet" href="../assets/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />-->
    <!--datatable responsive css-->
<!--    <link rel="stylesheet" href="../assets/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />-->
<!--    <link rel="stylesheet" href="../assets/cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">-->
    <!--datatable js-->
    <script src="../assets/code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<!--    <script src="../assets/cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>-->
<!--    <script src="../assets/cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>-->
<!--    <script src="../assets/cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>-->
<!--    <script src="../assets/cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>-->
<!--    <script src="../assets/cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>-->
<!--    <script src="../assets/js/pages/datatables.init.js"></script>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">
    <button type="button"
            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger material-shadow-none"
            id="topnav-hamburger-icon">
            <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
    </button>


    <div class="app-menu navbar-menu">
        <div class="navbar-brand-box">
            <a href="home" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../assets/Photos/StudyHub.png" alt="" height="22">
                    </span>
                <span class="logo-lg">
                        <img src="../assets/Photos/StudyHub.png" alt="" height="75">
                    </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                    <a class="nav-link menu-link" href="home" role="button">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Users</span>
                    </a>
                    <a class="nav-link menu-link" href="materials" role="button">
                        <i class="ri-pencil-ruler-2-line"></i> <span data-key="t-authentication">Materials</span>
                    </a>
<!--                    <a class="nav-link menu-link" href="addmaterials" role="button">-->
<!--                        <i class="ri-add-box-line"></i> <span data-key="t-authentication">Add Materials</span>-->
<!--                    </a>-->
                    <a class="nav-link menu-link" href="notifications" role="button">
                        <i class="bx bx-bell fs-22"></i> <span data-key="t-authentication">Notifications</span>
                    </a>
                    <a class="nav-link menu-link" href="logout" role="button">
                        <i class="ri-logout-circle-r-line"></i> <span data-key="t-authentication">Logout</span>
                    </a>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->