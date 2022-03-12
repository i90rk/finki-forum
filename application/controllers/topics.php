<?php

class Topics extends CI_Controller
{

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Mobile-App');

		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('topics_model');
	}

	public function topicsList($subforum_id)
	{
		if (!$subforum_id) {
			show_404();
			exit();
		}

		$subforum_id = new MongoId($subforum_id);

		$data = array(
			'session' => $this->session->all_userdata(),
			'breadcrumbs' => $this->topics_model->getTopicsBreadcrumpsNav($subforum_id)
		);

		$this->load->view('topics_view', $data);
	}

	public function getTopicsList()
	{
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('from', 'From', 'required');

		if (!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$subforum_id = new MongoId($this->input->post('subforum_id'));
		$from = $this->input->post('from');

		$topics = $this->topics_model->getTopicsList($subforum_id, $from);

		if (!$topics) {
			echo 0;
			exit();
		}

		$topics_array = array();
		foreach ($topics as $value) {
			// $value['date'] = humanTiming($value['date']->sec);
			$value['last_post']['date'] = humanTiming($value['last_post']['date']->sec);
			$value['creation_data']['date'] = humanTiming($value['creation_data']['date']->sec);
			$topics_array[] = $value;
		}

		echo json_encode($topics_array);
		exit();
	}

	public function getTopicsCount()
	{
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');

		if (!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$subforum_id = new MongoId($this->input->post('subforum_id'));
		$topics_count = $this->topics_model->getTopicsCount($subforum_id);

		if (!$topics_count) {
			echo 0;
			exit();
		}

		echo $topics_count;
		exit();
	}

	public function addNewTopic()
	{
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('post', 'Post', 'required');

		if (!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_posts_likes_cnt = $this->topics_model->getUserPostsLikesCnt();

		$last_post = array(
			'id' => new MongoId($this->session->userdata('id')),
			'username' => $this->session->userdata('username'),
			'date' => new MongoDate()
		);

		$topic_data = array(
			'_id' => new MongoId(),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'title' => $this->input->post('title'),
			// 'date' => new MongoDate(),
			'creation_data' => array(
				'id' => new MongoId($this->session->userdata('id')),
				'username' => $this->session->userdata('username'),
				'date' => new MongoDate()
			),
			'closed' => (int)0,
			'views_num' => (int)0,
			'posts_num' => (int)1,
			'last_post' => array(
				'id' => new MongoId($this->session->userdata('id')),
				'username' => $this->session->userdata('username'),
				'date' => new MongoDate()
			)
		);

		$post_data = array(
			'_id' => new MongoId(),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'topic_data' => array(
				'topic_id' => $topic_data['_id'],
				'topic_title' => $topic_data['title']
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
			'last_post' => $last_post,
			'topic_data' => $topic_data,
			'post_data' => $post_data,
			'user_id' => new MongoId($this->session->userdata('id')),
			'date' => new MongoDate()
		);

		$result = $this->topics_model->addNewTopic($all_data);

		/* Update user session */
		$sessionData = $this->session->all_userdata('user_data');
		$sessionData['user_last_activity'] = new MongoDate();
		$sessionData['posts_num'] = (int)$user_posts_likes_cnt['posts_num'] + 1;
		$this->session->set_userdata($sessionData);

		if (!$result) {
			echo 0;
			exit();
		} else {
			echo 1;
			exit();
		}
	}

















	public function getTopicsListMobile()
	{
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('from', 'From', 'required');
		$this->form_validation->set_rules('limit', 'Limit', 'required');

		if (!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$subforum_id = new MongoId($this->input->post('subforum_id'));
		$from = $this->input->post('from');
		$limit = $this->input->post('limit');

		$topics = $this->topics_model->getTopicsList($subforum_id, $from, $limit);

		if (!$topics) {
			echo 0;
			exit();
		}

		$topics_array = array();
		foreach ($topics as $value) {
			$value['last_post']['date'] = humanTiming($value['last_post']['date']->sec);
			$value['creation_data']['date'] = humanTiming($value['creation_data']['date']->sec);
			$topics_array[] = $value;
		}

		echo json_encode($topics_array);
		exit();
	}

	public function addNewTopicMobile()
	{
		$this->form_validation->set_rules('subforum_id', 'Subforum id', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('post', 'Post', 'required');

		if (!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = $this->input->post('user_id');
		$user_posts_likes_cnt = $this->topics_model->getUserPostsLikesCntMobile($user_id);

		$last_post = array(
			'id' => new MongoId($user_id),
			'username' => $this->input->post('username'),
			'date' => new MongoDate()
		);

		$topic_data = array(
			'_id' => new MongoId(),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'title' => $this->input->post('title'),
			'creation_data' => array(
				'id' => new MongoId($user_id),
				'username' => $this->input->post('username'),
				'date' => new MongoDate()
			),
			'closed' => (int)0,
			'views_num' => (int)0,
			'posts_num' => (int)1,
			'last_post' => $last_post
		);

		$post_data = array(
			'_id' => new MongoId(),
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'topic_data' => array(
				'topic_id' => $topic_data['_id'],
				'topic_title' => $topic_data['title']
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
				$video_pathC = 'resources/uploads/videos/' . basename($hashedNameC);
				$thumbnail_path = 'resources/uploads/videos_thumbnails/' . basename($thumbnailName);

				move_uploaded_file($file_tmp, $video_pathO);

				$shell_exec_command = 'ffmpeg -i ' . $video_pathO . ' ' . $video_pathC;
				$shell_out = shell_exec($shell_exec_command);

				$shell_exec_command = 'ffmpeg -i ' . $video_pathC . ' -ss 00:00:01.000 -vframes 1 ' . $thumbnail_path;
				$shell_out = shell_exec($shell_exec_command);

				// ffmpeg -i $uploaded_file -ss 00:00:01.000 -vframes 1 output.png
				$shell_out = shell_exec('rm ' . $video_pathO);

				$post_data['video_data'] = array(
					'video_path' => $video_pathC,
					'video_type' => 'video/webm',
					'video_name' => $hashedNameC,
					'video_thumb' => $thumbnail_path
				);
			}
		}

		$all_data = array(
			'subforum_id' => new MongoId($this->input->post('subforum_id')),
			'last_post' => $last_post,
			'topic_data' => $topic_data,
			'post_data' => $post_data,
			'user_id' => new MongoId($user_id),
			'date' => new MongoDate()
		);

		$result = $this->topics_model->addNewTopic($all_data);

		if (!$result) {
			echo 0;
			exit();
		} else {
			echo 1;
			exit();
		}
	}
}
