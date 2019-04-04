<?php

class TicketModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function insert($info)
	{
		$info['date'] = time();
		$info['updated_date'] = $info['date'];
		$info['user'] = $this->usermodel->get_id();
		$this->db->insert('user_ticket', $info);
	}

	public function gets ($user, $open, $page, $perPage = 15)
	{
		if(!is_numeric($page) || $page <= 0) {
			$page = 1;
		}

		if($user != -1)
			$this->db->where('user', $user);

		$total = $this->db->where('open', $open)
			-> count_all_results('user_ticket');
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

		if($user != -1)
			$this->db->where('user', $user);

		$data = $this->db->order_by('updated_date', 'DESC')
				-> where('open', $open)
				-> get('user_ticket', $perPage, $startIndex)
				-> result();

		foreach($data as $d) {
			$d->short_content = substr($d->content, 0, 50) . (strlen($d->content) > 50 ? '...' : '');
			$d->date_text = date('j M', $d->date) . ' | ' . date('H:i', $d->date);
			$d->ago = ago($d->updated_date);
			$d->link = site_url(($user == -1 ? 'ticket-manager' : 'support') . '/' . $d->id);
		}

		if($user != -1)
			$this->db->where('user', $user);
		$open = $this->db->where('open', 1)->count_all_results('user_ticket');

		if($user != -1)
			$this->db->where('user', $user);
		$closed = $this->db->where('open', 0)->count_all_results('user_ticket');

		return array(
			'total' => $total,
			'data' => $data,
			'open' => $open,
			'closed' => $closed,
			'page' => array(
				'show' => $perPage,
				'start' => $startIndex,
				'back' => $backPage,
				'next' => $nextPage,
				'current' => $page
			)
		);		
	}

	public function delete($user, $ticket)
	{
		if($user != -1)
			$this->db->where('user', $user);
		$this->db->delete('user_ticket', array('id' => $ticket));

		if($user != -1)
			$this->db->where('user', $user);
		$this->db->delete('user_ticket_message', array('ticket' => $id));
	}

	public function get($user, $ticket)
	{
		if($user != -1)
			$this->db->where('user', $user);
		$data = $this->db->where(array(
			'id' => $ticket
		)) -> get('user_ticket')
			-> row();
		return $data;
	}

	public function open($ticket, $open)
	{
		$this->db->where('id', $ticket)
			-> update('user_ticket', array(
				'open' => $open
			));
	}

	public function message($info)
	{
		$this->db->insert('user_ticket_message', $info);
	}

	public function get_messages($ticket)
	{
		return $this->db->where('ticket', $ticket)
			-> order_by('date', 'ASC')
			-> get('user_ticket_message')
			-> result();
	}

	public function update($ticket, $info)
	{
		$this->db->where('id', $ticket)
			-> update('user_ticket', $info);
	}
}