<?php
header("Content-type: text/html; charset=utf-8");
require_once('Oauther.php');


class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel','Answer');
        $this->load->model('AccessCodeModel','Accesscode');
        $this->load->model('UserModel','User');
        $this->load->driver('cache');
    }
    function register_user()
    {
        $data['unionid'] = $_SESSION['unionid'];
        $data['student_id'] = $this->input->post('student_id');
        $data['name'] = $this->input->post('name');
        $this->load->Model('UserModel','User');
        if ($data['unionid']&&$data['student_id']&&$data['name']) {
            
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
        if (!isset($_GET["code"])){
            $redirect_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $jumpurl = $weixin->qrconnect($redirect_url, "snsapi_login", "123");
            Header("Location: $jumpurl");
        }else{
            $oauth2_info = $weixin->oauth2_access_token($_GET["code"]);
            $userinfo = $weixin->oauth2_get_user_info($oauth2_info['access_token'], $oauth2_info['openid']);
            $_SESSION['unionid']=$userinfo['unionid'];
            var_dump($userinfo);
            header('Location: http://fatimu.com/pop-quiz/');
        }
    }
    
    function check_login()
    {
        if (!isset( $_SESSION['unionid'])) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        $student_id = $this->User->query_id($_SESSION['unionid']);
        if(!empty($student_id)){
            $_SESSION['student_id'] = $student_id[0]['student_id'];
        } else {
            $data = array(
                'errno' => 100,
                'error' => '请先绑定'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        $data = array(
                'detail' => $student_id[0]['name']
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
    }
}

?>