<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guest extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if($this->usermodel->logged_in())
		{
			redirect('/home');
		}
	}

	public function login( )
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if($username && $password)
		{
			$error = NULL;
			$user = $this->usermodel->get(array(
				'username' => $username,
				'password' => $password
			));

			if(!$user) {
				$error = 'You have entered an invalid username or password.';
			}

			if($error == NULL) {
				unset($user['password']);
				$this->session->set_userdata($user);
				redirect('/home');
			} else
				$this->template->set('error', $error);
		}
		
		$this->template->set('title', 'Login');
		$this->template->render('blank');
	}

	public function register()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$confirm_password = $this->input->post('confirm_password');
		$email = $this->input->post('email');

		if($username && $password && $confirm_password && $email
			&& strlen($username) > 1 && strlen($username) <= 15 && preg_match('/^[a-zA-Z0-9 ]+$/', $username)
			&& strlen($password) >= 6 && strlen($password) <= 32
			&& filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$error = NULL;

			if($this->usermodel->count_col('username', $username)) {
				$error = 'That username has already been taken.';
			} elseif ($this->usermodel->count_col('email', $email)) {
				$error = 'That email address is currently in use.';
			}

			if($error == NULL) {
				$this->usermodel->insert(array(
					'username' => $username,
					'email' => $email,
					'password' => $password
				));
				$this->template->set('success', TRUE);
			} else {
				$this->template->set('error', $error);
			}
		}

		$this->template->set('title', 'Register');
		$this->template->render('blank');
	}

}