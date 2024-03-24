<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model {

	// get all data from data table
	public function getData($tableName, $condition, $order) {
		$this->db->select('*');
		$this->db->from($tableName);
		$this->db->where($condition);
		$this->db->order_by($order);
		$query = $this->db->get();
		if (sizeof($query->result_array()) > 0) {
			return $query->result_array();
		}else {
			return array();
		}
	}

	// add new data in table
	public function addData($tableName, $data_insert) {
		if (sizeof($data_insert) > 0  && !empty($tableName)) {
			$this->db->insert($tableName,$data_insert);
			$id = $this->db->insert_id();
		}else{
			$id = 0;
		}
		return $id;
	}

	// update data in table
	public function updateData($tableName, $condition, $data_insert) {
		if (sizeof($data_insert) > 0  && !empty($tableName)) {
			$this->db->where($condition);
			$this->db->update($tableName,$data_insert);
			$afftectedRows = $this->db->affected_rows();
			if($afftectedRows > 0) {
				$id = 1;
			} else {
				$id = 0;
			}
		}else{
			$id = 0;
		}
		return $id;
	}
}
