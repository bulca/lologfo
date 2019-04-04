<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!$this->usermodel->logged_in()
				|| !$this->usermodel->has_any_perm_in ('admin')) {
			redirect('/login');
		}

		$this->template->set('useMenu', 'admin');
	}

	public function index( )
	{
		$this->template->set('title', 'Admin');
		$this->template->set('laf', array(
			'menu' => 'admin',
			'breadcrumbs' => array('admin')
		));
		$this->template->render();
	}

	public function newsFeed( )
	{
		$this->template->set('title', 'News Feed');			
		$this->template->set('laf', array(
			'menu' => 'news_feed',
			'breadcrumbs' => array('admin', 'admin_newsfeed')
		));
		$this->template->render();
	}

	public function createPost()
	{
		$title = $this->input->post('title');
		$color = $this->input->post('color');
		$icon = $this->input->post('icon');
		$content = $this->input->post('content');

		if($title && strlen($title) <= 128
			&& $color && strlen($color) <= 10
			&& $icon && strlen($icon) <= 15
			&& $content) {
			$this->load->model('feedmodel');
			$this->feedmodel->insert(array(
				'color' => $color,
				'icon' => $icon,
				'header' => $title,
				'content' => $content
			));
			redirect('/admin/newsFeed');
		}

		$this->template->set('title', 'Create New Post');			
		$this->template->set('laf', array(
			'menu' => 'news_feed',
			'breadcrumbs' => array('admin', 'admin_newsfeed', 'admin_newsfeed_create')
		));
		$this->template->render();
	}

	public function accounts()
	{
		$this->template->set('title', 'Accounts');			
		$this->template->set('laf', array(
			'menu' => 'accounts',
			'breadcrumbs' => array('admin', 'admin_accounts')
		));
		$this->template->render();
	}

	public function accountTypes()
	{
		$this->load->model('accountmodel');
		$this->template->set('types', $this->accountmodel->get_types ());
		$this->template->set('title', 'Account Types');			
		$this->template->set('laf', array(
			'menu' => 'accounts',
			'breadcrumbs' => array('admin', 'admin_account_types')
		));
		$this->template->render();
	}

	public function editAccountType($type)
	{
		$this->load->model('accountmodel');

		if($type == NULL || !$this->accountmodel->type_exists($type)) {
			redirect('/admin/accountTypes');
		}

		$type = $this->accountmodel->get_type($type, FALSE);
		$format = $this->input->post('format');

		if($format) {
			@json_decode($format);
 			if(json_last_error() == JSON_ERROR_NONE) {
 				$this->accountmodel->update_type(array('type' => $type->type), array('format' => $format));
 				$this->template->set('success', 'true');
 			} else {
 				$this->template->set('error', 'Invalid JSON format. You can validate the new format before you submit it ' . anchor('http://jsonlint.com/', 'here'));
 			}
		}

		$this->template->set('type', $type);
		$this->template->set('title', 'Edit Account Type');
		$this->template->set('laf', array(
			'menu' => 'accounts',
			'breadcrumbs' => array('admin', 'admin_account_types', 'admin_account_types_edit')
		));
		$this->template->render();
	}


	public function users( )
	{
		redirect('/admin/userPayouts');
		exit;

		$this->template->set('title', 'Users');
		$this->template->set('laf', array(
			'menu' => 'users',
			'breadcrumbs' => array('admin', 'admin_users')
		));
		$this->template->render();
	}

	public function userPayouts( )
	{
		$user = $this->input->post('user');
		$due = $this->input->post('due');
		$btca = $this->input->post('btca');

		if($user && is_numeric($user) && $due)
		{
			$user = $this->usermodel->get(array(
				'id' => $user));

			if($user) {
				$this->load->model('feedmodel');
				$this->feedmodel->insert(array(
					'color' => 'yellow',
					'icon' => 'envelope',
					'header' => 'Payout',
					'content' => number_format($due, 2) . ' has been payed out and deposited into your BTC account (' . $btca . ').'
				), $user['id']);
				$this->db->set('balance_due', 'balance_due-' . $due, FALSE);
				$this->usermodel->update(array('id' => $user['id']), array('last_payout' => time()));
			}
		}

		$this->template->set('users', $this->usermodel->admin_get_need_payout());
		$this->template->set('title', 'User Payouts');
		$this->template->set('laf', array(
			'menu' => 'users',
			'breadcrumbs' => array('admin', 'admin_user_payouts')
		));
		$this->template->render();
	}
}