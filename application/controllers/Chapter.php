<?php

class Chapter extends \CI_Controller
{
    private $open_id = 'admin';

    function __construct()
    {
        parent::__construct();
        $_SESSION['open_id'] = $this->open_id;
        $this->load->model('ChapterModel', 'Chapter');
        $this->load->model('UserModel','User');
        $this->checklogin();
    }
    
    private function checklogin()
    {
        if (! $_SESSION['open_id']) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);die();
        }
        $student_id = $this->User->query_id($_SESSION['open_id']);
        if (! empty($student_id)) {
            $_SESSION['student_id'] = $student_id[0]['student_id'];
        } else {
            $data = array(
                'errno' => 100,
                'error' => '请先绑定'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    
    public function query_chapter()
    {
        $course_id = $this->input->post('course_id');
        $res = $this->Chapter->query_chapter($course_id);
        $resp['course_id']=$course_id;
        $resp['res'] = $res;
        echo json_encode($resp, JSON_UNESCAPED_UNICODE);
    }
    
    public function insert_chapter()
    {
        $name = $this->input->post('name');
        $course_id = $this->input->post('course_id');
        if ($name&&$course_id) {
            $data = array(
                'name' => trim($name),
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
        $id = $this->input->post('chapter_id');
        if ($this->Chapter->delete_chapter($id)) {
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
        $data['name'] = trim($this->input->post('name'));
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