<?php

class Global_actions extends CI_Controller {

	public function __construct() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Mobile-App');
		
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('JWT');
		$this->load->model('global_actions_model');
	}

	/**
	 * 
	 */
	public function registerUser() {
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[password]');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$data = array(
			'firstname' => $this->input->post('firstname'),
			'lastname' => $this->input->post('lastname'),
			'username' => $this->input->post('username'),
			'password' => hash('sha1', $this->input->post('password')),
			'email' => $this->input->post('email'),
			'join_date' => new MongoDate(),
			'last_activity' => new MongoDate(),
			'posts_num' => (int)0,
			'likes_num' => (int)0,
			'group_type' => 'Член',
			'avatar_image' => DEFAULT_AVATAR_PATH,
			'birth_day' => '',
			'birth_month' => '',
			'birth_year' => ''
		);

		/* Check if username already exists */
		$username_exists = $this->global_actions_model->checkUsername($data['username']);
		if($username_exists) {
			echo 2;
			exit();
		}

		/* Check if email address already exists */
		$email_exists = $this->global_actions_model->checkEmail($data['email']);
		if($email_exists) {
			echo 3;
			exit();
		}

		$result = $this->global_actions_model->registerUser($data);

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
	public function verifyUser() {
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
            exit();
		}

		$data = array(
				'username' => $this->input->post('username'),
				'password' => hash('sha1', $this->input->post('password'))
			);

		$result = $this->global_actions_model->verifyUser($data);

		if(isset($result) && !empty($result)) {
			if(isset($result['ban_data']) && !empty($result['ban_data'])) {
				echo json_encode($result['_id']->{'$id'});
				exit();
			} else {
				$this->setUserSession($result);
				echo 1;
				exit();
			}
		} else {
			echo 2;
            exit();
		}	
	}

	/**
	 * 
	 * @param unknown_type $data
	 */
	public function setUserSession($data) {
		$session_data = array(
            'id' => $data['_id'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'avatar_image' => $data['avatar_image'],
            'join_date' => $data['join_date'],
            'user_last_activity' => $data['last_activity'],
            'group_type' => $data['group_type'],
            'posts_num' => $data['posts_num'],
            'likes_num' => $data['likes_num'],
            'loggedin' => TRUE
        );

        if(isset($data['moderator_for_forums'])) {
			$session_data['moderator_for_forums'] = $data['moderator_for_forums'];
		}

		if (isset($data['moderator_for_subforums'])) {
			$session_data['moderator_for_subforums'] = $data['moderator_for_subforums'];
		}

		if (isset($data['likes_posts_ids'])) {
			$session_data['likes_posts_ids'] = $data['likes_posts_ids'];
		}

		// if (isset($data['admin_privilegies'])) {
		// 	$session_data['admin_privilegies'] = $data['admin_privilegies'];
		// }
		
        $this->session->set_userdata($session_data);
	}

	/**
	 * 
	 */
	public function userLogout() {
		$this->session->sess_destroy();
        redirect('home');
	}
























	public function verifyUserMobile() {
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('api_key', 'API_Key', 'required');

		if (!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$api_key = $this->input->post('api_key');
		$login_data = array(
			'username' => $this->input->post('username'),
			'password' => hash('sha1', $this->input->post('password'))
		);

		$result = $this->global_actions_model->verifyUser($login_data);

		if(isset($result) && !empty($result)) {
			if(isset($result['ban_data']) && !empty($result['ban_data'])) {
				$this->load->model('banned_user_model');
				$ban_data = $this->banned_user_model->getUserBanData($result['_id']);
				$ban_data['ban_data']['ban_lift'] = date('d-m-Y H:i:s', $ban_data['ban_data']['ban_lift']->sec);
				$ban_data['ban_data']['banned_on'] = date('d-m-Y H:i:s', $ban_data['ban_data']['banned_on']->sec);
				echo json_encode(array('ban' => $ban_data['ban_data']));
				exit();
			} else {
				echo json_encode(
					array(
						'token' => $this->generateToken($api_key, $result['_id']),
						'userdata' => $this->setUserDataMobile($result)
					)
				);
				exit();
			}
		} else {
			echo 2;
            exit();
		}
	}

	private function generateToken($api_key, $user_id) {
		$expiration = 86400; // one day

		$issuedAt = new DateTime();
		$issuedAt->setTimeZone(new DateTimeZone('UTC'));
		$issuedAt = $issuedAt->getTimestamp();

		$payload = array(
			'api_key' => $api_key,
			'userId' => $user_id,
			'issuedAt' => $issuedAt,
			'ttl' => $expiration
		);

		return $this->jwt->encode($payload, JWT_SECRET_KEY);
	}

	private function setUserDataMobile($data) {
		$user_data = array(
            'id' => $data['_id'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'avatar_image' => $data['avatar_image'],
            'join_date' => $data['join_date'],
            'user_last_activity' => $data['last_activity'],
            'group_type' => $data['group_type'],
            'posts_num' => $data['posts_num'],
            'likes_num' => $data['likes_num'],
            'loggedin' => TRUE
        );

        return $user_data;
	}
	
}