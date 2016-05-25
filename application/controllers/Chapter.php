<?php

class Chapter extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
//         $_SESSION['unionid']="oIv6js6DeLN83bRCz-1oefOycwl8";
        $this->load->model('ChapterModel', 'Chapter');
        $this->load->model('CourseModel', 'Course');
        $this->load->model('UserModel','User');
        $this->checklogin();
    }
    
    private function checklogin()
    {
        if (!isset($_SESSION['unionid'])) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);die();
        }
    }
    
    public function query_chapter($course_id)
    {
        $result = $this->Course->query_one_course($course_id);
        $pass=array();
        if ($result) {
            $pass['course_name'] = $result[0]['name'];
            $pass['course_id'] = $result[0]['id'];
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
                show_404();
        }
        $res = $this->Chapter->query_chapter($course_id);
        $pass['res']=$res;
        $head = array('sidebar'=>2);
	    $this->load->view('templates/header',$head);
	    $this->load->view('mychapter',$pass);
	    $this->load->view('templates/footer');
    }
    
    public function insert_chapter()
    {
        $name = $this->input->post('name');
        $course_id = $this->input->post('course_id');
        
        $result = $this->Course->query_one_course($course_id);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        if ($name&&$course_id) {
            $data = array(
                'name' => trim($name),
                'unionid'=>$_SESSION['unionid'],
                'course_id' => $course_id
            );
            if ($this->Chapter->insert_chapter($data)) {
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
    
    public function delete_chapter()
    {
        $chapter_id = $this->input->post('chapter_id');
        $result = $this->Chapter->query_one_chapter($chapter_id);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        
        if ($this->Chapter->delete_chapter($chapter_id)) {
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
    
    public function update_chapter()
    {
        $data['id'] = $this->input->post('chapter_id');
        $data['name'] = $this->input->post('name');
        
        $result = $this->Chapter->query_one_chapter($data['id']);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        if ($data['id'] && $data['name']) {
            if ($this->Chapter->update_chapter($data)) {
    
                $data = array(
                    'errno' => 0
                );
            } else {
                $data = array(
                    'errno' => 102,
                    'error' => '更新失败，请再次尝试！'
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
}

?>