<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST,PUT, OPTIONS, DELETE');
header("Content-type: text/html;charset=utf-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');

class Course extends CI_Controller
{

//     private $unionid = 'admin';

    private $id;

    function __construct()
    {
        parent::__construct();
//         $_SESSION['unionid'] = $this->unionid;
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
        if (!isset($_SESSION['unionid'])) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function query_course()
    {
        $res = $this->Course->query_course($_SESSION['unionid']);
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
        $id = $this->id;
        // $id = $this->input->post('course_id');
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
        // $data['id'] = $this->input->post('course_id');
        // $data['name'] = trim($this->input->post('name'));
        $input = file_get_contents("php://input");
        $json = json_decode($input);
        (! empty($json->id)) ? ($data['id'] = $json->id) : die('{"errno":103,"error":"请将信息填写完整！"}');
        (! empty($json->name)) ? ($data['name'] = $json->name) : die('{"errno":103,"error":"请将信息填写完整！"}');
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