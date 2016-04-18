<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST,PUT, OPTIONS, DELETE');
header("Content-type: text/html;charset=utf-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');
class Chapter extends CI_Controller
{
//     private $unionid = 'admin';

    function __construct()
    {
        parent::__construct();
//         $_SESSION['unionid'] = $this->unionid;
        $this->load->model('ChapterModel', 'Chapter');
        $this->load->model('CourseModel', 'Course');
        $this->load->model('UserModel','User');
        $this->checklogin();
    }
    
    function index($id='')
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $this->id = $id;
        $this->switchMethod($method);
    }
    
    private function switchMethod($method)
    {
        switch ($method) {
            case 'GET':
                $this->query_chapter();
                break;
            case 'PUT':
                $this->update_chapter();
                break;
            case 'POST':
                $this->insert_chapter();
                break;
            case 'DELETE':
                $this->delete_chapter();
                break;
        }
    }
    
    private function checklogin()
    {
        if (! $_SESSION['unionid']) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);die();
        }
        $student_id = $this->User->query_id($_SESSION['unionid']);
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
        
        $result = $this->Course->query_one_course($course_id);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        $res = $this->Chapter->query_chapter($course_id);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
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
    
    private function delete_chapter()
    {
        $result = $this->Chapter->query_one_chapter($this->id);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        
        if ($this->Chapter->delete_chapter($this->id)) {
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
        $input = file_get_contents("php://input");
        $json = json_decode($input);
        (! empty($json->id)) ? ($data['id'] = $json->id) : die('{"errno":103,"error":"请将信息填写完整！"}');
        (! empty($json->name)) ? ($data['name'] = $json->name) : die('{"errno":103,"error":"请将信息填写完整！"}');
        
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