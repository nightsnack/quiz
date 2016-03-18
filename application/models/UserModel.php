<?php

class UserModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "open_id";
    
    /* 表名 */
    private $table = "user_info";
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function query_id($open_id)
    {
        $this->db->select('student_id');
        $this->db->where('open_id',$open_id);
        return $this->db->get($this->table)->result_array();
    }
    
    function insert_user($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->affected_rows();
    }
}

?>