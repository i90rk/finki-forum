<?php

class Admin_login_model extends CI_Model {
	
	/**
	 * 
	 * @param unknown_type $data
	 */
	public function verifyUser($data) {
		$result = $this->mongo_db->db->users->findOne(
				array(
					'username' => $data['username'], 
					'password' => $data['password'],
					'group_type' => 'Администратор'
				),
				array(
					'password' => false
				)
			);

		return $result;
	}
}