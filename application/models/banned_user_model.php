<?php 
	
	class Banned_user_model extends CI_Model {

		public function getUserBanData($user_id) {
			$result = $this->mongo_db->db->users
						->findOne(
							array('_id' => new MongoId($user_id)),
							array('ban_data' => true)
						);

			if(!$result) {
				return false;
			}

			return $result;
		}
	}
?>