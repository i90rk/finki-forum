<?php

class User_Settings_Model extends CI_Model {

	public function getUserDetails($user_id) {
		$result = $this->mongo_db->db->users
					->findOne(
						array('_id' => new MongoId($user_id))
					);

		if(!$result) {
			return false;
		}
		
		return $result;
	}

	public function changeBasicSettings($user_id, $user_data) {
		$result = $this->mongo_db->db->users
					->update(
						array('_id' => $user_id),
						array(
							'$set' => $user_data
						)
					);

		if(!$result) {
			return false;
		}

		return true;
	}

	public function changeAvatar($user_id, $img_path) {
		$this->mongo_db->db->users
			->update(
				array('_id' => $user_id),
				array('$set' => array('avatar_image' => $img_path))
			);

		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $user_id),
				array('$set' => array('user_data.avatar' => $img_path)),
				array('multiple' => true)
			);

		$this->mongo_db->db->posts
			->update(
				array(
					'likes_users.id' => $user_id, 
				),
				array('$set' => array('likes_users.$.avatar_image' => $img_path)),
				array('multiple' => true)
			);

		return true;
	}

	public function checkOldPassword($user_id, $old_password) {
		$result = $this->mongo_db->db->users
					->findOne(
						array(
							'_id' => $user_id,
							'password' => $old_password
						)
					);

		if($result) {
			return true;
		} else {
			return false;
		}
	}

	public function changePassword($user_id, $new_password) {
		$result = $this->mongo_db->db->users
					->update(
						array('_id' => $user_id),
						array('$set' => array('password' => $new_password))
					);

		if(!$result) {
			return false;
		}

		return true;
	}
}