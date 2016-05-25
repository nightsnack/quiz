<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST,PUT, OPTIONS, DELETE');
header("Content-type: text/html;charset=utf-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');

class Testpaper extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
//         $_SESSION['unionid']="oIv6js6DeLN83bRCz-1oefOycwl8";
        
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel','Answer');
        $this->load->model('AccessCodeModel','Accesscode');
        $this->load->model('UserModel','User');
        $this->load->model('CourseModel', 'Course');
        $this->load->model('ChapterModel', 'Chapter');
        $this->load->driver('cache');

        date_default_timezone_set("Asia/Shanghai");
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

    public function create_testpaper()
    {
        $unionid = $this->input->post('unionid');
        $endtime = $this->input->post('endtime');
        $chapter_id = $this->input->post('chapter_id');
        $lasttime = floor((strtotime($endtime) - strtotime("now")));
        if ($lasttime < 0)
            die('{"errno":103,"error":"时间错误"}');
        if (empty($chapter_id))
            die('{"errno":103,"error":"请将信息填写完整！"}');
        
        $result = $this->Chapter->query_one_chapter($chapter_id);
        if ($result) {
            if ($result[0]['unionid'] !== $unionid)
                die('{"errno":105,"error":"非法进入！"}');
        }
        
        $answer = $this->Question->query_answer($chapter_id);
        
        $keys = array();
        foreach ($answer as $val) {
            $keys[$val['id']] = $val['answer'];
        }
        
        $memory_data = array(
            'chapter_id' => $chapter_id,
            'createtime' => date('Y-m-d H:i:s'),
            'endtime' => $endtime,
            'keys' => $keys
        );
        
        $code = substr(time(), - 8);
        
        while ($this->cache->memcached->get($code))
            $code = substr(time(), - 8);
        
        $this->cache->memcached->save($code, $memory_data, $lasttime);
        $accesscode_data = [
            'accesscode'=>$code,
            'chapter_id'=>$chapter_id,
            'create_time' => date('Y-m-d H:i:s'),
            'end_time' => $endtime
        ];
        $this->Accesscode->insert_accesscode($accesscode_data);
//         $testpaper = $this->cache->memcached->get($code);
        
        $data = array(
            'errno' => 0,
            'accesscode' => $code
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    public function share_question()
    {
        $endtime = $this->input->get('endtime');
        $chapter_id = $this->input->get('chapter_id');
        $this->checklogin();
        $result = $this->Chapter->query_one_chapter($chapter_id);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        $course_id = $result[0]['course_id'];
        $result_course = $this->Course->query_one_course($course_id);
        $res = $this->Question->query_question_for_share($chapter_id);
//         var_dump($res);
        $lasttime = floor((strtotime($endtime) - strtotime("now")));
        $memory_data = array(
            'course_name'=>$result_course[0]['name'],
            'chapter_name' => $result[0]['name'],
            'createtime' => date('Y-m-d H:i:s'),
            'endtime' => $endtime,
            'question' => $res
        );
        echo $code = time();
        $this->cache->memcached->save($code, $memory_data, $lasttime);

        $testpaper = $this->cache->memcached->get($code);
        var_dump($testpaper);
   
    }

    /**
     * 添加分享的题目，及对应课程和章节
     * @param unknown $code
     */
    public function add_share($code)
    {
        $share_test = $this->cache->memcached->get($code);
        $course_data = array(
            'name' => trim($share_test['course_name']),
            'unionid' => $_SESSION['unionid']
        );
        $course_id = $this->Course->insert_course_for_share($course_data);
        $chapter_data = array(
            'name' => $share_test['chapter_name'],
            'unionid'=>$_SESSION['unionid'],
            'course_id' => $course_id
        );
        $chapter_id = $this->Chapter->insert_chapter_for_share($chapter_data);
        $temp = array();
        foreach ($share_test['question'] as $question)
        {
            $question['chapter_id'] = $chapter_id;
            $question['unionid'] = $_SESSION['unionid'];
            $temp[] = $question;
        }
        $this->Question->insert_question_for_share($temp);
        redirect(site_url("Question/query_question/$chapter_id"));
    }
    
    /**
     * 这个章节对应的所有提取码的详情以及这个提取码的答题学生详情
     */
    public function mycode_result($chapter_id)
    {
        $this->checklogin();
        if (empty($chapter_id))
            show_404();
        $result = $this->Chapter->query_one_chapter($chapter_id);
        $pass['chapter_name']=$result[0]['name'];
        $code_array = $this->Accesscode->query_accesscode($chapter_id);
        $data = array();
         foreach ($code_array as $code){
            $code['students'] = $this->Answer->query_accesscode_marks($code['accesscode']);
            $data[]=$code;
         }
         $pass['res']=$data;
         $head = array('sidebar'=>2);
	     $this->load->view('templates/header',$head);
         $this->load->view('mycode',$pass);
         $this->load->view('templates/footer');
    }
    
}
?>