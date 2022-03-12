<?php 

	class Banned_user extends CI_Controller {

		public function __construct() {
			parent::__construct();

			$this->load->model('banned_user_model');
		}

		public function bannedUser($user_id) {
			$ban_data = $this->banned_user_model->getUserBanData($user_id);

			$data = array(
				'session' => $this->session->all_userdata(),
				'ban_data' => $ban_data
			);

			$this->load->view('banned_user_view', $data);
		}
	}
?>