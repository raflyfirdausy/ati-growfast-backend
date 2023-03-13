<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset("img/ayunda_white.png") ?>">
    <title><?= !empty($title) ? ($title . " | " . $_ENV["APP_SIMPLE_NAME"]) : $_ENV["APP_NAME"] ?></title>
    <link href="<?= template_nice_admin() ?>assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= template_nice_admin() ?>assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="<?= template_nice_admin() ?>assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= template_nice_admin() ?>assets/libs/select2/dist/css/select2.min.css">
    <link href="<?= template_nice_admin() ?>assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="<?= template_nice_admin() ?>dist/css/style.min.css" rel="stylesheet">

    <script src="<?= template_nice_admin() ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= template_nice_admin() ?>assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <link href="<?= template_nice_admin('assets/libs/sweetalert2/dist/sweetalert2.min.css'); ?>" rel="stylesheet">

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <script src="<?= asset('RFL_HELPER/RFL_core.js'); ?>"></script>
    <style>
        .swal-wide {
            width: 670px !important;
        }

        .swal-custom {
            width: 670px !important;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <div class="navbar-brand">
                        <a href="<?= base_url() ?>" class="logo">
                            <b class="logo-icon">
                                <img src="<?= asset("img/ayunda_white.png") ?>" style="width:35px;height:35px;" alt="homepage" class="dark-logo" />
                                <img src="<?= asset("img/ayunda_white.png") ?>" style="width:35px;height:35px;" alt="homepage" class="light-logo" />
                            </b>
                            <span class="logo-text text-white">
                                <?= $_ENV["APP_SIMPLE_NAME"] ?>
                            </span>
                        </a>
                        <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                            <i class="mdi mdi-toggle-switch mdi-toggle-switch-off font-20"></i>
                        </a>
                    </div>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item">
                            <div class="ml-2 d-none d-sm-block">
                                <a href="<?= base_url() ?>" target="_blank">
                                    <button type="button" class="btn waves-effect waves-light btn-dark">Lihat Website</button>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="m-l-5 font-medium d-none d-sm-inline-block"><?= $_session["nama"] ?> <i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <div class="d-flex no-block align-items-center p-15 bg-primary text-white m-b-10">
                                    <div class="">
                                        <img src="<?= asset("img/ayunda_white.png") ?>" alt="user" class="rounded-circle" width="60">
                                    </div>
                                    <div class="m-l-10">
                                        <h4 class="m-b-0"><?= $_session["nama"] ?></h4>
                                    </div>
                                </div>
                                <div class="profile-dis scrollable">
                                    <a class="dropdown-item" href="<?= base_url('Profile') ?>">
                                        <i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                                    <!-- <div class="dropdown-divider"></div> -->
                                    <a class="dropdown-item" href="<?= base_url("auth/logout") ?>">
                                        <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>