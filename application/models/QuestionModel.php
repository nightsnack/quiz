<?php

class QuestionModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "id";
    
    /* 表名 */
    private $table = "Question";
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 查询该章节全部问题，全部字段
     * @param unknown $chapter_id
     * @return unknown
     */
    public function query_question($chapter_id)
    {
        $this->db->where('chapter_id',$chapter_id);
        $query = $this->db->get($this->table)->result_array();
        return $query;
    }
    
    /**
     * 查询单个题
     * @param unknown $question_id
     * @return unknown
     */
    public function query_one_question($question_id)
    {
        $this->db->select('id,chapter_id,type,content_type,content,answer');
        $this->db->where($this->primary_key,$question_id);
        $query = $this->db->get($this->table)->result_array();
        return $query[0];
    }
    
    /**
     * 只查该章节题目详情
     * @param unknown $chapter_id
     * @return unknown
     */
    public function query_question_for_testpaper($chapter_id)
    {
        $this->db->select('id,type,content_type,content');
        $this->db->where('chapter_id',$chapter_id);
        $query = $this->db->get($this->table)->result_array();
        return $query;
    }
    
    public function insert_question($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->affected_rows();
    }
    
    public function delete_question($question_id)
    {
        $this->db->delete($this->table, array(
            $this->primary_key => $question_id
        ));
        return $this->db->affected_rows();
    }
    
    public function update_question($data)
    {
        $this->db->update($this->table, $data, array(
            $this->primary_key => $data[$this->primary_key]
        ));
        return $this->db->affected_rows();
    }
    
    public function clear_recent($chapter_id)
    {
        $this->db->set('recent_right',0);
        $this->db->set('recent_all',0);
        $this->db->where('chapter_id',$chapter_id);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }
    
    public function query_answer($id)
    {
        $this->db->select('id,answer');
        $this->db->where('chapter_id', $id);
        return $this->db->get($this->table)->result_array();
    }
}

?>