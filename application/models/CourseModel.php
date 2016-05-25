<?php

class CourseModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "id";
    
    /* 表名 */
    private $table = "Course";
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function query_course($unionid)
    {
        $this->db->select('id,name');
        $this->db->where('unionid',$unionid);
        $query = $this->db->get($this->table)->result_array();
        return $query;
    }
    
    public function insert_course($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->affected_rows();
    }

    public function delete_course($course_id)
    {
        $this->db->delete($this->table, array(
            $this->primary_key => $course_id
        ));
        return $this->db->affected_rows();
    }
    
    public function update_course($data)
    {
        $this->db->update($this->table, $data, array(
            $this->primary_key => $data[$this->primary_key]
        ));
        return $this->db->affected_rows();
    }
    
    public function query_one_course($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get($this->table)->result_array();
        return $query;
    }
    
    public function insert_course_for_share($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }
}

?>