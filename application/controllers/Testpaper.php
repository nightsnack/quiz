<?php

class Testpaper extends CI_Controller
{

//     private $unionid = 'admin';

    function __construct()
    {
        parent::__construct();
//         $_SESSION['unionid'] = $this->unionid;
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel','Answer');
        $this->load->model('AccessCodeModel','Accesscode');
        $this->load->model('UserModel','User');
        $this->load->model('ChapterModel', 'Chapter');
        $this->load->driver('cache');
        $this->checklogin();
        date_default_timezone_set("Asia/Shanghai");
    }

    private function checklogin()
    {
        if (! $_SESSION['unionid']) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        $student_id = $this->User->query_id($_SESSION['unionid']);
        if(!empty($student_id)){
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

    public function create_testpaper()
    {
        $endtime = $this->input->post('endtime');
        $chapter_id = $this->input->post('chapter_id');
        $lasttime = floor((strtotime($endtime) - strtotime("now")));
        if ($lasttime < 0)
            die('{"errno":103,"error":"时间错误"}');
        if (empty($chapter_id))
            die('{"errno":103,"error":"请将信息填写完整！"}');
        
        $result = $this->Chapter->query_one_chapter($chapter_id);
        if ($result) {
            if ($result[0]['unionid'] !== $_SESSION['unionid'])
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
        $testpaper = $this->cache->memcached->get($code);
        
        $data = array(
            'errno' => 0,
            'accesscode' => $code
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    

    /**
     * 这个章节对应的所有提取码的详情以及这个提取码的答题学生详情
     */
    public function mycode_result()
    {
        $chapter_id = $this->input->post('chapter_id');
        if (empty($chapter_id))
            die('{"errno":103,"error":"请将信息填写完整！"}');
        $code_array = $this->Accesscode->query_accesscode($chapter_id);
        $data = array();
         foreach ($code_array as $code){
            $code['students'] = $this->Answer->query_accesscode_marks($code['accesscode']);
            $data[]=$code;
         }
         echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
}
?>