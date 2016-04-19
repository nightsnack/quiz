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

    function register_user()
    {
        $data['unionid'] = $_SESSION['unionid'];
        $data['student_id'] = $this->input->post('student_id');
        $data['name'] = $this->input->post('name');
        if ($data['unionid'] && $data['student_id'] && $data['name']) {
            
            if ($this->User->insert_user($data)) {
                $data = array(
                    'errno' => 0
                );
            } else {
                $data = array(
                    'errno' => 102,
                    'error' => '新增失败，请再次尝试！'
                );
            }
        } else {
            $data = array(
                'errno' => 103,
                'error' => '请将信息填写完整！'
            );
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function index()
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
            header('Location: http://fatimu.com/pop-quiz/');
        }
    }

    function check_login()
    {
        if (! isset($_SESSION['unionid'])) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        $user_info = $this->User->user_info($_SESSION['unionid']);
        if (empty($user_info)) {
            $insertdata = array(
                'unionid' => $_SESSION['unionid'],
                'nickname' => $_SESSION['nickname'],
                'createtime' => date('Y-m-d H:i:s')
            );
            $this->User->insert_user($insertdata);
        }
        $data = array(
            'detail' => $_SESSION['nickname']
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    function logout()
    {
        if (isset($_SESSION['unionid'])) {
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            header('Location: http://fatimu.com/pop-quiz/login.html');
            
        } else {
            header('Location: http://fatimu.com/pop-quiz/');
        }
    }
    
}

?>