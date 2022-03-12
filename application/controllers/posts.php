<?php

class Posts extends CI_Controller {

	public function __construct() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Mobile-App');

		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('topics_model');
		$this->load->model('posts_model');
	}

	public function postsList($subforum_id, $topic_id) {
		if(!$subforum_id || !$topic_id) {
			show_404();
			exit();
		}

		$subforum_id = new MongoId($subforum_id);
		$topic_id = new MongoId($topic_id);

		$this->posts_model->incrementTopicViews($topic_id);

		$data = array(
			'session' => $this->session->all_userdata(),
			'breadcrumbs' => $this->posts_model->getPostsBreadcrumpsNav($subforum_id, $topic_id),
			'topic_closed' => $this->posts_model->getTopicClosedFlag($topic_id)
		);

		$this->load->view('posts_view', $data);
	}

	public function getPostsCount() {
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$topic_id = new MongoId($this->input->post('topic_id'));
		$posts_count = $this->posts_model->getPostsCount($topic_id);

		if(!$posts_count) {
			echo 0;
			exit();
		}

		echo $posts_count;
		exit();
	}

	public function getPostsList() {
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');
		$this->form_validation->set_rules('from', 'From', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$topic_id = new MongoId($this->input->post('topic_id'));
		$from = $this->input->post('from');

		$posts = $this->posts_model->getPostsList($topic_id, $from);

		if(!$posts) {
			echo 0;
			exit();
		}

		$posts_array = array();
		$temp_br = (int)$from+1;
		foreach ($posts as $key => $value) {
			$value['timestamp'] = $value['date']->sec;
			$value['date'] = humanTiming($value['date']->sec);
			$value['user_data']['join_date'] = humanTiming($value['user_data']['join_date']->sec);
			$value['order_number'] = $temp_br++;
			$posts_array[] = $value;
		}

		echo json_encode($posts_array);
		exit();
	}

	public function addNewPost() {
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');
		$this->form_validation->set_rules('post', 'Post', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_posts_likes_cnt = $this->posts_model->getUserPostsLikesCnt();


		$last_post = array(
			'id' => new MongoId($this->session->userdata('id')),
			'username' => $this->session->userdata('username'),
			'date' => new MongoDate()
		);

		$post_data = array(
			'_id' => new MongoId(),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'topic_data' => array(
				'topic_id' => new MongoId($this->input->post('topic_id')),
				'topic_title' => $this->input->post('topic_title'),
			),
			'post' => $this->input->post('post'),
			'date' => new MongoDate(),
			'likes_num' => (int)0,
			'user_data' => array(
				'id' => new MongoId($this->session->userdata('id')),
				'username' => $this->session->userdata('username'),
				'avatar' => $this->session->userdata('avatar_image'),
				'join_date' => $this->session->userdata('join_date'),
				'group_type' => $this->session->userdata('group_type'),
				'posts_num' => (int)$user_posts_likes_cnt['posts_num'] + 1,
				'likes_num' => (int)$user_posts_likes_cnt['likes_num'],
			)
		);

		$all_data = array(
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'topic_id' => new MongoId($this->input->post('topic_id')),
			'last_post' => $last_post,
			'post_data' => $post_data,
			'user_id' => new MongoId($this->session->userdata('id')),
			'date' => new MongoDate(),
			'group_type' => $this->session->userdata('group_type')
		);

		$result = $this->posts_model->addNewPost($all_data);

		/* Update user session */
		$sessionData = $this->session->all_userdata('user_data');
        $sessionData['user_last_activity'] = new MongoDate();
        // $sessionData['posts_num'] = (int)$this->session->userdata('posts_num') + 1;
        $sessionData['posts_num'] = (int)$user_posts_likes_cnt['posts_num'] + 1;
        $this->session->set_userdata($sessionData);

		if(!$result) {
			echo 0;
			exit(); 
		} else {
			echo 1;
			exit();
		}
	}

	public function editPost() {
		$this->form_validation->set_rules('post_id', 'Post id', 'required');
		$this->form_validation->set_rules('post', 'Post', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'post_id' => new MongoId($this->input->post('post_id')),
			'post' => $this->input->post('post')
		);

		$result = $this->posts_model->editPost($data);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}

	public function deletePost() {
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');
		$this->form_validation->set_rules('post_id', 'Post id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'topic_id' => new MongoId($this->input->post('topic_id')),
			'post_id' => new MongoId($this->input->post('post_id')),
			'user_id' => new MongoId($this->input->post('user_id'))
		);

		$result = $this->posts_model->deletePost($data);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}

	public function editTopic() {
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');
		$this->form_validation->set_rules('topic_title', 'Topic title', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'topic_id' => new MongoId($this->input->post('topic_id')),
			'title' => $this->input->post('topic_title'),
		);

		$result = $this->posts_model->editTopic($data);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}

	public function likePost() {
		$this->form_validation->set_rules('post_id', 'Post id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_posts_likes_cnt = $this->posts_model->getUserPostsLikesCnt();

		$session_user_id = $this->session->userdata('id');
		$post_id = $this->input->post('post_id');
		$post_user_id = new MongoId($this->input->post('user_id'));

		if($session_user_id->{'$id'} == $this->input->post('user_id')) {
			$likes_num = (int)$user_posts_likes_cnt['likes_num'] + 1;
		} else {
			$likes_num = (int)$user_posts_likes_cnt['likes_num'];
		}

		$like_user_data = array(
			'id' => new MongoId($this->session->userdata('id')),
			'username' => $this->session->userdata('username'),
			'posts_num' => $user_posts_likes_cnt['posts_num'],
			'likes_num' => $likes_num,
			'group_type' => $this->session->userdata('group_type'),
			'avatar_image' => $this->session->userdata('avatar_image'),
		);

		$result = $this->posts_model->likePost($post_id, $post_user_id, $like_user_data);

		if(!$result) {
			echo 0;
			exit();
		}

		$post_data = $this->posts_model->getPostData($post_id);

		$sessionData = $this->session->all_userdata('user_data');
        $sessionData['likes_posts_ids'][] = $post_id;
        $this->session->set_userdata($sessionData);

		echo json_encode($post_data);
		exit();
	}

	public function unlikePost() {
		$this->form_validation->set_rules('post_id', 'Post id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$post_id = $this->input->post('post_id');
		$post_user_id = new MongoId($this->input->post('user_id'));
		$like_user_id = new MongoId($this->session->userdata('id'));

		$result = $this->posts_model->unlikePost($post_id, $post_user_id, $like_user_id);

		if(!$result) {
			echo 0;
			exit();
		}

		$post_data = $this->posts_model->getPostData($post_id);

		$sessionData = $this->session->all_userdata('user_data');
		$id_to_delete = array_search($post_id, $sessionData['likes_posts_ids']);
		unset($sessionData['likes_posts_ids'][$id_to_delete]);
        // $sessionData['likes_posts_ids'][] = $post_id;
        $this->session->set_userdata($sessionData);

		echo json_encode($post_data);
		exit();
	}

	public function closeTopic() {
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$topic_id = new MongoId($this->input->post('topic_id'));

		$result = $this->posts_model->closeTopic($topic_id);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}

	public function openTopic() {
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$topic_id = new MongoId($this->input->post('topic_id'));

		$result = $this->posts_model->openTopic($topic_id);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}

	public function showMoreLikeUsers() {
		$this->form_validation->set_rules('post_id', 'Post id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$post_id = new MongoId($this->input->post('post_id'));

		$result = $this->posts_model->showMoreLikeUsers($post_id);

		if(!$result) {
			echo 0;
			exit();
		}

		echo json_encode($result);
		exit();
	}

	public function deleteTopic() {
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$subforum_id = new MongoId($this->input->post('subforum_id'));
		$topic_id = new MongoId($this->input->post('topic_id'));

		$result = $this->posts_model->deleteTopic($subforum_id, $topic_id);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}

















	public function getTopicInfoMobile() {
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$topic_id = new MongoId($this->input->post('topic_id'));
		$this->posts_model->incrementTopicViews($topic_id);
		$topic_closed = $this->posts_model->getTopicClosedFlag($topic_id);

		echo $topic_closed;
		exit();
	}

	public function getPostsListMobile() {
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');
		$this->form_validation->set_rules('from', 'From', 'required');
		$this->form_validation->set_rules('limit', 'Limit', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$topic_id = new MongoId($this->input->post('topic_id'));
		$from = $this->input->post('from');
		$limit = $this->input->post('limit');

		$posts = $this->posts_model->getPostsList($topic_id, $from, $limit);

		if(!$posts) {
			echo 0;
			exit();
		}

		$posts_array = array();
		$temp_br = (int)$from+1;
		foreach ($posts as $key => $value) {
			$value['timestamp'] = $value['date']->sec;
			$value['date'] = humanTiming($value['date']->sec);
			$value['user_data']['join_date'] = humanTiming($value['user_data']['join_date']->sec);
			$value['order_number'] = $temp_br++;
			$posts_array[] = $value;
		}

		echo json_encode($posts_array);
		exit();
	}

	public function addNewPostMobile() {
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('topic_id', 'Topic id', 'required');
		$this->form_validation->set_rules('post', 'Post', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = $this->input->post('user_id');
		$user_posts_likes_cnt = $this->posts_model->getUserPostsLikesCntMobile($user_id);

		$last_post = array(
			'id' => new MongoId($user_id),
			'username' => $this->input->post('username'),
			'date' => new MongoDate()
		);

		$post_data = array(
			'_id' => new MongoId(),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'topic_data' => array(
				'topic_id' => new MongoId($this->input->post('topic_id')),
				'topic_title' => $this->input->post('topic_title'),
			),
			'post' => $this->input->post('post'),
			'date' => new MongoDate(),
			'likes_num' => (int)0,
			'user_data' => array(
				'id' => new MongoId($user_id),
				'username' => $this->input->post('username'),
				'avatar' => $this->input->post('avatar_image'),
				'join_date' => new MongoDate($this->input->post('join_date')),
				'group_type' => $this->input->post('group_type'),
				'posts_num' => (int)$user_posts_likes_cnt['posts_num'] + 1,
				'likes_num' => (int)$user_posts_likes_cnt['likes_num'],
			)
		);

		if (isset($_FILES['file'])) {
			$file_name = $_FILES['file']['name'];
			$file_size = $_FILES['file']['size'];
			$file_tmp = $_FILES['file']['tmp_name'];
			$file_type = $_FILES['file']['type'];
			$file_ext = strtolower(end(explode('/', $file_type)));

			$hash = generateHash();

			if (strpos($file_type, 'image') !== false) {
				try {
					$hashedName = $hash . '.' . $file_ext;
					$imagePath = 'resources/uploads/images/' . basename($hashedName);
					move_uploaded_file($file_tmp, $imagePath);
					$post_data['image_data'] = array(
						'image_path' => $imagePath,
						'image_type' => $file_type,
						'image_name' => $hashedName
					);
				} catch (Exception $e) {
					echo 'Message: ' . $e->getMessage();
				}
			}

			if (strpos($file_type, 'video') !== false) {
				// original file name
				$hashedNameO = $hash . '.' . $file_ext;
				// converted file name
				$hashedNameC = $hash . '.webm';
				// thumbnail image
				$thumbnailName = $hash . '.png';

				$video_pathO = 'resources/uploads/videos/' . basename($hashedNameO);
				// $video_pathC = 'resources/uploads/videos/' . basename($hashedNameC);
				$thumbnail_path = 'resources/uploads/videos_thumbnails/' . basename($thumbnailName);

				move_uploaded_file($file_tmp, $video_pathO);

				// $shell_exec_command = 'ffmpeg -i ' . $video_pathO . ' ' . $video_pathC;
				// $shell_out = shell_exec($shell_exec_command);

				$shell_exec_command = 'ffmpeg -i ' . $video_pathO . ' -ss 00:00:01.000 -vframes 1 ' . $thumbnail_path;
				$shell_out = shell_exec($shell_exec_command);

				// ffmpeg -i $uploaded_file -ss 00:00:01.000 -vframes 1 output.png
				// $shell_out = shell_exec('rm ' . $video_pathO);

				$post_data['video_data'] = array(
					'video_path' => $video_pathO,
					'video_type' => $file_ext,
					'video_name' => $hashedNameO,
					'video_thumb' => $thumbnail_path
				);
			}
		}

		$all_data = array(
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'topic_id' => new MongoId($this->input->post('topic_id')),
			'last_post' => $last_post,
			'post_data' => $post_data,
			'user_id' => new MongoId($user_id),
			'date' => new MongoDate(),
			'group_type' => $this->input->post('group_type')
		);

		$result = $this->posts_model->addNewPost($all_data);

		if(!$result) {
			echo 0;
			exit(); 
		} else {
			echo 1;
			exit();
		}
	}

	public function likePostMobile() {
		$this->form_validation->set_rules('post_id', 'Post id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		$this->form_validation->set_rules('loggedin_user_id', 'Loggedin UserId', 'required');
		$this->form_validation->set_rules('username', 'Loggedin Username', 'required');
		$this->form_validation->set_rules('group_type', 'Loggedin Group Type', 'required');
		// $this->form_validation->set_rules('avatar_image', 'Loggedin Avatar Image', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$post_id = $this->input->post('post_id');
		$post_user_id = new MongoId($this->input->post('user_id'));
		$session_user_id = $this->input->post('loggedin_user_id');
		$session_username = $this->input->post('username');
		$session_group_type = $this->input->post('group_type');
		$session_avatar_image = $this->input->post('avatar_image');

		$user_posts_likes_cnt = $this->posts_model->getUserPostsLikesCntMobile($session_user_id);

		if($session_user_id == $post_user_id) {
			$likes_num = (int)$user_posts_likes_cnt['likes_num'] + 1;
		} else {
			$likes_num = (int)$user_posts_likes_cnt['likes_num'];
		}

		$like_user_data = array(
			'id' => new MongoId($session_user_id),
			'username' => $session_username,
			'posts_num' => $user_posts_likes_cnt['posts_num'],
			'likes_num' => $likes_num,
			'group_type' => $session_group_type,
			'avatar_image' => $session_avatar_image,
		);

		$result = $this->posts_model->likePost($post_id, $post_user_id, $like_user_data);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}

	public function unlikePostMobile() {
		$this->form_validation->set_rules('post_id', 'Post id', 'required');
		$this->form_validation->set_rules('user_id', 'User id', 'required');
		$this->form_validation->set_rules('like_user_id', 'Like user id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$post_id = $this->input->post('post_id');
		$post_user_id = new MongoId($this->input->post('user_id'));
		$like_user_id = new MongoId($this->input->post('like_user_id'));

		$result = $this->posts_model->unlikePost($post_id, $post_user_id, $like_user_id);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}
}