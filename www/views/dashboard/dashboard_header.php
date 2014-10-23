<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>工时管理系统</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
		<script src="/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="/media/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="/media/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/daterangepicker.css" rel="stylesheet" type="text/css" />
	<link href="/media/css/fullcalendar.css" rel="stylesheet" type="text/css"/>
	<link href="/media/css/jqvmap.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="/media/css/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="/media/image/favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="/dashboard">
				<!-- <img src="/media/image/logo.png1" alt=""/> -->
					<!-- <h3>生仪综素</h3> -->
				<strong>工时管理系统</strong>

				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="/media/image/menu-toggler.png" alt="" />
				</a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN TOP NAVIGATION MENU -->
				<ul class="nav pull-right">
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="/media/image/avatar1_small.jpg" />
						<span class="username"><?=@$account_name?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="/dashboard/logout"><i class="icon-key"></i>退出</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
				</li>
				<?php if ($user_role & 0b1000 ) { ?>
				<li class="">
					<a href="/dashboard/newuser">
					<i class="icon-cogs"></i>
					<span class="title">新建员工</span>
					</a>
				</li>
				<li class="">
					<a href="/dashboard/newproject">
					<i class="icon-bookmark-empty"></i>
					<span class="title">新建项目</span>
					</a>
				</li>
				<li class="">
					<a href="/dashboard/newunit">
					<i class="icon-briefcase"></i>
					<span class="title">新建单位</span>
					</a>
				</li>
				<li class="">
					<a href="/dashboard/BossSearchProject">
					<i class="icon-table"></i>
					<span class="title">查看项目/添加项目员工</span>
					</a>
				</li> <? }
				if ($user_role & 0b0001){
				?>
				<li class="">
					<a href="/dashboard/UsrSearchProject">
					<i class="icon-table"></i>
					<span class="title">查看我的项目</span>
					</a>
				</li><? }
				if ($user_role & 0b0010){
				?>
				<li class="">
					<a href="/dashboard/SHProject">
					<i class="icon-table"></i>
					<span class="title">审核我的项目</span>
					</a>
				</li><? }
				if ($user_role & 0b0100){
				?>
				<li class="">
					<a href="/dashboard/ProjectJZ">
					<i class="icon-table"></i>
					<span class="title">结账</span>
					</a>
				</li>
				<?}?>

			</ul>
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">
							管理中心 <!-- <small>相关信息管理</small> -->
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="#">Home</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#"><?=@$now_stage?></a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->