<?php

class UserModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();

		if($this->logged_in())
		{
			$this->refresh();
		}
	}

	public function refresh()
	{
		$user = $this->get(array(
			'id' => $this->get_id()
		));

		if($user) {
			$this->session->set_userdata($user);
		}
	}

	public function get_id()
	{
		return $this->session->userdata('id');
	}

	public function get_name()
	{
		return $this->session->userdata('username');
	}

	public function logged_in ()
	{
		return $this->session->userdata('id') > 0;
	}

	public function count_col ($haystack, $needle)
	{
		return $this->db->where($haystack, $needle)
			-> count_all_results('user') > 0;
	}

	public function insert ($info)
	{
		$info['join_date'] = time();

		if(isset($info['password'])) {
			$info['password'] = md5($info['password']);
		}

		$this->db->insert('user', $info);
	}

	public function get ($info)
	{
		if(isset($info['password'])) {
			$info['password'] = md5($info['password']);
		}

		return $this->db->where($info)
			-> limit(1)
			-> get('user')
			-> row_array();
	}

	public function has_any_perm_in ($perm)
	{
		$permissions = json_decode($this->session->userdata('permissions'));

		foreach($permissions as $p) {
			if(substr($p, 0, strlen($perm)) == $perm)
				return true;
		}

		return false;
	}

	public function has_attr ($perm)
	{
		$attrs = json_decode($this->session->userdata('attr'), true);
		
		if(!is_array($attrs)) return false;
		
		return in_array($perm, $attrs);
	}

	public function add_attr($attr)
	{
		$attrs = json_decode($this->session->userdata('attr'), true);

		if(!in_array($attr, $attrs)) {
			array_push($attrs, $attr);
			$this->db->set('attr', json_encode($attrs));
			$this->db->where('id', $this->get_id());
			$this->db->update('user');
		}
	}

	public function get_title()
	{
		return $this->session->userdata('title');
	}

	public function get_bal()
	{
		return number_format($this->session->userdata('balance'), 2);
	}

	public function update($info, $newval)
	{
		$this->db->where($info)
			-> update('user', $newval);
	}

	public function get_unread_tickets()
	{
		return $this->db->where('unread', 1)
			-> where('user', $this->get_id())
			-> where('open', 1)
			-> count_all_results('user_ticket');
	}

	public function get_accounts_total()
	{
		return $this->db->where('buyer', $this->get_id())
			-> count_all_results('account');
	}

	public function get_new_today()
    {
        $this->db->where('join_date >=', strtotime("00:00:00"));
        return $this->db->count_all_results('user');
    }

    public function total()
    {
    	return $this->db->count_all('user');
    }

    public function get_sales_today()
    {
        $this->db->where('date >=', strtotime("00:00:00"));
        return $this->db->count_all_results('user_sale');
    }

    public function get_earned_today()
    {
    	return number_format($this->db->where('date >=', strtotime("00:00:00"))
    		-> select_sum('spent')
    		-> get('user_sale')
    		-> row()->spent, 2);
    }

    public function get_total_earned()
    {
    	return number_format($this->db->select_sum('spent')
    		-> get('user_sale')
    		-> row()->spent, 2);
    }


    //

    public function seller_total_accounts()
    {
    	return $this->db->where('seller', $this->get_id())
    		-> count_all_results('account');
    }

    public function seller_most_popular()
    {
    	$this->db->select('type, COUNT(type) AS count');
    	$this->db->group_by('type');
    	$this->db->order_by('count', 'DESC');
    	$this->db->where('seller', $this->get_id());
    	$this->db->where('buyer >', 0);
    	$this->db->limit(1);
    	$row = $this->db->get('account') -> row_array();

    	if($row) {
    		$this->load->model('accountmodel');
    		$type = $this->accountmodel->get_type($row['type']);
    		return $type->name;
    	}
    	return "-";
    }

    public function seller_total_sales()
    {
    	return $this->db->where('seller', $this->get_id())
    		-> where('buyer >', 0)
    		-> count_all_results('account');
    }

    public function seller_earned()
    {
    	return number_format($this->db->where('buyer >', 0)
    			-> where('seller', $this->get_id())
    			-> select_sum('price')
    			-> get('account')
    			-> row()->price, 2);
    }

    public function seller_earned_today()
    {
    	return number_format($this->db->where('bought_at >=', strtotime("00:00:00"))
    			-> where('buyer >', 0)
    			-> where('seller', $this->get_id())
    			-> select_sum('price')
    			-> get('account')
    			-> row()->price, 2);
    }

    public function seller_earned_month()
    {
    	return number_format($this->db->where('bought_at >=', strtotime(date('Y-m-01')))
    			-> where('bought_at <=', strtotime(date('Y-m-t')))
    			-> where('buyer >', 0)
    			-> where('seller', $this->get_id())
    			-> select_sum('price')
    			-> get('account')
    			-> row()->price, 2);
    }

    public function balance_due($user = null)
    {
        if($user != null) {
            $due = $this->db->where('id', $user)
                    -> select('balance_due')
                    -> get('user')
                    -> row()->balance_due;
        } else
            $due = $this->session->userdata('balance_due');

        if($due > 0) {
            $due = ($due * 70)/100;
        }

    	return number_format($due, 2);
    }

    public function admin_need_payout()
    {
    	return $this->db->where('balance_due >', 0)
    		-> count_all_results('user');
    }

    public function admin_get_need_payout()
    {
    	return $this->db->where('balance_due >', 0)
    		-> get('user')
    		-> result();
    }

    public function admin_total_due()
    {
        $due = $this->db->where('balance_due >', 0)
            -> select_sum('balance_due')
            -> get('user')
            -> row()->balance_due;

        if($due > 0) {
            $due = ($due * 80)/100;
        }

    	return number_format($due, 2);
    }

    public function btc_address()
    {
    	return $this->session->userdata('btc_address');
    }
}