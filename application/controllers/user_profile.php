<?php

class User_Profile extends CI_Controller {

	public function __construct() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Mobile-App');

		parent::__construct();

		$this->load->library('email');
		$this->load->model('user_profile_model');
	}

	public function userProfile($user_id) {
		$user_id = new MongoId($user_id);
		$user_data = $this->user_profile_model->getUserDetails($user_id);

		$user_data['join_date'] = humanTiming($user_data['join_date']->sec);
		$user_data['last_activity'] = humanTiming($user_data['last_activity']->sec);

		$data = array(
			'user_data' => $user_data,
			'session' => $this->session->all_userdata(),
		);

		$this->load->view('user_profile_view', $data);
	}

	public function getPostsCount() {
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$posts_count = $this->user_profile_model->getPostsCount($user_id);

		if(!$posts_count) {
			echo 0;
			exit();
		}

		echo $posts_count;
		exit();
	}

	public function getPostsList() {
		$this->form_validation->set_rules('user_id', 'Topic id', 'required');
		$this->form_validation->set_rules('from', 'From', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$from = $this->input->post('from');

		$posts = $this->user_profile_model->getPostsList($user_id, $from);

		if(!$posts) {
			echo 0;
			exit();
		}

		$posts_array = array();
		foreach ($posts as $key => $value) {
			$value['date'] = humanTiming($value['date']->sec);
			$posts_array[] = $value;
		}

		echo json_encode($posts_array);
		exit();
	}

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
				'id' => new MongoId($this->session->userdata('id')),
				'firstname' => $this->session->userdata('firstname'),
				'lastname' => $this->session->userdata('lastname'),
				'username' => $this->session->userdata('username')
			),
			'ban_period' => $ban_period_arr[1] . ' ' . $ban_period_arr[0],
			'ban_reason' => $this->input->post('ban_reason'),
			'banned_on' => new MongoDate(strtotime($banned_on)),
			'ban_lift' => new MongoDate(strtotime($ban_lift)),
		);

		$result = $this->user_profile_model->banUser($data);

		if($result) {
			$this->sendEmail($data['user_id']);
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	private function calculateBanLift($banned_on, $ban_period) {
		// $newdate = strtotime ( '+3 month' , strtotime ( $date ) ) ;
		$ban_lift = strtotime ('+' . $ban_period[1] . ' ' . $ban_period[0] , strtotime($banned_on));
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

	public function userLiftBan() {
		$this->form_validation->set_rules('user_id', 'User id', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));

		$result = $this->user_profile_model->userLiftBan($user_id);

		if($result) {
			echo 1;
			exit();
		} else {
			echo 0;
			exit();
		}
	}

	private function sendEmail($user_id) {
		$user_data = $this->user_profile_model->getUserDetails($user_id);
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










    public function getUserProfileMobile() {
    	$this->form_validation->set_rules('user_id', 'Topic id', 'required');

    	if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$user_data = $this->user_profile_model->getUserDetails($user_id);

		if (!$user_data) {
			echo 0;
			exit();
		}
		
		echo json_encode($user_data);
		exit();
	}

    public function getPostsListMobile() {
		$this->form_validation->set_rules('user_id', 'Topic id', 'required');
		$this->form_validation->set_rules('from', 'From', 'required');
		$this->form_validation->set_rules('limit', 'Limit', 'required');

		if(!$this->form_validation->run()) {
			echo 0;
			exit();
		}

		$user_id = new MongoId($this->input->post('user_id'));
		$from = $this->input->post('from');
		$limit = $this->input->post('limit');

		$posts = $this->user_profile_model->getPostsListMobile($user_id, $from, $limit);

		if(!$posts) {
			echo 0;
			exit();
		}

		$posts_array = array();
		foreach ($posts as $key => $value) {
			$value['date'] = humanTiming($value['date']->sec);
			$posts_array[] = $value;
		}

		echo json_encode($posts_array);
		exit();
	}

}