<?php

class Topics_model extends CI_Model {

	public function getTopicsList($subforum_id, $from, $limit = 20) {
		$result = $this->mongo_db->db->topics->find(
			array(
				'subforum_id' => $subforum_id
			)
		)->skip($from)->limit($limit)->sort(array('date' => 1));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	public function getTopicsCount($subforum_id) {
		$result = $this->mongo_db->db->topics->count(array('subforum_id' => $subforum_id));

		if(!$result) {
			return false;
		}

		return $result;
	}

	public function getTopicsBreadcrumpsNav($subforum_id) {
		$result = $this->mongo_db->db->forums->findOne(
			array(
				'subforums.id' => $subforum_id
			),
			array(
				'title' => true,
				'subforums.$' => true
			)	
		);
												
		if($result) {
			$final_result = array(
				array(
					'id' => $result['_id'],
					'title' => $result['title']
				),
				array(
					'id' => $result['subforums'][0]['id'],
					'title' => $result['subforums'][0]['title']
				)
			);

			return $final_result;
		} else {
			return false;
		}									
	}

	public function getUserPostsLikesCnt() {
		$result = $this->mongo_db->db->users
					->findOne(
						array(
							'_id' => new MongoId($this->session->userdata('id'))
						),
						array(
							'posts_num' => true,
							'likes_num' => true,
						)
					);

		return $result;
	}

	public function addNewTopic($all_data) {
		/* 
		 * Increment the number of posts for all user's post in posts collection
		 */
		$this->mongo_db->db->posts->update(
			array('user_data.id' => $all_data['user_id']),
			array(
				'$inc' => array('user_data.posts_num' => (int)+1)
			),
			array('multiple' => true)
		);
		/* Add new topic */
		$this->mongo_db->db->topics->insert($all_data['topic_data']);
		/* Add first post in the topic */
		$this->mongo_db->db->posts->insert($all_data['post_data']);
		/* 
		 * Increment the number of topics and number of posts in the subforum, 
		 * and update the last post field 
		 */
		$this->mongo_db->db->forums->update(
			array('subforums.id' => $all_data['subforum_id']),
			array(
				'$set' => array(
					'subforums.$.last_post' => $all_data['last_post']
				),
				'$inc' => array(
					'subforums.$.topics_num' => (int)+1, 
					'subforums.$.posts_num' => (int)+1
				),
			)
		);
		/* 
		 * Increment the number of posts in user's data, 
		 * and update the last post field 
		 */
		$this->mongo_db->db->users->update(
			array('_id' => $all_data['user_id']),
			array(
				'$set' => array(
					'last_activity' => $all_data['date']
				),
				'$inc' => array('posts_num' => (int)+1)
			)
		);

		return true;

	}










	public function getUserPostsLikesCntMobile($user_id) {
		$result = $this->mongo_db->db->users
					->findOne(
						array(
							'_id' => new MongoId($user_id)
						),
						array(
							'posts_num' => true,
							'likes_num' => true,
						)
					);

		return $result;
	}
}