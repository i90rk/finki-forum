<?php

class Posts_model extends CI_Model {

	public function incrementTopicViews($topic_id) {
		$this->mongo_db->db->topics
			->update(
				array('_id' => $topic_id),
				array(
					'$inc' => array(
						'views_num' => (int)+1
					),
				)
			);
	}

	public function getPostsBreadcrumpsNav($subforum_id, $topic_id) {
		$result_forums = $this->mongo_db->db->forums
							->findOne(
								array(
									'subforums.id' => $subforum_id
								),
								array(
									'title' => true,
									'subforums.$' => true
								)	
							);

		$result_topic = $this->mongo_db->db->topics
							->findOne(
								array(
									'_id' => $topic_id
								),
								array(
									'title' => true
								)
							);
												
		if($result_forums) {
			$final_result = array(
				array(
					'id' => $result_forums['_id'],
					'title' => $result_forums['title']
				),
				array(
					'id' => $result_forums['subforums'][0]['id'],
					'title' => $result_forums['subforums'][0]['title']
				),
				array(
					'id' => $result_topic['_id'],
					'title' => $result_topic['title']
				)
			);

			return $final_result;
		} else {
			return false;
		}									
	}

	public function getTopicClosedFlag($topic_id) {
		$result = $this->mongo_db->db->topics
					->findOne(
						array('_id' => $topic_id),
						array('closed' => true)
					);

		if(!$result) {
			return false;
		}

		return $result['closed'];
	}

	public function getPostsCount($topic_id) {
		$result = $this->mongo_db->db->posts->count(array('topic_data.topic_id' => $topic_id));

		if(!$result) {
			return false;
		}

		return $result;
	}

	public function getPostsList($topic_id, $from, $limit = 20) {
		$result = $this->mongo_db->db->posts
					->find(
						array(
							'topic_data.topic_id' => $topic_id
						)
					)->skip($from)->limit($limit)->sort(array('date' => 1));

		if($result) {
			return $result;
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

	public function addNewPost($all_data) {
		/* 
		 * Increment the number of posts for all user's post in posts collection
		 */
		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $all_data['user_id']),
				array(
					'$inc' => array('user_data.posts_num' => (int)+1),
					'$set' => array('user_data.group_type' => $all_data['group_type'])
				),
				array('multiple' => true)
			);

		// Update likes num for the user that created the post in every post in likes user data
		$this->mongo_db->db->posts
			->update(
				array(
					'likes_users.id' => $all_data['user_id'], 
				),
				array('$inc' => array('likes_users.$.posts_num' => (int)+1)),
				array('multiple' => true)
			);

		/* Add first post in the topic */
		$this->mongo_db->db->posts->insert($all_data['post_data']);

		/* 
		 * Increment the number of posts in user's data, 
		 * and update the last post field 
		 */
		$this->mongo_db->db->users
			->update(
				array('_id' => $all_data['user_id']),
				array(
					'$set' => array(
						'last_activity' => $all_data['date']
					),
					'$inc' => array('posts_num' => (int)+1)
				)
			);

		/* 
		 * Increment the number of posts in the subforum, 
		 * and update the last post field 
		 */
		$this->mongo_db->db->forums
			->update(
				array('subforums.id' => $all_data['subforum_id']),
				array(
					'$set' => array(
						'subforums.$.last_post' => $all_data['last_post']
					),
					'$inc' => array(
						'subforums.$.posts_num' => (int)+1
					),
				)
			);

		/* 
		 * Increment the number of posts in the topic, 
		 * and update the last post field 
		 */
		$this->mongo_db->db->topics
			->update(
				array('_id' => $all_data['topic_id']),
				array(
					'$set' => array(
						'last_post' => $all_data['last_post']
					),
					'$inc' => array(
						'posts_num' => (int)+1
					),
				)
			);

		return true;
	}

	public function editPost($data) {
		$result = $this->mongo_db->db->posts
					->update(
						array('_id' => $data['post_id']),
						array(
							'$set' => array('post' => $data['post'])
						)
					);

		if(!$result) {
			return false;
		}

		return true;
	}

