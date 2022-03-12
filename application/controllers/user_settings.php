<?php

class User_Settings extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('user_settings_model');
	}

	public function userSettings($user_id) {
		$user_data = $this->user_settings_model->getUserDetails($user_id);

		$user_data['join_date'] = humanTiming($user_data['join_date']->sec);
		$user_data['last_activity'] = humanTiming($user_data['last_activity']->sec);

		$data = array(
			'user_data' => $user_data,
			'session' => $this->session->all_userdata(),
		);

		$this->load->view('user_settings_view', $data);
	}

	public function changeBasicSettings() {
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->session->userdata('id'));
		
		$user_data = array(
			'firstname' => $this->input->post('firstname'),
			'lastname' => $this->input->post('lastname'),
			'birth_day' => $this->input->post('birth_day'),
			'birth_month' => $this->input->post('birth_month'),
			'birth_year' => $this->input->post('birth_year'),
		);

		$result = $this->user_settings_model->changeBasicSettings($user_id, $user_data);

		if(!$result) {
			echo 0;
			exit();
		}

		$sessionData = $this->session->all_userdata('user_data');
        $sessionData['firstname'] = $user_data['firstname'];
        $sessionData['lastname'] = $user_data['lastname'];
        $this->session->set_userdata($sessionData);

        echo 1;
        exit();
	}

	public function changeAvatar() {
		if(!isset($_FILES) || empty($_FILES)) {
			echo 0;
			exit();
		}

		
        $tmp = explode('.', $_FILES['avatar']['name']);
        $extension = $tmp[1];
        $hashedName = generateHash() . '.' . $extension;
        $img_path = 'resources/uploads/user_avatars/' . basename($hashedName);
        move_uploaded_file($_FILES['avatar']['tmp_name'], $img_path);

        $user_id = new MongoId($this->session->userdata('id'));

        $result = $this->user_settings_model->changeAvatar($user_id, $img_path);

        if(!$result) {
        	echo 0;
        	exit();
        }

        $sessionData = $this->session->all_userdata('user_data');
        $sessionData['avatar_image'] = $img_path;
        $this->session->set_userdata($sessionData);

        echo json_encode($img_path);
        exit();
	}

	public function changePassword() {
		$this->form_validation->set_rules('old_password', 'Old password', 'required');
		$this->form_validation->set_rules('new_password', 'New password', 'required');
		$this->form_validation->set_rules('password_confirm', 'Confirm password', 'required|matches[new_password]');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->session->userdata('id'));
		$old_password = hash('sha1', $this->input->post('old_password'));
		$new_password = hash('sha1', $this->input->post('new_password'));

		$pass_valid = $this->user_settings_model->checkOldPassword($user_id, $old_password);

		if(!$pass_valid) {
			echo 2;
			exit();
		}

		$result = $this->user_settings_model->changePassword($user_id, $new_password);

		if(!$result) {
			echo 0;
			exit();
		}

		echo 1;
		exit();
	}
}