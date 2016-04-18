<?php

class UserModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "unionid";
    
    /* 表名 */
    private $table = "user_info";
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function query_id($unionid)
    {
        $this->db->select('student_id,name');
        $this->db->where('unionid',$unionid);
        return $this->db->get($this->table)->result_array();
    }
    
    function insert_user($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->affected_rows();
    }
}

?>