	public function deletePost($data) {
		/* 
		 * Decrement the number of posts for all user's post in posts collection
		 */
		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $data['user_id']),
				array(
					'$inc' => array('user_data.posts_num' => (int)-1)
				),
				array('multiple' => true)
			);

		// update likes num for the user that created the post in every post in likes user data
		$this->mongo_db->db->posts
			->update(
				array(
					'likes_users.id' => $data['user_id'],
				),
				array('$inc' => array('likes_users.$.posts_num' => (int)-1)),
				array('multiple' => true)
			);

		/* Delete post */
		$this->mongo_db->db->posts->remove(array('_id' => $data['post_id']));
		/* 
		 * Decrement the number of posts in user's data
		 */
		$this->mongo_db->db->users
			->update(
				array('_id' => $data['user_id']),
				array(
					'$inc' => array('posts_num' => (int)-1)
				)
			);
		/* 
		 * Decrement the number of posts in the subforum
		 */
		$this->mongo_db->db->forums
			->update(
				array('subforums.id' => $data['subforum_id']),
				array(
					'$inc' => array(
						'subforums.$.posts_num' => (int)-1
					),
				)
			);
		/* 
		 * Decrement the number of posts in the topic
		 */
		$this->mongo_db->db->topics
			->update(
				array('_id' => $data['topic_id']),
				array('$inc' => array('posts_num' => (int)-1))
			);

		return true;
	}

	public function editTopic($data) {
		$this->mongo_db->db->topics
			->update(
				array('_id' => $data['topic_id']),
				array(
					'$set' => array('title' => $data['title'])
				)
			);

		$this->mongo_db->db->posts
			->update(
				array('topic_data.topic_id' => $data['topic_id']),
				array(
					'$set' => array('topic_data.topic_title' => $data['title'])
				),
				array('multiple' => true)
			);

		return true;
	}

	public function likePost($post_id, $post_user_id, $like_user_data) {

		// update likes num for the user that created the post in every post in likes user data
		$this->mongo_db->db->posts
			->update(
				array(
					'likes_users.id' => $post_user_id,
				),
				array('$inc' => array('likes_users.$.likes_num' => (int)+1)),
				array('multiple' => true)
			);


		// update the likes_num and likes_users array for the post
		$this->mongo_db->db->posts
			->update(
				array('_id' => new MongoId($post_id)),
				array(
					'$inc' => array('likes_num' => (int)+1),
					'$push' => array(
						'likes_users' => $like_user_data
					)
				)
			);

		// update the likes_num for the user that created the post
		$this->mongo_db->db->users
			->update(
				array('_id' => $post_user_id),
				array(
					'$inc' => array('likes_num' => (int)+1),
				)
			);

		// update the likes_posts_ids for the user that likes the post
		$this->mongo_db->db->users
			->update(
				array('_id' => $like_user_data['id']),
				array(
					// '$inc' => array('likes_num' => (int)+1),
					'$addToSet' => array('likes_posts_ids' => $post_id)
				)
			);

		// increment the number of likes for every post that user created
		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $post_user_id),
				array(
					'$inc' => array('user_data.likes_num' => (int)+1)
				),
				array('multiple' => true)
			);
		
		return true;
	}

	public function getPostData($post_id) {
		$result = $this->mongo_db->db->posts
					->findOne(
						array('_id' => new MongoId($post_id)),
						array('likes_users' => true, 'likes_num' => true)
					);

		if(!$result) {
			return false;
		}

		return $result;
	}

	public function unlikePost($post_id, $post_user_id, $like_user_id) {
		// update the likes_num and likes_users array for the post
		$this->mongo_db->db->posts
			->update(
				array('_id' => new MongoId($post_id)),
				array(
					'$inc' => array('likes_num' => (int)-1),
					'$pull' => array(
						'likes_users' => array(
							'id' => $like_user_id
						)
					),
				)
			);

		// update likes num for the user that created the post in every post in likes user data
		$this->mongo_db->db->posts
			->update(
				array(
					'likes_users.id' => $post_user_id,
				),
				array('$inc' => array('likes_users.$.likes_num' => (int)-1)),
				array('multiple' => true)
			);

		// update the likes_num for the user that created the post
		$this->mongo_db->db->users
			->update(
				array('_id' => $post_user_id),
				array(
					'$inc' => array('likes_num' => (int)-1),
				)
			);

		// update the likes_posts_ids for the user that likes the post
		$this->mongo_db->db->users
			->update(
				array('_id' => $like_user_id),
				array(
					'$pull' => array('likes_posts_ids' => $post_id)
				)
			);

		// increment the number of likes for every post that user created
		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $post_user_id),
				array(
					'$inc' => array('user_data.likes_num' => (int)-1)
				),
				array('multiple' => true)
			);
		
		return true;
	}

	public function closeTopic($topic_id) {
		$result = $this->mongo_db->db->topics
					->update(
						array('_id' => $topic_id),
						array(
							'$set' => array('closed' => (int)1)
						)
					);

		if(!$result) {
			return false;
		}

		return true;
	}

	public function openTopic($topic_id) {
		$result = $this->mongo_db->db->topics
					->update(
						array('_id' => $topic_id),
						array(
							'$set' => array('closed' => (int)0)
						)
					);

		if(!$result) {
			return false;
		}

		return true;
	}

	public function showMoreLikeUsers($post_id) {
		$result = $this->mongo_db->db->posts
					->findOne(
						array('_id' => $post_id),
						array('likes_users' => true)
					);

		if(!$result) {
			return false;
		}

		return $result;
	}

	public function deleteTopic($subforum_id, $topic_id) {
		$count = $this->mongo_db->db->posts
					->count(array('topic_data.topic_id' => $topic_id));

		$count = (int)$count;

		$this->mongo_db->db->posts
			->remove(array('topic_data.topic_id' => $topic_id));

		$this->mongo_db->db->topics
			->remove(array('_id' => $topic_id));

		$this->mongo_db->db->forums
			->update(
				array('subforums.id' => $subforum_id),
				array(
					'$inc' => array(
						'subforums.$.topics_num' => (int)-1,
						'subforums.$.posts_num' => -$count
					)
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