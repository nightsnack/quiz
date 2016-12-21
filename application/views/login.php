<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>呱呱作业——登录</title>
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
    <script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
    
    
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>呱呱作业</b>管理后台</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">使用微信扫描二维码以登录</p>

    <form action="#" method="post">
      <div class="form-group has-feedback" id="login_container">

          
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<!-- jQuery 2.1.4 -->
        <script>
            var obj = new WxLogin({
              id: "login_container",
              appid: "wx61583b0e10f37ee4",
              scope: "snsapi_login",
              redirect_uri: encodeURIComponent("<?php echo 'http://www.fatimu.com/quiz/index.php/User/index';if (!empty($code)) echo "/$code"?>"),
              state: Math.ceil(Math.random()*1000),
              style: "black",
              href: ""});
        </script>

</body>
</html>
