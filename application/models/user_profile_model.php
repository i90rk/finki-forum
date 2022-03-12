<?php

class User_profile_model extends CI_Model {

	public function getUserDetails($user_id) {
		$result = $this->mongo_db->db->users
					->findOne(
						array('_id' => $user_id)
					);

		if(!$result) {
			return false;
		}
		
		return $result;
	}

	public function getPostsCount($user_id) {
		$result = $this->mongo_db->db->posts->count(array('user_data.id' => $user_id));

		if(!$result) {
			return false;
		}

		return $result;
	}

	public function getPostsList($user_id, $from, $limit = 4) {
		$result = $this->mongo_db->db->posts
					->find(
						array(
							'user_data.id' => $user_id
						)
					)->skip($from)->limit($limit)->sort(array('date' => -1));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

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









	public function getPostsListMobile($user_id, $from, $limit = 4) {
		$result = $this->mongo_db->db->posts
					->find(
						array(
							'user_data.id' => $user_id
						)
					)->skip($from)->limit($limit)->sort(array('date' => -1));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}
}