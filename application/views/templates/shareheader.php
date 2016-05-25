<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>呱呱作业</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/css/font-awesome.min.css')?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css')?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skin-blue.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/edit.css')?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="<?php echo base_url('assets/js/jquery.min.js')?>" ></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>" ></script>
        <script src="<?php echo base_url('assets/js/adminlte.js')?>" ></script>
        <script src="<?php echo base_url('assets/js/jquery-validation/jquery.validate.js')?>" ></script>
    
    
</head>

<body class="hold-transition skin-blue layout sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>呱</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>呱呱</b>作业</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                
                <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu open">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">1</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">收到好友的分享</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                      <li><!-- start message -->
                        <a>
                          <div class="pull-left">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            课程章节的题目
                            <small><i class="fa fa-clock-o"></i>20分钟前</small>
                          </h4>
                          <p>课程章节的题目</p>
                        </a>
                        
                      </li><!-- end message -->
                      
                    </ul></div>
                  </li>
                </ul>
              </li>
              <li class="dropdown user user-menu">
                <a class="dropdown-toggle">
                    <span class="hidden-xs"><b>欢迎您</b></span>
                </a>
              </li>
            <li>
                <a href="../quiz/index.php/User/logout" id='logout'><i class="fa fa-sign-out fa-lg"></i></a>
            </li>
        
              
            </ul>
          </div>
                
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav" id="pagehead">
                        
                    </ul>
                </div>

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <section class="sidebar">
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu">
                    <li class="header">服务列表</li>
                    <!-- Optionally, you can add icons to the links -->
                    <li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> <span>控制台</span></a></li>
                    
                    <li><a href="<?php echo site_url('Course/query_course')?>"><i class="fa fa-briefcase"></i> <span>我的课程</span></a>
                    <li class="active"><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> <span>分享<small class="label pull-right bg-red">1</small></span></a></li>
                    
                    </li>
                    
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>