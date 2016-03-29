<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST,PUT, OPTIONS, DELETE');
header("Content-type: text/html;charset=utf-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');
require_once 'JSON.php';

class Question extends CI_Controller
{

    private $open_id = 'admin';

    private $pictureurl = 'oss.dmsq.com/';

    function __construct()
    {
        parent::__construct();
        $_SESSION['open_id'] = $this->open_id;
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('ChapterModel', 'Chapter');
        
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
            case 'DELETE':
                $this->delete_question();
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

    public function query_question()
    {
        $chapter_id = $this->input->post('chapter_id');
        $res = $this->Question->query_question($chapter_id);
        if ($res) {
            if ($res[0]['open_id'] !== $_SESSION['open_id'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        $temp = $this->Question->query_recent_count($chapter_id);
        for ($i = 0; $i < count($res); $i ++) {
            $res[$i]['percentation'] = ($res[$i]['correct'] / $res[$i]['sum']) * 100;
            if (! $res[$i]['correct'])
                $res[$i]['correct'] = 1; // 当存储答题信息的表里没有该题的记录时，要把这个正确人数记为1
            if (isset($temp[$i])) {
                $res[$i]['recent_sum'] = $temp[$i]['recent_sum'];
                $res[$i]['recent_correct'] = $temp[$i]['recent_correct'];
                $res[$i]['percentation_re'] = ($res[$i]['recent_correct'] / $res[$i]['recent_sum']) * 100;
            } else {
                $res[$i]['recent_sum'] = 1;
                $res[$i]['recent_correct'] = 1;
                $res[$i]['percentation_re'] = 100;
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function insert_question()
    {
        $insert_data['chapter_id'] = $this->input->post('chapter_id');
        $insert_data['open_id'] = $_SESSION['open_id'];
        $insert_data['type'] = $this->input->post('type');
        $insert_data['content'] = trim($this->input->post('content'));
        $insert_data['answer'] = $this->input->post('answer'); // 如果是填空，直接发字符串
        
        $res = $this->Chapter->query_one_chapter($insert_data['chapter_id']);
        if ($res) {
            if ($res[0]['open_id'] !== $_SESSION['open_id'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        $flag = 1;
        foreach ($insert_data as $temp) {
            if (is_null($temp)) {
                $flag = 0;
                break;
            }
        }
        if ($flag) {
            if ($this->Question->insert_question($insert_data)) {
                $data = array(
                    'errno' => 0,
                    'chapter_id' => $insert_data['chapter_id']
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

    public function delete_question()
    {
        $id = $this->id;
        
        $res = $this->Question->query_one_question($id);
        if ($res) {
            if ($res[0]['open_id'] !== $_SESSION['open_id'])
                die('{"errno":105,"error":"非法进入！"}');
        }

        if ($this->Question->delete_question($id)) {
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

    public function show_update_question()
    {
        $question_id = $this->input->post('question_id');
        
        $res = $this->Question->query_one_question($question_id);
        if ($res) {
            if ($res[0]['open_id'] !== $_SESSION['open_id'])
                die('{"errno":105,"error":"非法进入！"}');
            echo json_encode($res[0], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     */
    public function update_question()
    {
        $update_data['id'] = $this->input->post('question_id');
        $update_data['type'] = $this->input->post('type');
        $update_data['content'] = trim($this->input->post('content'));
        $update_data['answer'] = $this->input->post('answer'); // 如果是填空，直接发字符串
        
        $res = $this->Question->query_one_question($update_data['id']);
        if ($res) {
            if ($res[0]['open_id'] !== $_SESSION['open_id'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        $flag = 1;
        foreach ($update_data as $temp) {
            if (is_null($temp)) {
                $flag = 0;
                break;
            }
        }
        if ($flag) {
            if ($this->Question->update_question($update_data)) {
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

    public function upload_json()
    {
        $php_path = dirname(__FILE__) . '/';
        $php_url = dirname($_SERVER['PHP_SELF']) . '/';
        
        // 文件保存目录路径
        $save_path = $php_path . '../../attached/';
        // 文件保存目录URL
        $save_url = $php_url . '../../attached/';
        // 定义允许上传的文件扩展名
        $ext_arr = array(
            'image' => array(
                'gif',
                'jpg',
                'jpeg',
                'png',
                'bmp'
            )
        );
        // 最大文件大小
        $max_size = 100000;
        
        $save_path = realpath($save_path) . '/';
        
        // PHP上传失败
        if (! empty($_FILES['imgFile']['error'])) {
            switch ($_FILES['imgFile']['error']) {
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            $this->alert($error);
        }
        
        // 有上传文件时
        if (empty($_FILES) === false) {
            // 原文件名
            $file_name = $_FILES['imgFile']['name'];
            // 服务器上临时文件名
            $tmp_name = $_FILES['imgFile']['tmp_name'];
            // 文件大小
            $file_size = $_FILES['imgFile']['size'];
            // 检查文件名
            if (! $file_name) {
                $this->alert("请选择文件。");
            }
            // 检查目录
            if (@is_dir($save_path) === false) {
                $this->alert("上传目录不存在。");
            }
            // 检查目录写权限
            if (@is_writable($save_path) === false) {
                $this->alert("上传目录没有写权限。");
            }
            // 检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                $this->alert("上传失败。");
            }
            // 检查文件大小
            if ($file_size > $max_size) {
                $this->alert("上传文件大小超过限制。");
            }
            // 检查目录名
            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
            if (empty($ext_arr[$dir_name])) {
                $this->alert("目录名不正确。");
            }
            // 获得文件扩展名
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            // 检查扩展名
            if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
                $this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
            }
            // 创建文件夹
            if ($dir_name !== '') {
                $save_path .= $dir_name . "/";
                $save_url .= $dir_name . "/";
                if (! file_exists($save_path)) {
                    mkdir($save_path);
                }
            }
            $ymd = date("Ymd");
            $save_path .= $ymd . "/";
            $save_url .= $ymd . "/";
            if (! file_exists($save_path)) {
                mkdir($save_path);
            }
            // 新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            // 移动文件
            $file_path = $save_path . $new_file_name;
            if (move_uploaded_file($tmp_name, $file_path) === false) {
                $this->alert("上传文件失败。");
            }
            @chmod($file_path, 0644);
            $file_url = $save_url . $new_file_name;
            
            header('Content-type: text/html; charset=UTF-8');
            $json = new Services_JSON();
            echo $json->encode(array(
                'error' => 0,
                'url' => $file_url
            ));
            exit();
        }
    }

    public function file_manager_json()
    {
        $php_path = dirname(__FILE__) . '/';
        $php_url = dirname($_SERVER['PHP_SELF']) . '/';
        
        // 根目录路径，可以指定绝对路径，比如 /var/www/attached/
        $root_path = $php_path . '../../attached/';
        // 根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
        $root_url = $php_url . '../../attached/';
        // 图片扩展名
        $ext_arr = array(
            'gif',
            'jpg',
            'jpeg',
            'png',
            'bmp'
        );
        
        // 目录名
        $dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
        if (! in_array($dir_name, array(
            '',
            'image',
            'flash',
            'media',
            'file'
        ))) {
            echo "Invalid Directory name.";
            exit();
        }
        if ($dir_name !== '') {
            $root_path .= $dir_name . "/";
            $root_url .= $dir_name . "/";
            if (! file_exists($root_path)) {
                mkdir($root_path);
            }
        }
        
        // 根据path参数，设置各路径和URL
        if (empty($_GET['path'])) {
            $current_path = realpath($root_path) . '/';
            $current_url = $root_url;
            $current_dir_path = '';
            $moveup_dir_path = '';
        } else {
            $current_path = realpath($root_path) . '/' . $_GET['path'];
            $current_url = $root_url . $_GET['path'];
            $current_dir_path = $_GET['path'];
            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
        }
        // echo realpath($root_path);
        // 排序形式，name or size or type
        $order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
        
        // 不允许使用..移动到上一级目录
        if (preg_match('/\.\./', $current_path)) {
            echo 'Access is not allowed.';
            exit();
        }
        // 最后一个字符不是/
        if (! preg_match('/\/$/', $current_path)) {
            echo 'Parameter is not valid.';
            exit();
        }
        // 目录不存在或不是目录
        if (! file_exists($current_path) || ! is_dir($current_path)) {
            echo 'Directory does not exist.';
            exit();
        }
        
        // 遍历目录取得文件信息
        $file_list = array();
        if ($handle = opendir($current_path)) {
            $i = 0;
            while (false !== ($filename = readdir($handle))) {
                if ($filename{0} == '.')
                    continue;
                $file = $current_path . $filename;
                if (is_dir($file)) {
                    $file_list[$i]['is_dir'] = true; // 是否文件夹
                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); // 文件夹是否包含文件
                    $file_list[$i]['filesize'] = 0; // 文件大小
                    $file_list[$i]['is_photo'] = false; // 是否图片
                    $file_list[$i]['filetype'] = ''; // 文件类别，用扩展名判断
                } else {
                    $file_list[$i]['is_dir'] = false;
                    $file_list[$i]['has_file'] = false;
                    $file_list[$i]['filesize'] = filesize($file);
                    $file_list[$i]['dir_path'] = '';
                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
                    $file_list[$i]['filetype'] = $file_ext;
                }
                $file_list[$i]['filename'] = $filename; // 文件名，包含扩展名
                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); // 文件最后修改时间
                $i ++;
            }
            closedir($handle);
        }
        
        // 排序
        function cmp_func($a, $b)
        {
            global $order;
            if ($a['is_dir'] && ! $b['is_dir']) {
                return - 1;
            } else 
                if (! $a['is_dir'] && $b['is_dir']) {
                    return 1;
                } else {
                    if ($order == 'size') {
                        if ($a['filesize'] > $b['filesize']) {
                            return 1;
                        } else 
                            if ($a['filesize'] < $b['filesize']) {
                                return - 1;
                            } else {
                                return 0;
                            }
                    } else 
                        if ($order == 'type') {
                            return strcmp($a['filetype'], $b['filetype']);
                        } else {
                            return strcmp($a['filename'], $b['filename']);
                        }
                }
        }
        usort($file_list, 'cmp_func');
        
        $result = array();
        // 相对于根目录的上一级目录
        $result['moveup_dir_path'] = $moveup_dir_path;
        // 相对于根目录的当前目录
        $result['current_dir_path'] = $current_dir_path;
        // 当前目录的URL
        $result['current_url'] = $current_url;
        // 文件数
        $result['total_count'] = count($file_list);
        // 文件列表数组
        $result['file_list'] = $file_list;
        
        // 输出JSON字符串
        header('Content-type: application/json; charset=UTF-8');
        $json = new Services_JSON();
        echo $json->encode($result);
    }

    function alert($msg)
    {
        header('Content-type: text/html; charset=UTF-8');
        $json = new Services_JSON();
        echo $json->encode(array(
            'error' => 1,
            'message' => $msg
        ));
        exit();
    }

    function demo()
    {
        $data = $this->input->post();
        var_dump($data);
    }
}

?>