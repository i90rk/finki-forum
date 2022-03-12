<?php

class Admin_dashboard extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin_dashboard_model');
	}

	/**
	 * 
	 */
	public function index() {
		$this->load->view('admin_dashboard_view');
	}



	/* Add forums and manage forums*/
	
	/**
	 * 
	 */
	public function getForums() {
		$results = $this->admin_dashboard_model->getForums();

		$forums = array();
		foreach($results as $result) {
			$forums[] = $result;
		}

		if($results) {
			echo json_encode($forums);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function getForumDetails() {
		$this->form_validation->set_rules('forum_id', 'Forum ID', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$forum_id = new MongoId($this->input->post('forum_id'));
		$result = $this->admin_dashboard_model->getForumDetails($forum_id);

		if($result) {
			echo json_encode($result);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function addNewForum() {
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('display_order', 'Display order', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
            exit();
		}

		$forum_data = array(
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'display_order' => (int)$this->input->post('display_order'),
			'forum_moderators_num' => (int)0,
			'date' => new MongoDate()
		);

		$result = $this->admin_dashboard_model->addNewForum($forum_data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function editForum() {
		$this->form_validation->set_rules('id', 'Forum ID', 'required');
		$this->form_validation->set_rules('title', 'Forum title', 'required');
		$this->form_validation->set_rules('description', 'Forum description', 'required');
		$this->form_validation->set_rules('display_order', 'Forum display order', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$forum_data = array(
			'forum_id' => new MongoId($this->input->post('id')),
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'display_order' => (int)$this->input->post('display_order'),
		);

		$result = $this->admin_dashboard_model->editForum($forum_data);

		if(!$result) {
			echo 0;
			exit();
		} else {
			echo 1;
			exit();
		}
	}

	/**
	 * 
	 */
	public function deleteForum() {
		$this->form_validation->set_rules('forum_id', 'Forum ID', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$forum_id = new MongoId($this->input->post('forum_id'));
		$result = $this->admin_dashboard_model->deleteForum($forum_id);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function updateForumsOrders() {
		$this->form_validation->set_rules('orders_list', 'List of forums display order', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = $this->input->post('orders_list');
		$result = $this->admin_dashboard_model->updateForumsOrders($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function getNotBannedNotForumModeratorUsers() {
		$forum_id = new MongoId($this->input->post('forum_id'));
		$result = $this->admin_dashboard_model->getNotBannedNotForumModeratorUsers($forum_id);

		if($result) {
			$users = array();
			foreach ($result as $value) {
				$users[] = $value;
			}

			echo json_encode($users);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function addNewForumModerator() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');
		$this->form_validation->set_rules('user_name', 'User name', 'required');
		$this->form_validation->set_rules('can_edit_posts', 'Can edit post', 'required');
		// $this->form_validation->set_rules('can_hide_posts', 'Can hide post', 'required');
		$this->form_validation->set_rules('can_delete_posts', 'Can delete post', 'required');
		$this->form_validation->set_rules('can_open_topics', 'Can open topics', 'required');
		$this->form_validation->set_rules('can_edit_topics', 'Can edit topics', 'required');
		$this->form_validation->set_rules('can_close_topics', 'Can close topics', 'required');
		$this->form_validation->set_rules('can_delete_topics', 'Can delete topics', 'required');
		// $this->form_validation->set_rules('can_ban_users', 'Can ban users', 'required');
		// $this->form_validation->set_rules('can_restore_banned_users', 'Can restore banned users', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user = $this->input->post('user_name');
		$user_tmp_data = explode(' ', $user);
		$firstname = $user_tmp_data[0];
		$lastname = $user_tmp_data[1];
		$username = substr($user_tmp_data[2], 1, -1);

		$forum_id = new MongoId($this->input->post('forum_id'));
		$subforums_ids = $this->admin_dashboard_model->getSubforumsIds($forum_id);

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'user_id' => new MongoId($this->input->post('user_id')),
			'firstname' => $firstname,
			'lastname' => $lastname,
			'username' => $username,
			'subforums_ids' => $subforums_ids,
			'can_edit_posts' => $this->input->post('can_edit_posts'),
			// 'can_hide_posts' => $this->input->post('can_hide_posts'),
			'can_delete_posts' => $this->input->post('can_delete_posts'),
			'can_open_topics' => $this->input->post('can_open_topics'),
			'can_edit_topics' => $this->input->post('can_edit_topics'),
			'can_close_topics' => $this->input->post('can_close_topics'),
			'can_delete_topics' => $this->input->post('can_delete_topics'),
			// 'can_ban_users' => $this->input->post('can_ban_users'),
			// 'can_restore_banned_users' => $this->input->post('can_restore_banned_users'),
		);
		
		$result = $this->admin_dashboard_model->addNewForumModerator($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function getForumModeratorsList() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$forum_id = new MongoId($this->input->post('forum_id'));
		$result = $this->admin_dashboard_model->getForumModeratorsList($forum_id);

		if($result) {
			$moderators = array();
			$result = iterator_to_array($result);
			if(isset($result) && !empty($result)) {
				foreach ($result[0]['moderators'] as $value) {
					$moderators[] = $value;
				}
			}
			
			echo json_encode($moderators);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function deleteForumModerator() {
		$this->form_validation->set_rules('user_id', 'User id', 'required');
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$forum_id = new MongoId($this->input->post('forum_id'));
		$result = $this->admin_dashboard_model->deleteForumModerator($user_id, $forum_id);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}		
	}

	/**
	 * 
	 */
	public function getForumModeratorAbilities() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$forum_id = new MongoId($this->input->post('forum_id'));
		$result = $this->admin_dashboard_model->getForumModeratorAbilities($user_id, $forum_id);

		if($result) {
			echo json_encode($result);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function editForumModerator() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');
		$this->form_validation->set_rules('can_edit_posts', 'Can edit post', 'required');
		// $this->form_validation->set_rules('can_hide_posts', 'Can hide post', 'required');
		$this->form_validation->set_rules('can_delete_posts', 'Can delete post', 'required');
		$this->form_validation->set_rules('can_open_topics', 'Can open topics', 'required');
		$this->form_validation->set_rules('can_edit_topics', 'Can edit topics', 'required');
		$this->form_validation->set_rules('can_close_topics', 'Can close topics', 'required');
		$this->form_validation->set_rules('can_delete_topics', 'Can delete topics', 'required');
		// $this->form_validation->set_rules('can_ban_users', 'Can ban users', 'required');
		// $this->form_validation->set_rules('can_restore_banned_users', 'Can restore banned users', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'user_id' => new MongoId($this->input->post('user_id')),
			'can_edit_posts' => $this->input->post('can_edit_posts'),
			// 'can_hide_posts' => $this->input->post('can_hide_posts'),
			'can_delete_posts' => $this->input->post('can_delete_posts'),
			'can_open_topics' => $this->input->post('can_open_topics'),
			'can_edit_topics' => $this->input->post('can_edit_topics'),
			'can_close_topics' => $this->input->post('can_close_topics'),
			'can_delete_topics' => $this->input->post('can_delete_topics'),
			// 'can_ban_users' => $this->input->post('can_ban_users'),
			// 'can_restore_banned_users' => $this->input->post('can_restore_banned_users'),
		);

		$result = $this->admin_dashboard_model->editForumModerator($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}



	/* ================================================================================================= */



	/* Add subforums and manage subforums */
	
	/**
	 * 
	 */
	public function getSubforums() {
		$results = $this->admin_dashboard_model->getSubforums();

		$subforums = array();
		foreach($results as $key => $result) {
			// print_r($result);
			$subforums[] = $result;
			
		}

		// sorting the subdocuments by display order
		foreach($subforums as $key => $result) {
			$sort = array();
			foreach($result['subforums'] as $subkey => $value) {
			    $sort['display_order'][$subkey] = $value['display_order'];
			}

			array_multisort($sort['display_order'], SORT_ASC, $result['subforums']);
			$subforums[$key]['subforums'] = $result['subforums'];
		}

		if($results) {
			echo json_encode($subforums);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function getSubforumDetails() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'subforum_id' => new MongoId($this->input->post('subforum_id'))
		);

		$result = $this->admin_dashboard_model->getSubforumDetails($data);

		if(!$result) {
			echo 0;
			exit();
		} else {
			echo json_encode($result);
			exit();
		}
	}

	/**
	 * 
	 */
	public function addNewSubforum() {
		$this->form_validation->set_rules('parent_forum', 'Parent forum', 'required');
		$this->form_validation->set_rules('title', 'Subforum title', 'required');
		$this->form_validation->set_rules('description', 'Subforum description', 'required');
		$this->form_validation->set_rules('display_order', 'Subforum display order', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'id' => new MongoId(),
			'parent_forum' => new MongoId($this->input->post('parent_forum')),
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'display_order' => (int)$this->input->post('display_order'),
			'subforum_moderators_num' => (int)0,
			'date' => new MongoDate(),
			'topics_num' => (int)0,
			'posts_num' => (int)0 
		);

		$result = $this->admin_dashboard_model->addNewSubforum($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function editSubforum() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('parent_id', 'Parent id', 'required');
		$this->form_validation->set_rules('title', 'Subforum title', 'required');
		$this->form_validation->set_rules('description', 'Subforum description', 'required');
		$this->form_validation->set_rules('display_order', 'Subforum display order', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'parent_id' => new MongoId($this->input->post('parent_id')),
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'display_order' => (int)$this->input->post('display_order')
		);

		$result = $this->admin_dashboard_model->editSubforum($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function deleteSubforum() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'subforum_id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'subforum_id' => new MongoId($this->input->post('subforum_id'))
		);

		$result = $this->admin_dashboard_model->deleteSubforum($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function updateSubforumsOrders() {
		$this->form_validation->set_rules('orders_list', 'List of subforums display order', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = $this->input->post('orders_list');
		$result = $this->admin_dashboard_model->updateSubforumsOrders($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function getNotBannedNotSubforumModeratorUsers() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
		);
		$result = $this->admin_dashboard_model->getNotBannedNotSubforumModeratorUsers($data);

		if($result) {
			$users = array();
			foreach ($result as $value) {
				$users[] = $value;
			}

			echo json_encode($users);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function addNewSubforumModerator() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');
		$this->form_validation->set_rules('user_name', 'User name', 'required');
		$this->form_validation->set_rules('can_edit_posts', 'Can edit post', 'required');
		// $this->form_validation->set_rules('can_hide_posts', 'Can hide post', 'required');
		$this->form_validation->set_rules('can_delete_posts', 'Can delete post', 'required');
		$this->form_validation->set_rules('can_open_topics', 'Can open topics', 'required');
		$this->form_validation->set_rules('can_edit_topics', 'Can edit topics', 'required');
		$this->form_validation->set_rules('can_close_topics', 'Can close topics', 'required');
		$this->form_validation->set_rules('can_delete_topics', 'Can delete topics', 'required');
		// $this->form_validation->set_rules('can_ban_users', 'Can ban users', 'required');
		// $this->form_validation->set_rules('can_restore_banned_users', 'Can restore banned users', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user = $this->input->post('user_name');
		$user_tmp_data = explode(' ', $user);
		$firstname = $user_tmp_data[0];
		$lastname = $user_tmp_data[1];
		$username = substr($user_tmp_data[2], 1, -1);

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'user_id' => new MongoId($this->input->post('user_id')),
			'firstname' => $firstname,
			'lastname' => $lastname,
			'username' => $username,
			'can_edit_posts' => $this->input->post('can_edit_posts'),
			// 'can_hide_posts' => $this->input->post('can_hide_posts'),
			'can_delete_posts' => $this->input->post('can_delete_posts'),
			'can_open_topics' => $this->input->post('can_open_topics'),
			'can_edit_topics' => $this->input->post('can_edit_topics'),
			'can_close_topics' => $this->input->post('can_close_topics'),
			'can_delete_topics' => $this->input->post('can_delete_topics'),
			// 'can_ban_users' => $this->input->post('can_ban_users'),
			// 'can_restore_banned_users' => $this->input->post('can_restore_banned_users'),
		);
		
		$result = $this->admin_dashboard_model->addNewSubforumModerator($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function getSubforumModeratorsList() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$forum_id = $this->input->post('forum_id');
		$subforum_id = $this->input->post('subforum_id');

		$data = array(
			'forum_id' => new MongoId($forum_id),
			'subforum_id' => new MongoId($subforum_id),
		);
		$result = $this->admin_dashboard_model->getSubforumModeratorsList($data);
		
		if($result) {
			$moderators = array();
			$result = iterator_to_array($result);
			if(isset($result) && !empty($result)) {
				foreach ($result[$forum_id]['subforums'][0]['moderators'] as $value) {
					$moderators[] = $value;
				}
			}
		
			echo json_encode($moderators);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function deleteSubforumModerator() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'user_id' => new MongoId($this->input->post('user_id')),
		);
		$result = $this->admin_dashboard_model->deleteSubforumModerator($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 1;
			exit();
		}
	}

	/**
	 * 
	 */
	public function getSubforumModeratorAbilities() {
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$subforum_id = new MongoId($this->input->post('subforum_id'));
		$result = $this->admin_dashboard_model->getSubforumModeratorAbilities($user_id, $subforum_id);

		if($result) {
			echo json_encode($result);
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 */
	public function editSuborumModerator() {
		$this->form_validation->set_rules('forum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('subforum_id', 'Forum id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');
		$this->form_validation->set_rules('can_edit_posts', 'Can edit post', 'required');
		// $this->form_validation->set_rules('can_hide_posts', 'Can hide post', 'required');
		$this->form_validation->set_rules('can_delete_posts', 'Can delete post', 'required');
		$this->form_validation->set_rules('can_open_topics', 'Can open topics', 'required');
		$this->form_validation->set_rules('can_edit_topics', 'Can edit topics', 'required');
		$this->form_validation->set_rules('can_close_topics', 'Can close topics', 'required');
		$this->form_validation->set_rules('can_delete_topics', 'Can delete topics', 'required');
		// $this->form_validation->set_rules('can_ban_users', 'Can ban users', 'required');
		// $this->form_validation->set_rules('can_restore_banned_users', 'Can restore banned users', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'forum_id' => new MongoId($this->input->post('forum_id')),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'user_id' => new MongoId($this->input->post('user_id')),
			'can_edit_posts' => $this->input->post('can_edit_posts'),
			// 'can_hide_posts' => $this->input->post('can_hide_posts'),
			'can_delete_posts' => $this->input->post('can_delete_posts'),
			'can_open_topics' => $this->input->post('can_open_topics'),
			'can_edit_topics' => $this->input->post('can_edit_topics'),
			'can_close_topics' => $this->input->post('can_close_topics'),
			'can_delete_topics' => $this->input->post('can_delete_topics'),
			// 'can_ban_users' => $this->input->post('can_ban_users'),
			// 'can_restore_banned_users' => $this->input->post('can_restore_banned_users'),
		);

		$result = $this->admin_dashboard_model->editSubforumModerator($data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}
}