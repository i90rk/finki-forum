<?php

class Global_actions_model extends CI_Model {
	
	/**
	 * 
	 * @param unknown_type $username
	 */
	public function checkUsername($username) {
		$result = $this->mongo_db->db->users->find(
			array('username' => $username)
		)->count();

		if($result > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $email
	 */
	public function checkEmail($email) {
		$result = $this->mongo_db->db->users->find(
			array('email' => $email)
		)->count();

		if($result > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function registerUser($data) {
		$result = $this->mongo_db->db->users->insert($data);

		if($result) {
			return true;
		} else {
			return false; 
		}
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function verifyUser($data) {
		$result = $this->mongo_db->db->users->findOne(
			array(
				'username' => $data['username'], 
				'password' => $data['password'],
			),
			array(
				'password' => false
			)
		);

		return $result;
	}
}