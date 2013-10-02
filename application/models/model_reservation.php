<?php
class Model_reservation extends CI_Model
{
	var $tbl_name = 'estate_reservation';

	function __construct()
    {
           parent::__construct();
            
    }

	function addReservation($data)
	{  
        // users with mobile_number means a globe subscriber [?]
        // get account details if mobile_number is not empty
        if ($data['mobile_number']) {
            $account_info = $this->accounts_model->get_account_info_by_id($data['mobile_number']);
            
            // serialized specs
            $specs = $data['specs'];

            $data = array (
                'account_id'    => $account_info['account_id'],
                'first_name'    => $account_info['name'],
                'last_name'     => $account_info['surname'],
                'middle_name'   => $account_info['middle'],
                'email'         => $account_info['email'],
                'msisdn'        => $account_info['mobile_number'],
                // 'network_carrier'       => 'Globe', // user with mobilenum is automatically a globe subscriber [?]
                'social_network_sitename' => '', //should be from account information table
                'social_network_user_id'=>  '', // TODO : define proper resource, from accounts table
                'reserved_item_specs'   => $specs,
                'reserved_datetime'     => date("Y-m-d H:i:s")
            );
        }
        // if no account id, it means a non globe subscriber [?] TODO : verify with team
        // reserve data right away
		$this->db->insert($this->tbl_name, $data);
        // unset reserved item spec session        
        $insert_id = $this->db->insert_id();
        $this->session->unset_userdata('reserved_item_specs');

        return $insert_id;
	}

    function getAllReservations($limit, $limit_by=50, $order_by)
    {

        $this->db->where('delete_flag', 'n');
        $query_total = $this->db->get($this->tbl_name);

        if ($order_by) {
            $this->db->order_by($order_by['field'], $order_by['direction']);
        }
        if ($limit_by != 'all') {
            $query = $this->db->get($this->tbl_name, $limit_by, $limit);
        }
        
        $data = $query->result_array();
        $data['total_count'] = $query_total->num_rows;
        // echo $data['total_count']; exit;
        return $data;
    
    }

    function updateReservationById($reserve_id)
    {   
        // get current status and negate
        $temp_flag = $this->getReservationStatusById($reserve_id);
        if ($temp_flag =='n') { $informed_flag = 'y'; } else { $informed_flag = 'n'; }
        // echo $reserve_id . ' ' . $temp_flag . ' ' . $informed_flag; exit;
        $this->db->where('reserve_id', $reserve_id)      
                ->update($this->tbl_name, array('informed_flag' => $informed_flag));
        return $informed_flag;
    }

        // return int status by string process_code
    function getReservationStatusById($reserve_id)
    {
        $q = $this->db->get_where($this->tbl_name, array('reserve_id' => $reserve_id));
        $result = $q->row();
        return $result->informed_flag;
    }
}
?>