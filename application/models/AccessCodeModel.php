<?php

class AccessCodeModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "id";
    
    /* 表名 */
    private $table = "AccessCode";
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function query_accesscode($chapter_id)
    {
        $this->db->select('accesscode,create_time,end_time');
        $this->db->where('chapter_id',$chapter_id);
        $this->db->order_by('create_time','DESC');
        return $this->db->get($this->table)->result_array();
    }
    
    public function insert_accesscode($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->affected_rows();
    }
    
    /*已废弃
    public function query_accesscode($chapter_id)
    {
        $this->db->select('a.accesscode,a.create_time,a.end_time,b.student_id,c.name,b.time,b.right,b.all');
        $this->db->from("$this->table as a");
        $this->db->join('Testresult as b','a.accesscode = b.accesscode','left');
        $this->db->join('user_info as c','b.student_id = c.student_id','inner');
        $this->db->where('a.chapter_id',$chapter_id);
        $this->db->order_by('a.create_time,b.student_id');
        return $this->db->get()->result_array();
    }*/
}

?>