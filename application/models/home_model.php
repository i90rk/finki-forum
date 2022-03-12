<?php

class Home_model extends CI_Model {
	
	/**
	 * 
	 */
	public function getAllForumsSubforums() {
		$result = $this->mongo_db->db->forums->find(
			array(
				'display_order' => array('$gt' => 0),
				'subforums.display_order' => array('$gt' => 0)
			)
		)
		->sort(array('display_order' => 1));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	public function getSingleForumDetails($forum_id) {
		$result = $this->mongo_db->db->forums->findOne(
			array(
				'_id' => $forum_id
			)
		);

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

}