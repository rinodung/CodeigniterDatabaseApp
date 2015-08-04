<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->model('tablemodel');
		$this->load->model('dbmodel');
		$this->load->model('usermodel');
		$this->load->model('rolemodel');
		$this->load->model('issuemodel');
		
		$this->lang->load('auth');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
				
	}

	public function index()
	{
			
		//system check
		
		$this->issuemodel->systemCheck();
		
			
		$this->data['page'] = "dashboard";
		
		$this->data['dbs'] = $this->dbmodel->listAll(true);
				
		//if this user has access to only one database, we'll send him/her straigh to that database
		if( count( $this->data['dbs'] ) == 1 ) {
		
			redirect("/db/".$this->data['dbs'][0]['db'], 'location');
		
		}
		
		$this->load->view('dashboard', $this->data);
	
	}
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */