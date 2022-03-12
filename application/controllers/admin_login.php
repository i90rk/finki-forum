<?php

class Admin_login extends MY_Controller {

	public function __construct() {
		parent::__construct();

		if($this->loggedin == TRUE && $this->group_type == 'Администратор') {
			redirect('admin_dashboard', 'location');
		}

		$this->load->model('admin_login_model');
	}

	/**
	 * 
	 */
	public function index() {
		$this->load->view('admin_login_view');
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

		$password = $this->input->post('password');
		$hashed_password = hash('sha1', $password);

		$data = array(
				'username' => $this->input->post('username'),
				'password' => $hashed_password
			);

		$result = $this->admin_login_model->verifyUser($data);

		if(isset($result) && !empty($result)) {
			$this->setUserSession($result);
			echo 1;
			exit();
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
	            'loggedin' => TRUE,
                // 'admin_privilegies' => $data['admin_privilegies']
            );

        $this->session->set_userdata($session_data);
	}

	/**
	 * 
	 */
	public function adminLogout() {
		$this->session->sess_destroy();
        redirect('admin_login');
	}
}