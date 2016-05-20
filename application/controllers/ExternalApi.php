<?php

class ExternalApi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('CourseModel', 'Course');
        $this->load->model('ChapterModel', 'Chapter');
        $this->load->model('QuestionModel', 'Question');
        $this->load->model('AnswerModel','Answer');
        $this->load->model('AccessCodeModel','Accesscode');
        $this->load->model('UserModel','User');
        $this->load->driver('cache');
    }
    
    public function query_course()
    {
        $unionid = $this->input->post('unionid');
        $res = $this->Course->query_course($unionid);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
    
    public function query_chapter()
    {
        $course_id = $this->input->post('course_id');
        $unionid = $this->input->post('unionid');
        $result = $this->Course->query_one_course($course_id);
        if ($result) {
            if ($result[0]['unionid'] !== $unionid)
                die('{"errno":105,"error":"非法进入！"}');
        }
    
        $res = $this->Chapter->query_chapter($course_id);
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }
    
    
    
    
    
}

?>