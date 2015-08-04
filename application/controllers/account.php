<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->model('tablenotemodel');
		$this->load->model('dbmodel');
		$this->load->model('usermodel');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
				
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
		
		$this->data['dbs'] = $this->dbmodel->listAll();
		
	}
	
	/*
		My Account page
	*/
	
	public function index()
	{
	
		$this->data['page'] = 'account';
		
		//get roles
		$this->data['roles'] = $this->rolemodel->getAll();
		
		//get the user
		$this->data['theUser'] = $this->usermodel->getUser( $this->ion_auth->user()->row()->id );
		
		$this->load->view("account", $this->data);
	
	}
	
	
	/*
		updates login details for this user
	*/
	
	public function updateLogin($userID)
	{
	
		//check if this is the correct user
		if( $userID != $this->ion_auth->user()->row()->id ) {
		
			die( $this->lang->line('account_update_login_no_permission') );
		
		}
	
		$this->data['page'] = "account";
			
		//get roles
		$this->data['roles'] = $this->rolemodel->getAll();
			
		$this->data['theUser'] = $this->usermodel->getUser( $this->ion_auth->user()->row()->id );
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			
		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('account', $this->data);
				
		} else {
			
			$data = array(
				'email' => $_POST['email'],
				'username' => $_POST['email'],
				'password' => $_POST['password']
			);
				
			$this->ion_auth->update($userID, $data);
			
			$this->session->set_flashdata('success_message', $this->lang->line('account_update_login_success_message'));
				
			redirect("/account/", "refresh");
				
		}
	
	}
	
	
	/*
		updates other account info
	*/
	
	public function update($userID)
	{
	
		//check if this is the correct user
		if( $userID != $this->ion_auth->user()->row()->id ) {
		
			die("<h1>You don't have permission to do this.</h1>");
		
		}
		
		$this->data['page'] = "account";
				
		//get roles
		$this->data['roles'] = $this->rolemodel->getAll();
		
		$this->data['theUser'] = $this->usermodel->getUser($userID);
		
		$this->form_validation->set_rules('firstname', $this->lang->line('myaccount_firstname'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('lastname', $this->lang->line('myaccount_lastname'), 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('account', $this->data);
			
		} else {
		
			$data = array(
				'first_name' => $_POST['firstname'],
				'last_name' => $_POST['lastname'],
				'company' => $_POST['company'],
				'phone' => $_POST['phone']
			);
			
			$this->ion_auth->update($userID, $data);
				
			$this->session->set_flashdata('success_message', $this->lang->line('account_update_success_message'));
			
			redirect("/account/", "refresh");
			
		}
	
	}
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */