<?php

class Course extends CI_Controller
{

    private $userid = 'admin';

    function __construct()
    {
        parent::__construct();
        $_SESSION['user_id'] = $this->userid;
        $this->checklogin();
        $this->load->model('CourseModel', 'Course');
    }

    private function checklogin()
    {
        if (! $_SESSION['user_id']) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    public function query_course()
    {
        $res = $this->Course->query_course($_SESSION['user_id']);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function insert_course()
    {
        $name = $this->input->post('name');
        if ($name) {
            $data = array(
                'name' => trim($name),
                'user_id' => $_SESSION['user_id']
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
        if ($data['id'] && $data['name']) {
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