<?php
//!!!!!!!构造函数没有session验证！！！！！！！
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET, POST,PUT, OPTIONS, DELETE');
header("Content-type: text/html;charset=utf-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Content-Type');

class Paper extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel','Answer');
        $this->load->model('AccessCodeModel','Accesscode');
        $this->load->model('UserModel','User');
        $this->load->driver('cache');
        date_default_timezone_set("Asia/Shanghai");
    }
    
    private function checklogin($openid,$student_id,$student_name)
    {
        if (! $openid) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        $student_info = $this->User->query_id($openid);
        if(!empty($student_info)){
//             $_SESSION['student_id'] = $student_info[0]['student_id'];
        } else {
            $insertdata = array(
                'openid' => $openid,
                'student_id' => $student_id,
                'name' => $student_name
            );
            $this->User->insert_student($insertdata);
//             $_SESSION['student_id'] = $student_id;
        }
    }

    
    /**
     * 根据accesscode回传试题库，用于生成试卷
     */
    public function get_testpaper()
    {
        $code = trim($this->input->post('accesscode'));
        $openid = $this->input->post('openid');
        $student_id = $this->input->post('student_id');
        $student_name = $this->input->post('student_name');
        $this->checklogin($openid,$student_id,$student_name);
        if ($code) {
            $testpaper = $this->cache->memcached->get($code);
            if ($testpaper) {
                $testpaper['questions'] = $this->Question->query_question_for_testpaper($testpaper['chapter_id']);
                unset($testpaper['keys']);
                $testpaper['endtime'] = str_replace('-', '/', $testpaper['endtime']);
                $data = $testpaper;
            } else {
                $data = array(
                    'errno' => 102,
                    'error' => '该试卷不存在'
                );
            }
            $chapter_id = $this->Accesscode->code_to_chapter_id($code);
            if (!empty($chapter_id)) {
            $top = $this->Answer->query_top($chapter_id[0]['chapter_id'],$code);
            $data['top']=$top;
            }
        } else {
            $data = array(
                'errno' => 103,
                'error' => '请输入8位提取码'
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

        $accesscode= $this->input->post('accesscode');
        $as = $this->input->post('answer');
        $student_id = $this->input->post('student_id');
        if (empty($accesscode)||empty($as))
            die('{"errno":103,"error":"请将信息填写完整！"}');

        $testpaper = $this->cache->memcached->get($accesscode);
        if(empty($testpaper)) die('{"errno":104,"error":"该作业不存在或已超期"}');
        if($this->Answer->query_test($student_id,$testpaper['chapter_id'],$accesscode))
            die('{"errno":105,"error":"该作业您已提交过"}');
    
        $answer = array();
        $position=array();
        foreach ($as as $c) {
            $position[] =$c['id'];
            $answer[$c['id']] = $c['answer'];
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
                    'student_id' => $student_id,
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
                    'student_id' => $student_id,
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
            'student_id'=>$student_id,
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
}

?>