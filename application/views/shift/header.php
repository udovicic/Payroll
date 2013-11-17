<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>Satnica - <?php echo $title ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/jquery-ui.timepicker.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/main.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/shift.css">

        <script src="<?php echo base_url() ?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="<?php echo base_url() ?>js/vendor/jquery-1.10.1.min.js"></script>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url() ?>">Satnica</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id="menu-add"><a href="<?php echo site_url('/shift/add'); ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo lang('add'); ?></a></li>
                        <li id="menu-report"><a href="<?php echo site_url('/shift/report'); ?>"><span class="glyphicon glyphicon-th-list"></span> <?php echo lang('report'); ?></a></li>
                        <li id="menu-pdf"><a href="<?php echo site_url('/shift/pdf'); ?>"><span class="glyphicon glyphicon-file"></span> <?php echo lang('pdf'); ?></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $username ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('/user/profile'); ?>"><span class="glyphicon glyphicon-wrench"></span> <?php echo lang('profile'); ?></a></li>
                                <li><a href="<?php echo site_url('/user/logout'); ?>"><span class="glyphicon glyphicon-log-out"></span> <?php echo lang('sign_out'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.navbar-collapse -->
            </div>
        </div>

        <!-- content -->
        <div class="container">
