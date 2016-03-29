<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST,PUT, OPTIONS, DELETE');
header("Content-type: text/html;charset=utf-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');

class Course extends CI_Controller
{

    private $open_id = 'admin';

    private $id;

    function __construct()
    {
        parent::__construct();
        $_SESSION['open_id'] = $this->open_id;
        $this->load->model('CourseModel', 'Course');
        $this->load->model('UserModel', 'User');
        $this->checklogin();
    }

    function index($id = '')
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $this->id = $id;
        $this->switchMethod($method);
    }

    private function switchMethod($method)
    {
        switch ($method) {
            case 'GET':
                $this->query_course();
                break;
            case 'PUT':
                $this->update_course();
                break;
            case 'POST':
                $this->insert_course();
                break;
            case 'DELETE':
                $this->delete_course();
                break;
        }
    }

    private function checklogin()
    {
        if (! $_SESSION['open_id']) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
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

    public function query_course()
    {
        $res = $this->Course->query_course($_SESSION['open_id']);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function insert_course()
    {
        // echo $name = $this->input->post('name');
        $input = file_get_contents("php://input");
        $json = json_decode($input);
        (! empty($json->name)) ? ($name = $json->name) : die('{"errno":103,"error":"请将信息填写完整！"}');
        if ($name) {
            $data = array(
                'name' => trim($name),
                'user_id' => $_SESSION['open_id']
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
        $id = $this->id;
        // $id = $this->input->post('course_id');
        $result = $this->Course->query_one_course($id);
        if ($result) {
            if ($result[0]['open_id'] !== $_SESSION['open_id']) 
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
        // $data['id'] = $this->input->post('course_id');
        // $data['name'] = trim($this->input->post('name'));
        $input = file_get_contents("php://input");
        $json = json_decode($input);
        (! empty($json->id)) ? ($data['id'] = $json->id) : die('{"errno":103,"error":"请将信息填写完整！"}');
        (! empty($json->name)) ? ($data['name'] = $json->name) : die('{"errno":103,"error":"请将信息填写完整！"}');
        $result = $this->Course->query_one_course($data['id']);
        if ($result) {
            if ($result[0]['open_id'] !== $_SESSION['open_id']) 
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