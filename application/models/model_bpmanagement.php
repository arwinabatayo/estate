<?php
class Model_bpmanagement extends CI_Model
{
	var $tbl_name = 'business_process_management';

	function getProcessStatusByCode($pcode)
	{
		$q = $this->db->get_where($this->tbl_name, array('process_code' => $pcode));
		$result = $q->row();
        return $result->enabled_flag;
	}

	function updateProcessByCode($pcode)
    {
		$this->db->where('process_code', $pcode);
        // get current status and negate
        $enabled_flag = !($this->getProcessStatusByCode($pcode));
		$this->db->update($this->tbl_name, array('enabled_flag' => $enabled_flag));
        return $enabled_flag;
	}

    function getAllProcess()
    {        
        $q = $this->db->get($this->tbl_name);
        return $q->result();
    }
}
?>