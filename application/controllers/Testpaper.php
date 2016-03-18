<?php

class Testpaper extends CI_Controller
{

    private $open_id = '1111';

    private $pictureurl = 'oss.dmsq.com/';

    function __construct()
    {
        parent::__construct();
        $_SESSION['open_id'] = $this->open_id;
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel','Answer');
        $this->load->model('AccessCodeModel','Accesscode');
        $this->load->model('UserModel','User');
        $this->load->driver('cache');
        $this->checklogin();
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
        

        
        $code = substr(time(), - 6);
        while ($this->cache->memcached->get($code))
            $code = substr(time(), - 6);
        
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
     * 根据accesscode回传试题库，用于生成试卷
     */
    public function get_testpaper()
    {
        $code = $this->input->post('accesscode');
        if ($code) {
            $testpaper = $this->cache->memcached->get($code);
            if ($testpaper) {
                $testpaper['questions'] = $this->Question->query_question_for_testpaper($testpaper['chapter_id']);
                unset($testpaper['keys']);
                $data = $testpaper;
            } else {
                $data = array(
                    'errno' => 102,
                    'error' => '该试卷不存在'
                );
            }
        } else {
            $data = array(
                'errno' => 103,
                'error' => '请输入6位提取码'
            );
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 用户发过来答案，查表，新增两个表的数据，并返回。
     * 返回答对数量，错误题号，该题的正确答案，以及班级前十名。
     */
    public function answer_compare()
    {
        $input = file_get_contents("php://input");
        $json = json_decode($input);
        (! empty($json->accesscode)) ? ($accesscode = $json->accesscode) : die('{"errno":103,"error":"请将信息填写完整！"}');
        (! empty($json->answer)) ? ($as = $json->answer) : die('{"errno":103,"error":"请将信息填写完整！"}');
        $testpaper = $this->cache->memcached->get($accesscode);
        if(empty($testpaper)) die('{"errno":104,"error":"该作业不存在或已超期"}');
        if($this->Answer->query_test($_SESSION['student_id'],$testpaper['chapter_id'],$accesscode))
            die('{"errno":105,"error":"该作业您已提交过"}');
        
        $answer = array();
        $position=array();
        foreach ($as as $c) {
            foreach ($c as $k => $v) {
                $position[] = $k;
                $answer[$k] = $v;
            }
        }
        $keys = $testpaper['keys'];
        $data_answer = array();
        $wrong = array();
        $right = 0;
        foreach ($answer as $id => $value) {
            if (strpos($keys[$id],',')) {
                $blanks = explode(',', $keys[$id]);
                $flag = in_array($value, $blanks);
                $data_answer[] = array(
                    'student_id' => $_SESSION['student_id'],
                    'accesscode' => $accesscode,
                    'question_id' => $id,
                    'answer' => $value,
                    'judge' => $flag,
                    'correct' => $keys[$id]
                );
                if ($flag==true)
                {
                    $right++;
                }else{
                    $question['question_position']=array_search($id, $position)+1;
                    $question['correct']=$keys[$id];
                    $wrong[] =$question;
                }
            } else {
                $flag = ($value == $keys[$id]);
                $data_answer[] = array(
                    'student_id' => $_SESSION['student_id'],
                    'accesscode' => $accesscode,
                    'question_id' => $id,
                    'answer' => $value,
                    'judge' => $flag,
                    'correct' => $keys[$id]
                );
                if ($flag==true)
                {
                    $right++;
                }else{
                    $question['question_position']=array_search($id, $position)+1;
                    $question['correct']=$keys[$id];
                    $wrong[] =$question; 
                }
            }
        }
        
        $testpaper = [
            'student_id'=>$_SESSION['student_id'],
            'chapter_id'=>$testpaper['chapter_id'],
            'accesscode'=>$accesscode,
            'time'=>date('Y-m-d H:i:s'),
            'right'=>$right,
            'all'=>count($answer)
        ];
        
        $this->Answer->insert_student_record($data_answer);
        $this->Answer->insert_test_result($testpaper);
        $top = $this->Answer->query_top($testpaper['chapter_id'],$accesscode);
        $data = [
            'correct'=>$right,
            'top'=>$top,
            'wrong'=>$wrong
        ];
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