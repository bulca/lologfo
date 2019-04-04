<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class User extends CI_Controller {



	public function __construct()

	{

		parent::__construct();



		if(!$this->usermodel->logged_in()) {

			redirect('/login');

		}

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

		$this->db->where('buyer', $this->usermodel->get_id());
		$this->db->where_in('id', $ids);
		$this->db->delete('account');
	}



	public function home( )

	{

		$this->load->library('typography');

		$this->load->model('feedmodel');

		$this->template->set('feed', $this->feedmodel->gets(10));



		$this->template->set('title', 'Home');

		$this->template->set('laf', array(

			'menu' => 'home',

			'breadcrumbs' => array()

		));

		$this->template->render();

	}



	public function addFunds()

	{

		$price = $this->input->post('price');



		if($price && is_numeric($price))  {

			$secret = $this->config->item('blockchain_secret');
			$my_address = '14wVbjLYuKYriMjFfAnMHx5DqhsG4hCaTe';
			$my_callback_url = site_url('/ipn/blockchain?secret=' . $secret . '&user=' . $this->usermodel->get_id());

			$root_url = 'https://litepay.ch/api/receive';
			$parameters = 'method=create&address=' . $my_address .'&callback='. urlencode($my_callback_url);
			$response = file_get_contents($root_url . '?' . $parameters);
			$object = json_decode($response);
			$this->template->set('send_to', $object->input_address);
			$this->template->set('price', $price);
			
			// $this->db->insert('invoice_payments', array(
			// 'id' => '',
			// 'sendto' => $object->input_address,
			// 'price' => $price,
			// 'user' => $this->usermodel->get_id(),
			// 'processedDate' => time()
		// ));
			
		}



		if($this->input->get('order')) {

			$price = $this->input->get('order')['button']['description'];

			$this->template->set('success', $price);

		}



		$this->template->set('title', 'Add Funds');

		$this->template->set('laf', array(

			'menu' => 'add_funds',

			'breadcrumbs' => array('add_funds')

		));

		$this->template->render();

	}



	public function logout()

	{

		$this->session->sess_destroy();

		redirect('/login');

	}



	public function myStuff($type = NULL)

	{

		$this->load->model('accountmodel');



		if($type == NULL || !$this->accountmodel->type_exists($type))

		{

			$type = $this->accountmodel->get_first_type();

		} else {

			$type = $this->accountmodel->get_type($type);

		}



		$this->template->set($this->accountmodel->gets($type->type, $this->input->get('page'), 15, array('buyer' => $this->usermodel->get_id())));

		$this->template->set('types', $this->accountmodel->get_types());

		$this->template->set('type', $type);

		$this->template->set('title', 'My Stuff');

		$this->template->set('laf', array(

			'menu' => 'my_stuff',

			'breadcrumbs' => array('my_stuff')

		));

		$this->template->render();

	}



	public function support()

	{

		$this->load->model('ticketmodel');

		$this->template->set($this->ticketmodel->gets($this->usermodel->get_id(), 1, 1));

		$this->template->set('title', 'Customer Support');

		$this->template->set('laf', array(

			'menu' => 'customer_support',

			'breadcrumbs' => array('customer_support')

		));

		$this->template->render();

	}



	public function manageTicket($id = NULL)

	{

		$this->viewTicket($id, TRUE);

	}



	public function viewTicket($id = NULL, $tm = FALSE)

	{

		if(!is_numeric($id) || ($tm && !$this->usermodel->has_any_perm_in('ticketm'))) {

			redirect('/support');

		}



		$this->load->library('typography');

		$this->load->model('ticketmodel');

		$ticket = $this->ticketmodel->get($tm ? -1 : $this->usermodel->get_id(), $id);



		if($ticket == NULL) {

			redirect('/support');

		}



		$toggle = $this->input->get('toggle');



		if($toggle) {

			$this->ticketmodel->open($ticket->id, $ticket->open == 1 ? 0 : 1);

			redirect(($tm ? '/ticket-manager/' : '/support/') . $ticket->id);

		}



		$message = $this->input->post('message');



		if($message && strlen($message) < 512) {

			$this->ticketmodel->message(array(

				'date' => time(),

				'ticket' => $ticket->id,

				'user' => $this->usermodel->get_id(),

				'username' => $this->usermodel->get_name(),

				'message' => htmlspecialchars($message)

			));

			$this->ticketmodel->update($ticket->id, array(

				'unread' => $tm ? 1 : 0,

				'unread2' => $tm ? 0 : 1,

				'open' => 1,

				'updated_date' => time()

			));

			redirect(($tm ? '/ticket-manager/' : '/support/') . $ticket->id);

		}



		$this->template->set('tm', $tm);

		$this->template->set('messages', $this->ticketmodel->get_messages($ticket->id));

		$this->template->set('ticket', $ticket);

		$this->template->set('title', $tm ? 'Ticket Manager' : 'Customer Support');

		$this->template->set('laf', array(

			'menu' => $tm ? '' : 'customer_support',

			'breadcrumbs' => $tm ? array('ticket_manager', 'ticket_manager_read') : array('customer_support', 'customer_support_read')

		));

		$this->template->current_view = 'user/viewTicket';

		$this->template->render();

	}



	public function openTicket()

	{

		if(!$this->input->is_ajax_request()) {

			exit;

		}



		$topic = $this->input->post('topic');
		$order = $this->input->post('order');

		$content = $this->input->post('content');



		if(!$topic || strlen($topic) < 3 || strlen($topic) > 30 ||

				!$content || strlen($content) < 40 || strlen($content) > 512) {

			echo strlen($topic);

			exit;

		}


		$this->load->model('ticketmodel');

		$this->ticketmodel->insert(array(

			'topic' => htmlspecialchars($topic),

			'order' => htmlspecialchars($order),

			'content' => htmlspecialchars($content),

			'username' => $this->usermodel->get_name()

		));



		$response = array();

		$response['success'] = true;

		die(json_encode($response));

	}



	public function getTickets()

	{

		if(!$this->input->is_ajax_request()) {

			exit;

		}



		$page = $this->input->get('page');



		if(!is_numeric($page))

			$page = 1;



		$open = $this->input->get('open');



		if($open != 1 && $open != 0)

			$open = 1;



		$this->load->model('ticketmodel');

		die(json_encode($this->ticketmodel->gets(($this->usermodel->has_any_perm_in('ticketm') && $this->input->get('tm') == 'true') ? -1 : $this->usermodel->get_id(), $open, $page)));

	}



	public function deleteTickets()

	{

		if(!$this->input->is_ajax_request()) {

			exit;

		}



		$tickets = $this->input->post('tickets');



		if(!$tickets || !is_array($tickets)) {

			return;

		}



		$this->load->model('ticketmodel');

		$user = ($this->usermodel->has_any_perm_in('ticketm') && $this->input->post('tm') == 'true') ? -1 : $this->usermodel->get_id();



		foreach($tickets as $id) {

			if(!is_numeric($id))

				continue;

			$this->ticketmodel->delete($user, $id);

		}

	}



	public function ticketManager()

	{

		if(!$this->usermodel->has_any_perm_in('ticketm')) {

			redirect('/');

		}



		$this->load->model('ticketmodel');

		$this->template->set($this->ticketmodel->gets(-1, 1, 1));

		$this->template->set('title', 'Ticket Manager');

		$this->template->set('laf', array(

			'breadcrumbs' => array('ticket_manager')

		));

		$this->template->render();

	}



	public function settings()

	{

		$password = $this->input->post('password');



		if($password ) {

			if(md5($password) == $this->session->userdata('password')) {

				$error = NULL;



				$newpassword = $this->input->post('newpassword');

				$newpassword2 = $this->input->post('newpassword2');



				if($newpassword2 && $newpassword2) {

					if($newpassword2 == $newpassword) {

						$this->db->set('password', md5($newpassword));

					} else

						$error = 'New passwords do not match';

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



		$this->template->set('title', 'Account Settings');

		$this->template->set('laf', array(

			'breadcrumbs' => array('user_settings')

		));

		$this->template->render();

	}

}
