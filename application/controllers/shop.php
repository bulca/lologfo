<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!$this->usermodel->logged_in()) {
			redirect('/login');
		}
	}

	public function index()
	{
		if(!$this->usermodel->has_attr('shop.accepted')) {
			// redirect('/shop/tos');
		}

		$this->load->model('accountmodel');

		// check if valid vendor

		$vendor = $this->input->get('vendor');

		if($vendor && is_numeric($vendor)) {
			$types = $this->accountmodel->get_types($vendor);
			$this->template->set('types', $types);
			$this->template->set('vendor', $vendor);
		} else {
			$this->template->set('types', $this->accountmodel->get_types ());

		}

		$this->template->set('title', 'Browse Shop');
		$this->template->set('laf', array(
			'menu' => 'shop',
			'breadcrumbs' => array('shop')
		));
		$this->template->render();
	}

	public function tos()
	{
		$iaccept = $this->input->post('iaccept');

		if($iaccept) {
			$this->usermodel->add_attr('shop.accepted');
			redirect('/shop');
		}

		$this->template->set('title', 'Shop TOS');
		$this->template->set('laf', array(
			'menu' => 'shop',
			'breadcrumbs' => array('shop')
		));
		$this->template->render();
	}

	public function forType($type = NULL)
	{
		if(!property_exists($this, 'accountmodel'))
			$this->load->model('accountmodel');

		if($type == NULL || !$this->accountmodel->type_exists($type)) {
			redirect('/shop');
		}

		$vendor = $this->input->get('vendor');

		if($vendor && !is_numeric($vendor)) {
			$vendor = NULL;
		}

		$type = $this->accountmodel->get_type($type);
		$where = array('seller <> ' => $this->usermodel->get_id());

		if($vendor != null)
			$where['seller'] = $vendor;

		$like = array();

		foreach($_GET as $k => $v)
			if(strlen($_GET[$k]) > 0 && $k != 'page' && $k != 'account' && $k != 'type' && $k != 'vendor')
				array_push($like, array('meta', '"' . $k . '":"' . $v));

		$this->template->set('type', $type);
		$this->template->set('title', $type->name);
		$where['buyer'] = '0';
		$this->template->set($this->accountmodel->gets($type->type, $this->input->get('page'), 80, $where, $like));
		$this->template->set('laf', array(
			'menu' => 'shop',
			'breadcrumbs' => array('shop', 'shop_view')
		));
		$this->template->render();
	}

	public function buy()
	{
		$account = $this->input->get('account');
		$type = $this->input->get('type');

		if(!is_numeric($account)) {
			redirect('/shop/' . $type);
		}

		$this->load->model('accountmodel');
		$account = $this->accountmodel->get(array('id' => $account, 'buyer' => 0, 'type' => $type), false);

		if(!$account) {
			redirect('/shop/' . $type);
		}

		$this->template->current_view = 'shop/forType';

		if($this->usermodel->get_bal() < $account->price) {
			$this->template->set('error', "Your balance is too low for this purchase. You can add more funds " . anchor('/add-funds', 'here'));
			$this->forType($type);
			return;
		}

		if($type == 'cc') {
			$this->load->helper('checker');
			$type2 = $this->accountmodel->get_type($type);
			$meta = json_decode($account->meta);

			if(!checkCC($this, $meta)) {
				$this->accountmodel->delete($account->id);
				$this->template->set('error', "The CC you had just tried to purchase has expired or is dead and your funds have been refunded.");
				$this->forType($type);
				return;
			}

		}
		
		if($type == 'uber') {
			$this->load->helper('checker');
			$type2 = $this->accountmodel->get_type($type);
			$meta = json_decode($account->meta);

			if(!checkUB($this, $meta)) {
				$this->accountmodel->delete($account->id);
				$this->template->set('error', "The uber account you tried to buy is dead and your funds have been refunded.");
				$this->forType($type);
				return;
			}

		}	

		if($type == 'amazon') {
			$this->load->helper('checker');
			$type2 = $this->accountmodel->get_type($type);
			$meta = json_decode($account->meta);

			if(!checkAM($this, $meta)) {
				$this->accountmodel->delete($account->id);
				$this->template->set('error', "The amazon account you tried to buy is dead and your funds have been refunded.");
				$this->forType($type);
				return;
			}

		}			
		
				if($type == 'ukfullz') {
			$this->load->helper('checker');
			$type2 = $this->accountmodel->get_type($type);
			$meta = json_decode($account->meta);

			if(!checkCC($this, $meta)) {
				$this->accountmodel->delete($account->id);
				$this->template->set('error', "The CC you had just tried to purchase has expired or is dead and your funds have been refunded.");
				$this->forType($type);
				return;
			}

		}

		$type2 = $this->accountmodel->get_type($type);
		$this->load->model('feedmodel');
		$this->feedmodel->insert(array(
				'color' => 'green',
				'icon' => 'money',
				'header' => 'Earning',
				'content' => 'Buyer '. $this->usermodel->get_name() .' bought a ' . $type2->name . ' ID: '.$account->meta.'. He paid '. number_format($account->price, 2) . '.',
				'content' => 'You earned ' . number_format($account->price, 2) . ' from a ' . $type2->name . ' purchase.'
			), $account->seller);
		$this->db->set('balance_due', 'balance_due+' . $account->price, FALSE);
		$this->usermodel->update(array('id' => $account->seller), array());

		$this->template->set('purchased', true);
		$this->accountmodel->update(array('id' => $account->id), array('bought_at' => time(), 'buyer' => $this->usermodel->get_id()));
		$this->db->set('balance', 'balance-' . $account->price, FALSE);
		$this->usermodel->update(array('id' => $this->usermodel->get_id()), array());
		$this->usermodel->refresh();
		$this->forType($type);
	}
}