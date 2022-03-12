<?php

class Home extends CI_Controller {

	public function __construct() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Mobile-App');

		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('home_model');
	}

	/**
	 * 
	 */
	public function index() {
		$forums_arr = array();
		$forums = $this->home_model->getAllForumsSubforums();
		
		foreach($forums as $forum) {
			foreach($forum['subforums'] as $key => $subforum) {

				if($subforum['display_order'] == 0) {
					unset($forum['subforums'][$key]);
				} else {
					// date format
					if(isset($subforum['last_post']) && !empty($subforum['last_post'])) {
						$forum['subforums'][$key]['last_post']['date'] = humanTiming($subforum['last_post']['date']->sec);
					}
				}
			}
			$forums_arr[] = $forum;
		}

		$forums = $this->sortSubforums($forums_arr);

		$data = array(
			'forums' => $forums,
			'session' => $this->session->all_userdata(),
		);

		$this->load->view('home_view', $data);
	}
	
	/**
	 * 
	 * @param unknown_type $forums_arr
	 */
	private function sortSubforums($forums_arr) {
		if(isset($forums_arr[0])) {
			/* Multiple forums - Home view */
			foreach($forums_arr as $key => $result) {
				$sort = array();
				foreach($result['subforums'] as $subkey => $value) {
				    $sort['display_order'][$subkey] = $value['display_order'];
				}

				array_multisort($sort['display_order'], SORT_ASC, $result['subforums']);
				$forums_arr[$key]['subforums'] = $result['subforums'];
			}
		} else {
			/* Single forum - Forums view */
			$sort = array();
			foreach($forums_arr['subforums'] as $subkey => $value) {
			    $sort['display_order'][$subkey] = $value['display_order'];
			}

			array_multisort($sort['display_order'], SORT_ASC, $forums_arr['subforums']);
			$forums_arr['subforums'] = $forums_arr['subforums'];
		}
		

		return $forums_arr;
	}

	/**
	 * 
	 * @param unknown_type $subforum_id
	 */
	public function forums($forum_id) {
		$forum_id = new MongoId($forum_id);

		$single_forum = $this->home_model->getSingleForumDetails($forum_id);

		foreach($single_forum['subforums'] as $key => $subforum) {

			if($subforum['display_order'] == 0) {
				unset($single_forum['subforums'][$key]);
			} else {
				// date format
				if(isset($subforum['last_post']) && !empty($subforum['last_post'])) {
					$single_forum['subforums'][$key]['last_post']['date'] = humanTiming($subforum['last_post']['date']->sec);
				}
			}
		}
			
		$single_forum = $this->sortSubforums($single_forum);

		$data = array(
			'session' => $this->session->all_userdata(),
			'single_forum' => $single_forum
		);

		$this->load->view('forums_view', $data);
	}

	/**
	 *
	 */
	public function getAllForumsSubforums() {
		$forums_arr = array();
		$forums = $this->home_model->getAllForumsSubforums();
		
		foreach($forums as $forum) {
			foreach($forum['subforums'] as $key => $subforum) {

				if($subforum['display_order'] == 0) {
					unset($forum['subforums'][$key]);
				} else {
					// date format
					if(isset($subforum['last_post']) && !empty($subforum['last_post'])) {
						$forum['subforums'][$key]['last_post']['date'] = humanTiming($subforum['last_post']['date']->sec);
					}
				}
			}
			$forums_arr[] = $forum;
		}

		$forums = $this->sortSubforums($forums_arr);

		$data = array(
			'forums' => $forums,
			'session' => $this->session->all_userdata(),
		);

		echo json_encode($data);
		exit();
	}
}