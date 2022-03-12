<?php

class Admin_dashboard_model extends CI_Model {

	/* Add forums and manage forums*/
	
	/**
	 * 
	 */
	public function getForums() {
		$result = $this->mongo_db->db->forums->find()->sort(array('display_order' => 1));

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $forum_id
	 */
	public function getForumDetails($forum_id) {
		$result = $this->mongo_db->db->forums->findOne(array('_id' => $forum_id));

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
	public function addNewForum($data) {
		$result = $this->mongo_db->db->forums->insert(
			array(
				'title' => $data['title'],
				'description' => $data['description'],
				'display_order' => $data['display_order'],
				'date' => $data['date'],
				'forum_moderators_num' => $data['forum_moderators_num']
			)
		);

		if($result) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $forum_data
	 */
	public function editForum($forum_data) {
		$result = $this->mongo_db->db->forums->update(
			array('_id' => $forum_data['forum_id']),
			array('$set' => array(
					'title' => $forum_data['title'],
					'description' => $forum_data['description'],
					'display_order' => $forum_data['display_order']
				)
			) 
		);

		if(!$result) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * 
	 * @param unknown_type $forum_id
	 */
	public function deleteForum($forum_id) {
		$subforums_ids = array();
		
		$subforums = $this->mongo_db->db->forums
						->findOne(
							array('_id' => $forum_id),
							array('subforums' => true)
						);

		foreach ($subforums['subforums'] as $key => $value) {
			$subforums_ids[] = $value['id'];
		}

		$result = $this->mongo_db->db->forums
					->remove(array('_id' => $forum_id));

		if($result) {
			$this->mongo_db->db->topics
				->remove(array('subforum_id' => array('$in' => $subforums_ids)));

			$this->mongo_db->db->posts
				->remove(array('subforum_id' => array('$in' => $subforums_ids)));

			return true;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function updateForumsOrders($data) {
		foreach ($data as $value) {
			$this->mongo_db->db->forums->update(
				array('_id' => new MongoId($value['forum_id'])),
				array('$set' => array('display_order' => (int)$value['order']))
			);
		}

		return true;
	}

	/**
	 * 
	 * @param unknown_type $forum_id
	 */
	public function getNotBannedNotForumModeratorUsers($forum_id) {
		$result = $this->mongo_db->db->users->find(array('ban_data' => array('$exists' => false), 
				'$or' => array(
					array('moderator_for_forums' => array('$exists' => false)), 
					array('moderator_for_forums' => array('$size' => 0)),
					array('moderator_for_forums.forum_id' => array('$nin' => array($forum_id)))
				)
			)
		);

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	public function getSubforumsIds($forum_id) {
		$result = $this->mongo_db->db->forums
					->findOne(
						array('_id' => $forum_id),
						array('subforums' => true)
					);

		$subforums_ids = array();
		foreach ($result['subforums'] as $value) {
			$subforums_ids[] = $value['id']->{'$id'};
		}

		return $subforums_ids;
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function addNewForumModerator($data) {
		$this->mongo_db->db->forums->update(
			array('_id' => $data['forum_id']),
			array('$push' => array(
					'moderators' => array(
						'user_id' => $data['user_id'],
						'firstname' => $data['firstname'],
						'lastname' => $data['lastname'],
						'username' => $data['username']
					)
				),
				'$inc' => array('forum_moderators_num' => (int)1)
			)
		);

		$this->mongo_db->db->users->update(
			array('_id' => $data['user_id']),
			array(
				'$push' => array(
					'moderator_for_forums' => array(
						'forum_id' => $data['forum_id'],
						'subforums_ids' => $data['subforums_ids'],
						'can_edit_posts' => $data['can_edit_posts'],
						// 'can_hide_posts' => $data['can_hide_posts'],
						'can_delete_posts' => $data['can_delete_posts'],
						'can_open_topics' => $data['can_open_topics'],
						'can_edit_topics' => $data['can_edit_topics'],
						'can_close_topics' => $data['can_close_topics'],
						'can_delete_topics' => $data['can_delete_topics'],
						// 'can_ban_users' => $data['can_ban_users'],
						// 'can_restore_banned_users' => $data['can_restore_banned_users'],
					)
				),
				'$set' => array('group_type' => 'Модератор')
			)
		);

		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $data['user_id']),
				array('$set' => array('user_data.group_type' => 'Модератор')),
				array('multiple' => true)
			);

		$this->mongo_db->db->posts
			->update(
				array('likes_users.id' => $data['user_id']),
				array('$set' => array('likes_users.$.group_type' => 'Модератор')),
				array('multiple' => true)
			);

		return true;
	}

	/**
	 * 
	 * @param unknown_type $forum_id
	 */
	public function getForumModeratorsList($forum_id) {
		$result = $this->mongo_db->db->forums->find(
			array('_id' => $forum_id, 'moderators' => array('$exists' => true)),
			array('moderators' => true, '_id' => false)
		);

		if($result) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $user_id
	 * @param unknown_type $forum_id
	 */
	public function deleteForumModerator($user_id, $forum_id) {
		$this->mongo_db->db->users->update(
			array('_id' => $user_id),
			array(
				'$pull' => array(
					'moderator_for_forums' => array(
						'forum_id' => $forum_id
					)
				),
				'$set' => array('group_type' => 'Член')
			)
		);

		$this->mongo_db->db->forums->update(
			array('_id' => $forum_id),
			array('$pull' => array(
					'moderators' => array(
						'user_id' => $user_id
					)
				),
				'$inc' => array('forum_moderators_num' => (int)-1)
			)
		);

		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $user_id),
				array('$set' => array('user_data.group_type' => 'Член')),
				array('multiple' => true)
			);

		$this->mongo_db->db->posts
			->update(
				array('likes_users.id' => $user_id),
				array('$set' => array('likes_users.$.group_type' => 'Член')),
				array('multiple' => true)
			);

		return true;
	}

	/**
	 * 
	 * @param unknown_type $user_id
	 * @param unknown_type $forum_id
	 */
	public function getForumModeratorAbilities($user_id, $forum_id) {
		$result = $this->mongo_db->db->users->findOne(
			array('_id' => $user_id, 'moderator_for_forums.forum_id' => $forum_id),
			array('moderator_for_forums.$' => true)
		);

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
	public function editForumModerator($data) {
		$result = $this->mongo_db->db->users->update(
			array('_id' => $data['user_id'], 'moderator_for_forums.forum_id' => $data['forum_id']),
			array('$set' => array(
					'moderator_for_forums.$.can_edit_posts' => $data['can_edit_posts'],
					// 'moderator_for_forums.$.can_hide_posts' => $data['can_hide_posts'],
					'moderator_for_forums.$.can_delete_posts' => $data['can_delete_posts'],
					'moderator_for_forums.$.can_open_topics' => $data['can_open_topics'],
					'moderator_for_forums.$.can_edit_topics' => $data['can_edit_topics'],
					'moderator_for_forums.$.can_close_topics' => $data['can_close_topics'],
					'moderator_for_forums.$.can_delete_topics' => $data['can_delete_topics'],
					// 'moderator_for_forums.$.can_ban_users' => $data['can_ban_users'],
					// 'moderator_for_forums.$.can_restore_banned_users' => $data['can_restore_banned_users'],
				)
			)
		);

		if($result) {
			return true;
		} else {
			return false;
		}
	}



	/* ================================================================================================= */



	/* Add subforums and manage subforums */
	
	/**
	 * 
	 */
	public function getSubforums() {
		$result = $this->mongo_db->db->forums->find(
			array('subforums' => array('$exists' => true)))
		->sort(array('display_order' => 1));

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
	public function getSubforumDetails($data) {
		$result = $this->mongo_db->db->forums->findOne(
			array('_id' => $data['forum_id'], 'subforums.id' => $data['subforum_id']),
			array('subforums.$' => true)
		);

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
	public function addNewSubforum($data) {
		$result = $this->mongo_db->db->forums->update(
			array('_id' => $data['parent_forum']),
			array(
				'$push' => array(
					'subforums' => array(
						'id' => $data['id'],
						'title' => $data['title'],
						'description' => $data['description'],
						'display_order' => $data['display_order'],
						'date' => $data['date'],
						'subforum_moderators_num' => $data['subforum_moderators_num'],
						'topics_num' => (int)0,
						'posts_num' => (int)0,
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

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function editSubforum($data) {
		if($data['forum_id'] == $data['parent_id']) {
			// The subforum does not need to be moved from the parent forum

			// Update subforum data
			$result = $this->mongo_db->db->forums->update(
				array('_id' => $data['forum_id'], 'subforums.id' => $data['subforum_id']),
				array(
					'$set' => array(
						'subforums.$.title' => $data['title'],
						'subforums.$.description' => $data['description'],
						'subforums.$.display_order' => $data['display_order']
					)
				)
			);
		} else {
			// The subforum now belongs to new parent forum and it need to be moved from the current parent forum

			$subforum_get_details_data = array('forum_id' => $data['forum_id'], 'subforum_id' => $data['subforum_id']);
			// Get subforum details
			$subforum_details = $this->getSubforumDetails($subforum_get_details_data);
			// Remove the subforum from the current parent forum
			$this->mongo_db->db->forums->update(
				array('_id' => $data['forum_id']),
				array('$pull' => array(
						'subforums' => array(
							'id' => $data['subforum_id']
						)
					)
				)
			);
			// Push the subforum into the new parent forum
			$result = $this->mongo_db->db->forums->update(
				array('_id' => $data['parent_id']),
				array(
					'$push' => array(
						'subforums' => array(
							'id' => new MongoId($subforum_details['subforums'][0]['id']->{'$id'}),
							'title' => $subforum_details['subforums'][0]['title'],
							'description' => $subforum_details['subforums'][0]['description'],
							'display_order' => $subforum_details['subforums'][0]['display_order'],
							'date' => new MongoDate($subforum_details['subforums'][0]['date']->sec)
						)
					)
				)
			); 
		}

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
	public function deleteSubforum($data) {
		$result = $this->mongo_db->db->forums->update(
			array('_id' => $data['forum_id']),
			array(
				'$pull' => array(
					'subforums' => array(
						'id' => $data['subforum_id']
					)
				)
			)
		);

		if($result) {
			// remove all topics in the subforum
			$this->mongo_db->db->topics
				->remove(array('subforum_id' => $data['subforum_id']));

			// remove all posts in the subforum
			$this->mongo_db->db->posts
				->remove(array('subforum_id' => $data['subforum_id']));

			return true;
		} else {
			return false;
		}
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function updateSubforumsOrders($data) {
		foreach ($data as $value) {
			$this->mongo_db->db->forums->update(
				array('_id' => new MongoId($value['forum_id']), 'subforums.id' => new MongoId($value['subforum_id'])),
				array(
					'$set' => array(
						'subforums.$.display_order' => (int)$value['order']
					)
				)
			);
		}

		return true;
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function getNotBannedNotSubforumModeratorUsers($data) {
		$result = $this->mongo_db->db->users->find(
			array('ban_data' => array('$exists' => false),
					'moderator_for_forums.forum_id' => array('$nin' => array($data['forum_id'])),
					'moderator_for_subforums.subforum_id' => array('$nin' => array($data['subforum_id'])))
		);

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
	public function addNewSubforumModerator($data) {
		$result = $this->mongo_db->db->forums->update(
			array('_id' => $data['forum_id'], 'subforums.id' => $data['subforum_id']),
			array('$push' => array(
					'subforums.$.moderators' => array(
						'user_id' => $data['user_id'],
						'firstname' => $data['firstname'],
						'lastname' => $data['lastname'],
						'username' => $data['username']
					)
				),
				'$inc' => array('subforums.$.subforum_moderators_num' => (int)1)
			)
		);

		$this->mongo_db->db->users->update(
			array('_id' => $data['user_id']),
			array(
				'$push' => array(
					'moderator_for_subforums' => array(
						'subforum_id' => $data['subforum_id'],
						'can_edit_posts' => $data['can_edit_posts'],
						// 'can_hide_posts' => $data['can_hide_posts'],
						'can_delete_posts' => $data['can_delete_posts'],
						'can_open_topics' => $data['can_open_topics'],
						'can_edit_topics' => $data['can_edit_topics'],
						'can_close_topics' => $data['can_close_topics'],
						'can_delete_topics' => $data['can_delete_topics'],
						// 'can_ban_users' => $data['can_ban_users'],
						// 'can_restore_banned_users' => $data['can_restore_banned_users'],
					)
				),
				'$set' => array('group_type' => 'Модератор')
			)
		);

		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $data['user_id']),
				array('$set' => array('user_data.group_type' => 'Модератор')),
				array('multiple' => true)
			);

		$this->mongo_db->db->posts
			->update(
				array('likes_users.id' => $data['user_id']),
				array('$set' => array('likes_users.$.group_type' => 'Модератор')),
				array('multiple' => true)
			);

		return true;
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function getSubforumModeratorsList($data) {
		$result = $this->mongo_db->db->forums->find(
			array('_id' => $data['forum_id'], 'subforums.id' => $data['subforum_id']),
			array('subforums.$.moderators' => true)
		);

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
	public function deleteSubforumModerator($data) {
		$this->mongo_db->db->users->update(
			array('_id' => $data['user_id']),
			array(
				'$pull' => array(
					'moderator_for_subforums' => array(
						'subforum_id' => $data['subforum_id']
					)
				),
				'$set' => array('group_type' => 'Член')
			)
		);

		$this->mongo_db->db->forums->update(
			array('_id' => $data['forum_id'], 'subforums.id' => $data['subforum_id']),
			array('$pull' => array(
					'subforums.$.moderators' => array(
						'user_id' => $data['user_id']
					)
				),
				'$inc' => array('subforums.$.subforum_moderators_num' => (int)-1)
			)
		);

		$this->mongo_db->db->posts
			->update(
				array('user_data.id' => $data['user_id']),
				array('$set' => array('user_data.group_type' => 'Член')),
				array('multiple' => true)
			);

		$this->mongo_db->db->posts
			->update(
				array('likes_users.id' => $data['user_id']),
				array('$set' => array('likes_users.$.group_type' => 'Член')),
				array('multiple' => true)
			);

		return true;
	}

	/**
	 * 
	 * @param unknown_type $user_id
	 * @param unknown_type $subforum_id
	 */
	public function getSubforumModeratorAbilities($user_id, $subforum_id) {
		$result = $this->mongo_db->db->users->findOne(
			array('_id' => $user_id, 'moderator_for_subforums.subforum_id' => $subforum_id),
			array('moderator_for_subforums.$' => true)
		);

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
	public function editSubforumModerator($data) {
		$result = $this->mongo_db->db->users->update(
			array('_id' => $data['user_id'], 'moderator_for_subforums.subforum_id' => $data['subforum_id']),
			array('$set' => array(
					'moderator_for_subforums.$.can_edit_posts' => $data['can_edit_posts'],
					// 'moderator_for_subforums.$.can_hide_posts' => $data['can_hide_posts'],
					'moderator_for_subforums.$.can_delete_posts' => $data['can_delete_posts'],
					'moderator_for_subforums.$.can_open_topics' => $data['can_open_topics'],
					'moderator_for_subforums.$.can_edit_topics' => $data['can_edit_topics'],
					'moderator_for_subforums.$.can_close_topics' => $data['can_close_topics'],
					'moderator_for_subforums.$.can_delete_topics' => $data['can_delete_topics'],
					// 'moderator_for_subforums.$.can_ban_users' => $data['can_ban_users'],
					// 'moderator_for_subforums.$.can_restore_banned_users' => $data['can_restore_banned_users'],
				)
			)
		);

		if($result) {
			return true;
		} else {
			return false;
		}
	}
	
}