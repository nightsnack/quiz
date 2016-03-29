<?php

class ChapterModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "id";
    
    /* 表名 */
    private $table = "Chapter";
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function query_chapter($course_id)
    {
        $this->db->select('id,name');
        $this->db->where('course_id',$course_id);
        $query = $this->db->get($this->table)->result_array();
        return $query;
    }
    
    public function insert_chapter($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->affected_rows();
    }
    
    public function delete_chapter($chapter_id)
    {
        $this->db->delete($this->table, array(
            $this->primary_key => $chapter_id
        ));
        return $this->db->affected_rows();
    }
    
    public function update_chapter($data)
    {
        $this->db->update($this->table, $data, array(
            $this->primary_key => $data[$this->primary_key]
        ));
        return $this->db->affected_rows();
    }
    
    public function query_one_chapter($chapter_id)
    {
        $this->db->select('*');
        $this->db->where($this->primary_key,$chapter_id);
        $query = $this->db->get($this->table)->result_array();
        return $query;
    }
}

?>