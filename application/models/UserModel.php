<?php

class UserModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "unionid";
    
    /* 表名 */
    private $table = "user_info";   //学生表
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function query_id($openid)
    {
        $this->db->select('student_id,name');
        $this->db->where('openid',$openid);
        return $this->db->get($this->table)->result_array();
    }
    
    function user_info($unionid)
    {
        $this->db->select('nickname');
        $this->db->where('unionid',$unionid);
        return $this->db->get('teacher')->result_array();
    }
    
    function insert_user($data)
    {
        $this->db->insert('teacher',$data);
        return $this->db->affected_rows();
    }
    
    function insert_student($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->affected_rows();
    }
}

?>