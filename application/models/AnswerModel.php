<?php

class AnswerModel extends CI_Model
{
    /* 主键名 */
    private $primary_key = "id";
    
    /* 表名 */
    private $table = "Answer";
    
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
        $this->db->insert('Testresult',$data);
        return $this->db->affected_rows();
    }
    
    /**
     * 查询这个学生是不是做过这一章节对应提取码的题了
     * @param unknown $user_id
     * @param unknown $chapter_id
     * @param unknown $accesscode
     */
    public function query_test($user_id,$chapter_id,$accesscode)
    {
        $array = array('user_id' => $user_id, 'chapter_id' => $chapter_id, 'accesscode' => $accesscode);
        $this->db->where($array);
        $this->db->from('Testresult');
        return $this->db->count_all_results();
    }
}

?>