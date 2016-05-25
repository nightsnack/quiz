<?php

class Course extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
//         $_SESSION['unionid']="oIv6js6DeLN83bRCz-1oefOycwl8";
        $this->load->model('CourseModel', 'Course');
        $this->load->model('UserModel', 'User');
        $this->checklogin();
    }


    private function checklogin()
    {
        if (!isset($_SESSION['unionid'])) {
            redirect(site_url('User/show_login'));
        }
    }

    public function query_course()
    {
        $res = $this->Course->query_course($_SESSION['unionid']);
        $pass['res'] = $res;
        $head = array('sidebar'=>2);
	    $this->load->view('templates/header',$head);
	    $this->load->view('mycourse',$pass);
	    $this->load->view('templates/footer');
    }

    public function insert_course()
    {
        $name = $this->input->post('name');
        if ($name) {
            $data = array(
                'name' => trim($name),
                'unionid' => $_SESSION['unionid']
            );
            if ($this->Course->insert_course($data)) {
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

    public function delete_course()
    {
        $id = $this->input->post('course_id');
        $result = $this->Course->query_one_course($id);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid']) 
                die('{"errno":105,"error":"非法进入！"}');
        }
        if ($this->Course->delete_course($id)) {
            $data = array(
                'errno' => 0
            );
        } else {
            $data = array(
                'errno' => 102,
                'error' => '删除失败，请再次尝试！'
            );
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function update_course()
    {
        $data['id'] = $this->input->post('course_id');
        $data['name'] = trim($this->input->post('name'));
   
        $result = $this->Course->query_one_course($data['id']);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid']) 
                die('{"errno":105,"error":"非法进入！"}');
        }
        if ($this->Course->update_course($data)) {
            
            $data = array(
                'errno' => 0
            );
        } else {
            $data = array(
                'errno' => 102,
                'error' => '更新失败，请再次尝试！'
            );
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

?>