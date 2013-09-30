<?php
class Plans_model extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    /**
     * Get Plan Categories.
     * @param  string what (optional) - specify the fields needed
     * @return array
     */
    function get_main_plan($what = '*', $status = 1)
    {
        $query = $this->db->select($what)
                           ->from('estate_main_plan')
                           ->where('f_main_plan_status', $status)
                           ->get();
        $result = $query->result_array();
        if(count($result) == 0) return FALSE;
        return $result;
    }

    /**
     * Get Plan Bundle.
     * @param  int main plan id (required) - main plan id
     * @param  string what (optional) - specify the fields needed
     * @return array
     */
    function get_main_plan_bundle($main_plan_id = '', $status = 1)
    {
        $query = $this->db->select('mp.f_main_plan_title , p.*')
                           ->from('estate_main_plan_bundle mpb')
                           ->join('estate_plan p', 'mpb.f_plan_id = p.f_plan_id')
                           ->join('estate_main_plan mp', 'mpb.f_main_plan_id = mp.f_main_plan_id')
                           ->where('mpb.f_main_plan_id', 1)
                           ->get();
        $result = $query->result_array();
        if(count($result) == 0) return FALSE;
        return $result;
    }

    function getIndustry($industry_type = ""){

      $where = "";

      if(!empty($industry_type)){
        $where = " WHERE type = '" . $industry_type . "'";
      } 

      $query = $this->db->query(" SELECT  *
                    FROM estate_industry" . $where);
      $data = $query->result_array();

      return $data;
  }
}