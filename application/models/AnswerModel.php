<?php

class AnswerModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "id";
    
    /* 表名 */
    private $table = "Answer";
    private $testtable = "Testresult";
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 批量插入一个学生一次测验的数据
     * @param unknown $data
     * @return unknown
     */
    public function insert_student_record($data)
    {
        $this->db->insert_batch($this->table,$data);
        return $this->db->affected_rows();
    }
    
    /**
     * 插入一个学生一次测验的统计
     * @param unknown $data
     * @return unknown
     */
    public function insert_test_result($data)
    {
        $this->db->insert($this->testtable,$data);
        return $this->db->affected_rows();
    }
    
    /**
     * 查询这个学生是不是做过这一章节对应提取码的题了
     * @param unknown $student_id
     * @param unknown $chapter_id
     * @param unknown $accesscode
     */
    public function query_test($student_id,$chapter_id,$accesscode)
    {
        $array = array('student_id' => $student_id, 'chapter_id' => $chapter_id, 'accesscode' => $accesscode);
        $this->db->where($array);
        $this->db->from($this->testtable);
        return $this->db->count_all_results();
    }
    
    /**
     * 查询这个章节这个提取码的前10名
     * @param unknown $chapter_id
     * @param unknown $accesscode
     * @return unknown
     */
    public function query_top($chapter_id,$accesscode)
    {
        $this->db->select('a.student_id,b.name,a.right,a.time');
        $this->db->from("$this->testtable as a");
        $this->db->join('user_info as b', "a.student_id = b.student_id",'inner');
        $this->db->order_by('a.right DESC, a.time ASC');
        $this->db->limit(10);
        $array = array('chapter_id' => $chapter_id, 'accesscode' => $accesscode);
        $this->db->where($array);
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    /**  
     * 查询作答过该章节的学生的答题详情，按照提取码分组
     * @param unknown $chapter_id
     * @return unknown
     */
    public function query_accesscode_marks($accesscode)
    {
        $this->db->select('a.student_id,b.name,a.time,a.right,a.all');
        $this->db->from("$this->testtable as a");
        $this->db->join('user_info as b', "a.student_id = b.student_id",'inner');
        $this->db->order_by('a.student_id');
        $this->db->where('a.accesscode',$accesscode);
        $query = $this->db->get()->result_array();
        return $query;
    }
    

}

?>