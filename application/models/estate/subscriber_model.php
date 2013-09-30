<?php
class Subscriber_model extends CI_Model
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
    function save_company($data)
    {
        $this->db->insert("estate_account_company_information", $data);
        $id = $this->db->insert_id();

        $this->load->model('estate/order_model');


        $this->db->update("estate_orders", array("company_id" => $id), array("id" => $this->session->userdata("order_id")));
                          
    }

    function save_personal($data)
    {
        $this->db->insert("estate_account_personal_information_non_globe", $data);
        $id = $this->db->insert_id();

        $this->load->model('estate/order_model');


        $this->db->update("estate_orders", array("company_id" => $id), array("id" => $this->session->userdata("order_id")));
    }

    
}