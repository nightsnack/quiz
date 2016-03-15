<?php

class Testpaper extends CI_Controller
{

    private $userid = 'admin';

    private $pictureurl = 'oss.dmsq.com/';

    function __construct()
    {
        parent::__construct();
        $_SESSION['user_id'] = $this->userid;
        $this->checklogin();
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel','Answer');
        $this->load->driver('cache');
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
        $testpaper = $this->cache->memcached->get($code);
        
        $data = array(
            'errno' => 0,
            'accesscode' => $code
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
/**
 * 根据accesscode回传试题库
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
     */
    public function answer_compare()
    {
        $input = file_get_contents("php://input");
        $json = json_decode($input);
        (! empty($json->accesscode)) ? ($accesscode = $json->accesscode) : die('{"errno":103,"error":"请将信息填写完整！"}');
        (! empty($json->answer)) ? ($as = $json->answer) : die('{"errno":103,"error":"请将信息填写完整！"}');
        $testpaper = $this->cache->memcached->get($accesscode);
        if(empty($testpaper)) die('{"errno":104,"error":"该作业不存在或已超期"}');
        if($this->Answer->query_test($_SESSION['user_id'],$testpaper['chapter_id'],$accesscode))
            die('{"errno":105,"error":"该作业您已提交过"}');
        
        $answer = array();
        foreach ($as as $c) {
            foreach ($c as $k => $v) {
                $answer[$k] = $v;
            }
        }
        $keys = $testpaper['keys'];
        $data_answer = array();
        $right = 0;
        foreach ($answer as $id => $value) {
            if (strpos($keys[$id],',')) {
                $blanks = explode(',', $keys[$id]);
                $flag = in_array($value, $blanks);
                $data_answer[] = array(
                    'user_id' => $_SESSION['user_id'],
                    'accesscode' => $accesscode,
                    'question_id' => $id,
                    'answer' => $value,
                    'judge' => $flag,
                    'correct' => $keys[$id]
                );
                ($flag==true)&&($right++);
            } else {
                $flag = ($value == $keys[$id]);
                $data_answer[] = array(
                    'user_id' => $_SESSION['user_id'],
                    'accesscode' => $accesscode,
                    'question_id' => $id,
                    'answer' => $value,
                    'judge' => $flag,
                    'correct' => $keys[$id]
                );
                ($flag==true)&&($right++);
            }
        }
        
        $testpaper = [
            'user_id'=>$_SESSION['user_id'],
            'chapter_id'=>$testpaper['chapter_id'],
            'accesscode'=>$accesscode,
            'right'=>$right,
            'all'=>count($answer)
        ];
        
        $this->Answer->insert_student_record($data_answer);
        $this->Answer->insert_test_result($testpaper);
        
    }

    function index()
    {
        echo (! ! ("aaa" == "aaa"));
    }
}
?>