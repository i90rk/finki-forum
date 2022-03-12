<?php

class MY_Controller extends CI_Controller {

	protected $loggedin;
	protected $group_type;
	public $userdata;

	public function __construct() {
		parent::__construct();
		
		$this->loggedin = $this->session->userdata('loggedin');
		$this->group_type = $this->session->userdata('group_type');
		$this->userdata = $this->session->all_userdata();
		
		if (($this->loggedin !== TRUE || $this->group_type !== 'Администратор') && $this->uri->segment(1) !== 'admin_login') {
			redirect('admin_login', 'location');
		}
	}
}