<?php

class Admin_dashboard_users_model extends CI_Model {
	
	/* Add new user */
	
	/**
	 * 
	 * @param unknown_type $data
	 */
	public function addNewUser($data) {
		$result = $this->mongo_db->db->users->insert($data);

		if($result) {
			return true;
		} else {
			return false; 
		}
	}

	/**
	 * 
	 * @param unknown_type $username
	 */
	public function checkUsername($username) {
		$result = $this->mongo_db->db->users->find(
			array('username' => $username)
		)->count();

		if($result > 0) {
			return false;
		} else {
			return true;
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
			return false;
		} else {
			return true;
		}
	}



	/* Manage users */
	
	/**
	 * 
	 */
	public function getRegisteredUsers() {
		$result = $this->mongo_db->db->users->find();

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $user_id
	 */
	public function getUserDetails($user_id) {
		$result = $this->mongo_db->db->users->findOne(array('_id' => $user_id));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $data
	 * @return boolean
	 */
	public function editUser($data) {
		$id = $data['id'];

		if(isset($data['avatar_image']) && !empty($data['avatar_image'])) {
			unset($data['id']);
		} else {
			unset($data['id']);
			unset($data['avatar_image']);
		}

		$result = $this->mongo_db->db->users
					->update(
						array('_id' => $id),
						array('$set' => $data)
					);

		if($result) {
			if(isset($data['avatar_image']) && !empty($data['avatar_image'])) {
				$this->mongo_db->db->posts
					->update(
						array('user_data.id' => $id),
						array('$set' => array('user_data.avatar' => $img_path)),
						array('multiple' => true)
					);

				$this->mongo_db->db->posts
					->update(
						array(
							'likes_users.id' => $id,
						),
						array('$set' => array('likes_users.$.avatar_image' => $img_path)),
						array('multiple' => true)
					);
			}

			return true;
		} else {
			return false;
		}		
	}

	/**
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $username
	 */
	public function checkUsernameEdit($id, $username) {
		$result = $this->mongo_db->db->users->findOne(
			array('username' => $username)
		);

		if($result) {
			if($result['_id']->{'$id'} == $id) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	/**
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $email
	 */
	public function checkEmailEdit($id, $email) {
		$result = $this->mongo_db->db->users->findOne(
			array('email' => $email)
		);

		if($result) {
			if($result['_id']->{'$id'} == $id) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	/**
	 * 
	 * @param unknown_type $user_id
	 */
	public function deleteUser($user_id) {
		$result = $this->mongo_db->db->users->remove(array('_id' => $user_id));

		if($result) {
			return true;
		} else {
			return false;
		}
	}



	/* Ban user */
	
	/**
	 * 
	 */
	public function getNotBannedUsers() {
		$result = $this->mongo_db->db->users->find(array('ban_data' => array('$exists' => false)));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function banUser($data) {
		$result = $this->mongo_db->db->users->update(
			array('_id' => $data['user_id']),
			array('$set' => array(
					'ban_data' => array(
						'banned_by' => $data['banned_by'],
						'ban_period' => $data['ban_period'],
						'ban_reason' => $data['ban_reason'],
						'banned_on' => $data['banned_on'],
						'ban_lift' => $data['ban_lift']
					)
				)
			)
		);

		if($result) {
			return true;
		} else {
			return false;
		}
	}



	/* List of banned users */
	
	/**
	 * 
	 */
	public function getBannedUsers() {
		$result = $this->mongo_db->db->users->find(array('ban_data' => array('$exists' => true)));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $user_id
	 */
	public function userLiftBan($user_id) {
		$result = $this->mongo_db->db->users->update(
			array('_id' => $user_id),
			array('$unset' => array('ban_data' => true))
		);

		if($result) {
			return true;
		} else {
			return false;
		}
	}
	
}