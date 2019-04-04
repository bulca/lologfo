<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!$this->usermodel->logged_in()
				|| !$this->usermodel->has_any_perm_in ('seller')) {
			redirect('/login');
		}

		$this->template->set('useMenu', 'seller');
	}

	public function index($type = NULL)
	{
		$this->load->library('typography');
		$this->load->model('feedmodel');
		$this->template->set('feed', $this->feedmodel->gets(20, $this->usermodel->get_id()));
		$this->template->set('title', 'Seller Panel');
		$this->template->set('laf', array(
			'menu' => 'dashboard',
			'breadcrumbs' => array('seller_panel')
		));
		$this->template->render();
	}

	public function inventory($type = NULL)
	{
		$this->load->model('accountmodel');

		if($type == NULL || !$this->accountmodel->type_exists($type))
		{
			$type = $this->accountmodel->get_first_type();
		} else {
			$type = $this->accountmodel->get_type($type);
		}

		$this->template->set($this->accountmodel->gets($type->type, $this->input->get('page'), 15, array('seller' => $this->usermodel->get_id(), 'buyer' => 0)));
		$this->template->set('types', $this->accountmodel->get_types());
		$this->template->set('type', $type);
		$this->template->set('title', 'Seller Panel');
		$this->template->set('laf', array(
			'menu' => 'inventory',
			'breadcrumbs' => array('seller_panel', 'seller_inventory')
		));
		$this->template->render();
	}


	public function addAccounts($type = NULL)
	{
		set_time_limit(0);

		$this->load->model('accountmodel');

		if($type && $this->accountmodel->type_exists($type)) {
			$type = $this->accountmodel->get_type($type);

			if($type->type == 'cc') {
				unset($type->format->bank);
				unset($type->format->ctype);
			}
			
			$list = $this->input->post('list');
			$delim = $this->input->post('delim');
			$price = $this->input->post('price');

			if($list && strlen($list) < 10485760 && $delim && $price && is_numeric($price)) {
				$list = trim($list);

				$accs = explode("\n", $list);
				$batch = array();
				$binCatch = array();

				foreach($accs as $acc) {
					$acc = rtrim($acc);

					if(strlen($acc) == 0) continue;

					$parts = explode($delim, $acc);
					$insert = array(
						'seller' => $this->usermodel->get_id(),
						'price' => $price,
						'type' => $type->type,
						'updated_at' => time(),
						'meta' => array()
					);

					foreach($type->format as $key => $val) {
						$v = $this->input->post($key);

						// if(!$v) continue;

						if($v < count($parts)) {
							if($type->type == 'cc' && $key == 'card_number') {
								$bin = isset($binCatch[substr($parts[$v], 0, 6)]) ? $binCatch[substr($parts[$v], 0, 6)] : NULL;

								if($bin == NULL) {
									$binCatch[substr($parts[$v], 0, 6)] = json_decode(file_get_contents('http://www.binlist.net/json/' . substr($parts[$v], 0, 6)));
									$bin = $binCatch[substr($parts[$v], 0, 6)];
								}

								$insert['meta']['bank'] = $bin->bank;
								$insert['meta']['ctype'] = $bin->card_type;
							}

							$insert['meta'][$key] = $parts[$v];
						}
					}

					$insert['meta'] = json_encode($insert['meta']);
					array_push($batch, $insert);
				}

				$this->db->insert_batch('account', $batch);
				$this->load->model('feedmodel');
				$this->feedmodel->insert(array(
						'color' => 'red',
						'icon' => 'users',
						'header' => 'Inventory',
						'content' => 'You added ' . count($batch) . ' account' . (count($batch) == 1 ? '' : 's') . ' into ' . $type->name . '.'
					), $this->usermodel->get_id());
				redirect('/seller/shop/' . $type->type);
			}

			$this->template->set('type', $type);
			$this->template->set('Add to ' . $type->name);
			$this->template->set('laf', array(
				'menu' => 'add_accounts',
				'breadcrumbs' => array('seller_panel', 'seller_add_accounts')
			));
			$this->template->current_view = 'seller/addAccountsTo';
			$this->template->render();
			return;
		}

		$this->template->set('types', $this->accountmodel->get_types ());
		$this->template->set('title', 'Select Account Type');
		$this->template->set('laf', array(
			'menu' => 'add_accounts',
			'breadcrumbs' => array('seller_panel', 'seller_add_accounts')
		));
		$this->template->render();
	}

	public function delete()
	{
		if(!$this->input->is_ajax_request()) {
			exit;
		}

		$ids = $this->input->post('ids');

		if(!$ids || !is_array($ids)) {
			exit;
		}

		$this->db->where('seller', $this->usermodel->get_id());
		$this->db->where_in('id', $ids);
		$this->db->delete('account');
	}

	public function settings()
	{
		$password = $this->input->post('password');

		if($password ) {
			if(md5($password) == $this->session->userdata('password')) {
				$error = NULL;

				$btca = $this->input->post('btca');

				if($btca && strlen($btca) < 45) {
					$this->db->set('btc_address', $btca);
				}

				if($error == NULL) {
					$this->db->where('id', $this->usermodel->get_id());
					$this->db->update('user');
					$this->template->set('success', true);
				} else
					$this->template->set('error', $error);
			} else
				$this->template->set('error', 'You current password does not match the one given');
		}

		$this->template->set('title', 'Seller Settings Settings');
		$this->template->set('laf', array(
			'menu' => 'settings',
			'breadcrumbs' => array('seller_panel', 'seller_settings')
		));
		$this->template->render();
	}
}