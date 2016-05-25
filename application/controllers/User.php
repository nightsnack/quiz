<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST,PUT, OPTIONS, DELETE');
header("Content-type: text/html;charset=utf-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');
require_once ('Oauther.php');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel', 'Answer');
        $this->load->model('AccessCodeModel', 'Accesscode');
        $this->load->model('UserModel', 'User');
        $this->load->driver('cache');
        date_default_timezone_set("Asia/Shanghai");
    }
    
    function show_login($sharecode = 0)
    {
        $pass = array(
            'code'=>$sharecode
        );
        $this->load->view('login',$pass);
    }

    function index($sharecode=0)
    {
        $weixin = new class_weixin();
        if (! isset($_GET["code"])) {
            $redirect_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $jumpurl = $weixin->qrconnect($redirect_url, "snsapi_login", "123");
             Header("Location: $jumpurl");
        } else {
            $oauth2_info = $weixin->oauth2_access_token($_GET["code"]);
            $userinfo = $weixin->oauth2_get_user_info($oauth2_info['access_token'], $oauth2_info['openid']);
            $_SESSION['unionid'] = $userinfo['unionid'];
            $_SESSION['nickname'] = $userinfo['nickname'];
            $url = site_url('');
            if (!empty($sharecode)) 
                $url.= "?sharecode=$sharecode";

            redirect($url);
        }
    }
    
    function logout()
    {
        if (isset($_SESSION['unionid'])) {
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            redirect(site_url());
            
        } else {
            redirect(site_url());
        }
    }
    
}

?>