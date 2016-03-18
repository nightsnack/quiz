<?php

class User extends CI_Controller
{
    function register_user()
    {
        $data['open_id'] = 1899;
        $data['student_id'] = $this->input->post('student_id');
        $data['name'] = $this->input->post('name');
        $this->load->Model('UserModel','User');
        if ($data['open_id']&&$data['student_id']&&$data['name']) {
            
            if ($this->User->insert_user($data)) {
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
}

?>