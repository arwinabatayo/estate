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
        // users with account_id means a globe subscriber [?]
        // get account details if account_id is not empty
        if ($data['account_id']) {
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
                'network_carrier'       => 'Globe', // user with account_id is automatically a globe subscriber [?]
                'social_network_sitename' => $d->sns_id,
                'social_network_user_id'=>  '000', // TODO : define proper resource
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
}
?>