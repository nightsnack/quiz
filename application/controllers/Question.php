<?php

class Question extends CI_Controller
{

    private $open_id = 'admin';
    private $pictureurl = 'oss.dmsq.com/';

    function __construct()
    {
        parent::__construct();
        $_SESSION['open_id'] = $this->open_id;
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('UserModel','User');
        $this->checklogin();
    }

    private function checklogin()
    {
        if (! $_SESSION['open_id']) {
            $data = array(
                'errno' => 101,
                'error' => '请先登录'
            );
            echo json_encode($data, JSON_UNESCAPED_UNICODE);die();
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
        $temp  = $this->Question->query_recent_count($chapter_id);
        for ($i = 0; $i < count($res); $i ++) {
            if ($res[$i]['content_type'])
            {
                $res[$i]['content'] = $this->pictureurl.$res[$i]['content'];
            }
            if(!$res[$i]['correct']) $res[$i]['correct'] = 1; // 当存储答题信息的表里没有该题的记录时，要把这个正确人数记为1
            if (isset($temp[$i])) {
                $res[$i]['recent_sum'] = $temp[$i]['recent_sum'];
                $res[$i]['recent_correct'] = $temp[$i]['recent_correct'];
            } else {
                $res[$i]['recent_sum'] = 1;
                $res[$i]['recent_correct'] = 1;
            }
            
        }
        $resp['chapter_id'] = $chapter_id; // 给添加问题的时候发请求提供便利
        $resp['res'] = $res;
        echo json_encode($resp, JSON_UNESCAPED_UNICODE);
    }
    
    public function insert_question()
    {
        $insert_data['chapter_id'] = $this->input->post('chapter_id');
        $insert_data['type'] =$this->input->post('type');
        $insert_data['content_type'] = $this->input->post('content_type');
        $insert_data['content'] = trim($this->input->post('content'));
        $insert_data['answer'] = $this->input->post('answer');    //如果是填空，直接发字符串
        $flag = 1;
        foreach ($insert_data as $temp)
        {
            if(is_null($temp))
            {
                $flag = 0;
                break;
            }
        }
        if($flag)
        {
            if ($this->Question->insert_question($insert_data)) {
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
    
    public function delete_question()
    {
        $id = $this->input->post('question_id');
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
        if ($res['content_type'])
        {
            $res['content'] = $this->pictureurl.$res['content'];
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * 不允许更新的：题目类型（type）
     */
    public function update_question()
    {
        $insert_data['id'] = $this->input->post('question_id');
        $insert_data['content_type'] = $this->input->post('content_type');
        $insert_data['content'] = trim($this->input->post('content'));
        $insert_data['answer'] = $this->input->post('answer');    //如果是填空，直接发字符串
        $flag = 1;
        foreach ($insert_data as $temp)
        {
            if(is_null($temp))
            {
                $flag = 0;
                break;
            }
        }
        if($flag){
            if ($this->Question->update_question($insert_data)) {
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