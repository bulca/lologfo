<?php

class AccountModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function modify_account ($acc)
	{
		foreach($acc as $a) {
			$meta = json_decode($a->meta);
			$a->price = number_format($a->price, 2);
			$admin = false;

			if($a->buyer !== $this->usermodel->get_id() && $a->seller !== $this->usermodel->get_id()) {
				foreach($meta as $k => $v) {
					switch($k) {
						// if you wante to replace something like 'apple' with orange you would do
						// get it? Yeah :D   then when you are done you would push it to the website like this
						case 'apple':
							$meta->{$k} = 'orange';
							break;
						
						case 'ipaddress':
						case 'login':
							if(!$admin)
							$meta->{$k} = '*';
							break;
													case 'server':
													if(!$admin)
							$meta->{$k} = '*';
							break;
													case 'username':
													if(!$admin)
							$meta->{$k} = '*';
							break;
						case 'password':
							if(!$admin)
							$meta->{$k} = str_repeat('*', 7);
							break;
						case 'card_number':
							$repeat = strlen($meta->{$k}) - 6;
							if($repeat < 0) $repeat = 0;
							if(!$admin)
							$meta->{$k} = substr($meta->{$k}, 0, 6) . str_repeat('*', $repeat);
							break;
						case 'card_exp_month':
							if(strlen($meta->{$k}) == 4) {
								$meta->{$k} = substr($meta->{$k}, 0, 2);
							} elseif(strlen($meta->{$k}) == 1) {
								$meta->{$k} = '0' . $meta->{$k};
							}
							break;
						case 'card_exp_year':
							if(strlen($meta->{$k}) == 4) {
								if(substr($meta->{$k}, 0, 2) != '20') {
									$meta->{$k} = '20' . substr($meta->{$k}, 2, 4);
								}
							} else if(strlen($meta->{$k}) == 2) {
								$meta->{$k} = '20' . $meta->{$k};
							}
							break;
						case 'email':
							if(!$admin) {
								$pos = strpos($meta->{$k}, '@');
								$after = substr($meta->{$k}, $pos);
								$meta->{$k} = substr($meta->{$k}, 0, 2) . str_repeat('*', strlen($meta->{$k}) - 2 - strlen($after)) . '@' . str_repeat('*', strlen($after));
							}
							break;
						case 'address':
						case 'telephone':
						case 'blogin':
						case 'dllink':
						case 'loginlink':
						if(!$admin)
							$meta->{$k} = '*';
							break;
						case 'fname':
						if(!$admin)
							$meta->{$k} = substr($meta->{$k}, 0, 5). str_repeat('*', 5);
							break;
													case 'lname':
						if(!$admin)
							$meta->{$k} = substr($meta->{$k}, 0, 5). str_repeat('*', 5);
							break;
						case 'city':
						case 'state':
						case 'card_type':
						case 'country':
							$meta->{$k} = strtoupper($meta->{$k});
							break;
					}
				}

				$a->meta = json_encode($meta);
			}
		}

		return $acc;
	}

	public function get_types ($vendor = NULL)
	{
		if($vendor) {
			$types = array();

			$res = $this->db->distinct()
				-> select('type')
				-> where('seller', $vendor)
				-> where('buyer', 0)
				-> get('account')
				-> result();

			foreach($res as $val)
			{
				array_push($types, $this->db->where('type', $val->type)
						-> get('account_type')
						-> row());
			}

			return $types;
		}

		return $this->db->get('account_type')
			-> result();
	}

	public function get_type ($type, $flag = TRUE)
	{
		$type =  $this->db->where('type', $type)
			-> get('account_type')
			-> row();

		if($type) {
			$type->format = json_decode($type->format);

			if($flag && isset($type->format->search)) {
				$type->search = $type->format->search;
				unset($type->format->search);
			}

			if(isset($type->format->checker)) {
				$type->checker = $type->format->checker;
				unset($type->format->checker);
			}

		}

		return $type;
	}

	public function type_exists($type)
	{
		return $this->db->where('type', $type)
			-> count_all_results('account_type') > 0;
	}

	public function gets ($type, $page, $perPage = 15, $where = array(), $like = array())
	{
		if(!is_numeric($page) || $page <= 0) {
			$page = 1;
		}

		foreach($like as $l)
			$this->db->like($l[0], $l[1]);

		$where['type'] = $type;
		$where['display'] = 1;
		$total = $this->db->where($where)
			-> count_all_results('account');
		$totalPages = ceil($total / $perPage);

		if($page > $totalPages)
			$page = 1;

		$backPage = $page - 1;

		if($backPage <= 0) {
			$backPage = 1;
		}

		$nextPage = $page + 1;

		if($nextPage > $totalPages) {
			$nextPage = $page;
		}

		$startIndex = ($page - 1) * $perPage;

		if(!isset($where['buyer']))
			$where['buyer'] = 0;
		
		foreach($like as $l)
			$this->db->like($l[0], $l[1]);

		$data = $this->db-> where($where)
					-> get('account', $perPage, $startIndex)
					-> result();

		return array(
			'total' => $total,
			'data' => $this->modify_account($data),
			'page' => array(
				'show' => $perPage,
				'start' => $startIndex,
				'back' => $backPage,
				'next' => $nextPage,
				'current' => $page
			)
		);		
	}

	public function get($info, $modify = true)
	{
		$account = $this->db->limit(1)
			-> where($info)
			-> get('account')
			-> row();

		if($account) {
			if(!$modify) return $account;

			$account = $this->modify_account(array($account), false);
			return $account[0];
		}

		return $account;
	}

	public function update($info, $newval)
	{
		$this->db->where($info)
			-> update('account', $newval);
	}

	public function update_type($info, $newval)
	{
		$this->db->where($info)
			-> update('account_type', $newval);
	}

	public function get_first_type()
	{
		$type = $this->db->limit(1)
			-> get('account_type')
			-> row();

		if($type) {
			$type->format = json_decode($type->format);
		}

		return $type;
	}

	public function delete($id)
	{
		$this->db->delete('account', array('id' => $id)); 
	}
}