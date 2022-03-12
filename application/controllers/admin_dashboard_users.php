<?php

class Admin_dashboard_users extends MY_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('email');
		$this->load->model('admin_dashboard_users_model');
	}

	public function index() {
		$this->load->view('admin_dashboard_users_view');
	}



	/* Add new user */
	
	/**
	 * 
	 */
	public function addNewUser() {
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		if(isset($_FILES) && !empty($_FILES)) {
            $tmp = explode('.', $_FILES['avatar']['name']);
            $extension = $tmp[1];
            $hashedName = generateHash() . '.' . $extension;
            $img_path = 'resources/uploads/user_avatars/' . basename($hashedName);
            move_uploaded_file($_FILES['avatar']['tmp_name'], $img_path);
		} else {
			$img_path = 'resources/uploads/default_user_avatar.png';
		}

		$username = $this->input->post('username');
		$checkUsername = $this->admin_dashboard_users_model->checkUsername($username);

		if(!$checkUsername) {
			echo 2;
			exit();
		}

		$email = $this->input->post('email');
		$checkEmail = $this->admin_dashboard_users_model->checkEmail($email);

		if(!$checkEmail) {
			echo 3;
			exit();
		}

		$user_data = array(
			'firstname' => $this->input->post('firstname'),
			'lastname' => $this->input->post('lastname'),
			'username' => $this->input->post('username'),
			'password' => hash('sha1', $this->input->post('password')),
			'email' => $this->input->post('email'),
			'birth_day' => $this->input->post('birth_day'),
			'birth_month' => $this->input->post('birth_month'),
			'birth_year' => $this->input->post('birth_year'),
			'join_date' => new MongoDate(),
			'last_activity' => new MongoDate(),
			'posts' => (int)0,
			'likes' => (int)0,
			'group_type' => 'Член',
			'avatar_image' => $img_path,
		);

		$result = $this->admin_dashboard_users_model->addNewUser($user_data);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}



	/* Manage users */
	
	/**
	 * 
	 */
	public function getRegisteredUsers() {
		$result = $this->admin_dashboard_users_model->getRegisteredUsers();

		$users = array();
		foreach ($result as $value) {
			$users[] = $value;
		}

		if($result) {
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
	public function getUserDetails() {
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$result = $this->admin_dashboard_users_model->getUserDetails($user_id);

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
	public function editUser() {
		$this->form_validation->set_rules('id', 'User id', 'required');
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		// $this->form_validation->set_rules('password', 'Password', 'required');
		// $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		if(isset($_FILES) && !empty($_FILES)) {
            $tmp = explode('.', $_FILES['avatar']['name']);
            $extension = $tmp[1];
            $hashedName = generateHash() . '.' . $extension;
            $img_path = 'resources/uploads/user_avatars/' . basename($hashedName);
            move_uploaded_file($_FILES['avatar']['tmp_name'], $img_path);
		} else {
			$img_path = '';
		}

		$id = new MongoId($this->input->post('id'));

		$username = $this->input->post('username');
		$checkUsername = $this->admin_dashboard_users_model->checkUsernameEdit($id, $username);
		if(!$checkUsername) {
			echo 2;
			exit();
		}

		$email = $this->input->post('email');
		$checkEmail = $this->admin_dashboard_users_model->checkEmailEdit($id, $email);
		if(!$checkEmail) {
			echo 3;
			exit();
		}

		$user_data = array(
			'id' => new MongoId($this->input->post('id')),
			'firstname' => $this->input->post('firstname'),
			'lastname' => $this->input->post('lastname'),
			'username' => $this->input->post('username'),
			// 'password' => hash('sha1', $this->input->post('password')),
			'email' => $this->input->post('email'),
			'birth_day' => $this->input->post('birth_day'),
			'birth_month' => $this->input->post('birth_month'),
			'birth_year' => $this->input->post('birth_year'),
			'avatar_image' => $img_path,
		);

		$result = $this->admin_dashboard_users_model->editUser($user_data);

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
	public function deleteUser() {
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$result = $this->admin_dashboard_users_model->deleteUser($user_id);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}



	/* Ban user */
	
	/**
	 * 
	 */
	public function getNotBannedUsers() {
		$result = $this->admin_dashboard_users_model->getNotBannedUsers();

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
	public function banUser() {
		$this->form_validation->set_rules('user_id', 'User id', 'required');
		$this->form_validation->set_rules('ban_period', 'Ban period', 'required');
		$this->form_validation->set_rules('ban_reason', 'Ban reason', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$ban_period_arr = explode('_', $this->input->post('ban_period'));

		$banned_on = date('Y-m-d h:i:s');
		$ban_lift = $this->calculateBanLift($banned_on, $ban_period_arr);
		// $ban_period_arr[0] = ($ban_period_arr[1] > 1) ? $ban_period_arr[0] . 's' : $ban_period_arr[0];
		$ban_period_arr[0] = $this->changeBanPeriodText($ban_period_arr[0], $ban_period_arr[1]);

		$data = array(
			'user_id' => new MongoId($this->input->post('user_id')),
			'banned_by' => array(
				'id' => new MongoId($this->userdata['id']),
				'firstname' => $this->userdata['firstname'],
				'lastname' => $this->userdata['lastname'],
				'username' => $this->userdata['username']
			),
			'ban_period' => $ban_period_arr[1] . ' ' . $ban_period_arr[0],
			'ban_reason' => $this->input->post('ban_reason'),
			'banned_on' => new MongoDate(strtotime($banned_on)),
			'ban_lift' => new MongoDate(strtotime($ban_lift)),
		);

		$result = $this->admin_dashboard_users_model->banUser($data);

		if($result) {
			$this->sendEmail($data['user_id']);
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	/**
	 * 
	 * @param unknown_type $banned_on
	 * @param unknown_type $ban_period
	 */
	public function calculateBanLift($banned_on, $ban_period) {
		// $newdate = strtotime ( '+3 month' , strtotime ( $date ) ) ;
		$ban_lift = strtotime ('+' . $ban_period[1] . ' ' . $ban_period[0] , strtotime($banned_on)) ;
		$ban_lift = date ('Y-m-d h:i:s', $ban_lift);

		return $ban_lift;
	}

	private function changeBanPeriodText($type, $duration) {
		$change = '';
		switch($type) {
			case 'day':
				$change = ($duration > 1) ? 'дена' : 'ден';
				break;
			case 'month':
				$change = ($duration > 1) ? 'месеци' : 'месец';
				break;
			case 'year':
				$change = ($duration > 1) ? 'години' : 'година';
				break;
		}

		return $change;
	}

	private function sendEmail($user_id) {
		$user_data = $this->admin_dashboard_users_model->getUserDetails($user_id);
        $message = '
                <html>
                <head>
                </head>
                <body>
                <h4>Внимание!!</h4>
                <p>Вашиот пристап до форумот е забранет од страна на администраторот поради следната причина: </p>
                <p><b>' . $user_data['ban_data']['ban_reason'] . '</b></p>
                <p>Вашиот пристап беше забранет на: <b>' . date('d-m-Y H:i:s', $user_data['ban_data']['banned_on']->sec) . '</b></p>
                <p>Забраната истекува на: <b>' . date('d-m-Y H:i:s', $user_data['ban_data']['ban_lift']->sec) . '</b></p>
                </body>
                </html>
            ';
        
        $config['protocol']='smtp';  
        $config['smtp_host']='ssl://smtp.googlemail.com';
        $config['smtp_port']='465';  
        $config['smtp_timeout']='30';  
        $config['smtp_user']='hans.schmitt.inter@gmail.com';  
        $config['smtp_pass']='interinterinter';
        $config['charset']='utf-8';
        $config['mailtype'] = 'html';
        $config['newline']="\r\n";
        
        $this->email->initialize($config);
        
        $this->email->from('finki_forum@yahoo.com', 'Финки Форум');
        $this->email->to($user_data['email']);
        $this->email->subject('Финки Форум - Забранет пристап');
        $this->email->message($message);
        
        if(!$this->email->send()) {
            return false;
        }
        else {
            return true;
        }       
    }



	/* List of banned users */
	
	/**
	 * 
	 */
	public function getBannedUsers() {
		$result = $this->admin_dashboard_users_model->getBannedUsers();

		if($result) {
			$users = array();
			foreach ($result as $value) {
				$value['ban_data']['banned_on'] = date('Y-m-d h:i:s', $value['ban_data']['banned_on']->sec);
				$value['ban_data']['ban_lift'] = date('Y-m-d h:i:s', $value['ban_data']['ban_lift']->sec);
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
	public function userLiftBan() {
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));

		$result = $this->admin_dashboard_users_model->userLiftBan($user_id);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}
}