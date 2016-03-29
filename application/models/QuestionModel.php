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
        $this->db->select('a.*,COUNT(*) as sum,SUM(judge) as correct');
        $this->db->from("$this->table as a");
        $this->db->where('a.chapter_id',$chapter_id);
        $this->db->join("Answer as b",'a.id=b.question_id','left');
        $this->db->group_by('a.id');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    /**
     * 查询单个题
     * @param unknown $question_id
     * @return unknown
     */
    public function query_one_question($question_id)
    {
        $this->db->select('*');
        $this->db->where($this->primary_key,$question_id);
        $query = $this->db->get($this->table)->result_array();
        return $query;
    }
    
    /**
     * 只查该章节题目详情
     * @param unknown $chapter_id
     * @return unknown
     */
    public function query_question_for_testpaper($chapter_id)
    {
        $this->db->select('id,type,content');
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
    
    
    public function query_answer($id)
    {
        $this->db->select('id,answer');
        $this->db->where('chapter_id', $id);
        return $this->db->get($this->table)->result_array();
    }
    
    function query_last_accesscode($chapter_id)
    {
        $this->db->select('accesscode');
        $this->db->order_by('create_time','DESC');
        $this->db->where('chapter_id',$chapter_id);
        $this->db->limit(1);
        return $this->db->get('Accesscode')->result_array();
    }
    
    public function query_recent_count($chapter_id)
    {
        $temp = $this->query_last_accesscode($chapter_id);
        if(empty($temp)){
            return array();
        }else 
        $accesscode = $temp[0]['accesscode'];
        $this->db->select('a.id,COUNT(*) as recent_sum,SUM(judge) as recent_correct');
        $this->db->from("$this->table as a");
        $this->db->where('a.chapter_id',$chapter_id);
        $this->db->where('b.accesscode',$accesscode);
        $this->db->join("Answer as b",'a.id=b.question_id','left');
        $this->db->group_by('a.id');
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    
}


?>