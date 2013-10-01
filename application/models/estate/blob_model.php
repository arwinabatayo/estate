<?php

// Robert
class Blob_model extends CI_Model {
	function upload($server_tmp_file, $blobfieldname, $table) {
		$data[$blobfieldname] = file_get_contents($server_tmp_file);
		echo $server_tmp_file['type'];
		$this->save_file($data,$table);
	}
	function save_file($data,$table)
	{
		if( $this->db->insert($table,$data) ){
			return $this->db->insert_id();
		}else{
			return $this->db->_error_message();
		}
	}
	function get_file_from($table,$pkfield,$id, $return_array = TRUE, $what = '*')
	{
		$query = $this->db->select($what)
			->from($table)
			->where($pkfield, $id)
			->get();
		$result = ($return_array === TRUE) ? $query->row_array() : $query->row();
		if(count($result) == 0) return FALSE;
		return $result;
	}
}

?>
