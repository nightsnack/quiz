<?php

class Course extends CI_Controller
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
        $this->checklogin();
    }


    private function checklogin()
    {
        if (!isset($_SESSION['unionid'])) {
            redirect(site_url('User/show_login'));
        }
    }

    public function query_course()
    {
        $res = $this->Course->query_course($_SESSION['unionid']);
        $pass['res'] = $res;
        $head = array('sidebar'=>2);
	    $this->load->view('templates/header',$head);
	    $this->load->view('mycourse',$pass);
	    $this->load->view('templates/footer');
    }

    public function insert_course()
    {
        $name = $this->input->post('name');
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
        $id = $this->input->post('course_id');
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
        $data['id'] = $this->input->post('course_id');
        $data['name'] = trim($this->input->post('name'));
   
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
    
    public function share_course()
    {
        $endtime = $this->input->post('endtime');
        $course_id = $this->input->post('course_id');
        $this->checklogin();
        $lasttime = floor((strtotime($endtime) - strtotime("now")));
        if ($lasttime < 0)
            die('{"errno":103,"error":"时间错误"}');
        $course_result = $this->Course->query_one_course($course_id);
                if ($course_result) {
            if ($course_result[0]['unionid'] !== $_SESSION['unionid'])
                die('{"errno":105,"error":"非法进入！"}');
        }
        $chapter_result_temp = $this->Chapter->query_chapter($course_id);
        foreach ($chapter_result_temp as $key=>$chapter_one)
        {
            $question = $this->Question->query_question_for_share($chapter_one['id']);

                $chapter_result_temp[$key]['question'] = $question;
        }

        $lasttime = floor((strtotime($endtime) - strtotime("now")));
        $memory_data = array(
            'course_name'=>$course_result[0]['name'],
            'chapter_question' => $chapter_result_temp,
            'createtime' => date('Y-m-d H:i:s'),
            'endtime' => $endtime
        );
        $code = 'k'.time();
        $this->cache->memcached->save($code, $memory_data, $lasttime);

        $url = site_url().'?sharecode='.$code;
        $pass=array(
            'errno' => 0,
            'url'=>$url
        );
        echo json_encode($pass, JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * 添加分享的课程，及对应题目和章节
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
        foreach ($share_test["chapter_question"] as $chapter)
        {
            $chapter_data = array(
                'name' => $chapter['name'],
                'unionid'=>$_SESSION['unionid'],
                'course_id' => $course_id
            );
            $chapter_id = $this->Chapter->insert_chapter_for_share($chapter_data);
            $question= array();
            if (!empty($chapter["question"])){
            foreach ($chapter["question"] as $question_temp)
            {
                $question_temp['chapter_id'] = $chapter_id;
                $question_temp['unionid'] = $_SESSION['unionid'];
                $question[] = $question_temp;
            }
            $this->Question->insert_question_for_share($question);
            }
        }
        redirect(site_url("Course/query_course"));
    }
    
}

?>