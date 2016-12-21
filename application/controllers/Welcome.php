<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    
    /**
     * 输入url后映射到这个方法上，若未登录，有code调到有code登录，无code调无code登录
     * 已登录：code 展示有code 的界面，无code展示入口界面
     * @param number $code
     */
	public function index()
	{
	    $code = $this->input->get('sharecode');
	
// 	    $_SESSION['unionid']="oIv6js6DeLN83bRCz-1oefOycwl8";
// 	    $_SESSION['nickname']="吃夜宵";
	     
	    if (! isset($_SESSION['unionid'])) {
	        if ($code)
	            redirect(site_url("User/show_login/$code"));
	        else 
	            redirect(site_url("User/show_login"));
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
	    $pass = array(
	        'nickname' => $_SESSION['nickname']
	    );
	    if ($code) {
	        $share_detail = $this->cache->memcached->get($code);
	        if ($share_detail) {
	            $pass = $share_detail;
	            $pass['nickname'] = $_SESSION['nickname'];
	            $pass['code'] = $code;
	            if (substr($code, 0,1)=='k')
	            {
	                $this->load->view('templates/shareheader');
	                $this->load->view('sharepageforcourse',$pass);
	                $this->load->view('templates/footer');
	            } else {
	                $this->load->view('templates/shareheader');
	                $this->load->view('sharepage',$pass);
	                $this->load->view('templates/footer');
	            }
	        } else {
	            $head = array('sidebar'=>1);
	            $this->load->view('templates/header',$head);
	            $this->load->view('controlpannel',$pass);
	            $this->load->view('templates/footer');
	        }
	    }else {
	        $head = array('sidebar'=>1);
	        $this->load->view('templates/header',$head);
	        $this->load->view('controlpannel',$pass);
	        $this->load->view('templates/footer');
	    }
	    
	}
}
