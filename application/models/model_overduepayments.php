<?php
class Model_overduepayments extends CI_Model
{
	var $tbl_name = 'overdue_payments';

    // return int status by string process_code
	function addOverduePayment($data)
	{
		$this->db->insert($this->tbl_name, $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }
        return false;
	}

}
?>