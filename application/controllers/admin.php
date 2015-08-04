<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
				
		$this->load->library('ion_auth');
		$this->load->model("dbmodel");
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->load->helper('file');
				
		if(!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			
			redirect('/login');
		
		}
		
		$this->data['dbs'] = $this->dbmodel->listAll();
				
		if( $this->dbmodel->listAllMySQL() ) {
		
			$this->data['dbs_server'] = $this->dbmodel->listAllMySQL();
								
		}
				
	}
	
	/*
		administrate databases
	*/
	
	public function db()
	{
	
		$this->data['page'] = 'admin';
		
		$this->load->view("admin/db", $this->data);
	
	}
	
	
	/*
		adds an existing db to DBAPP
	*/
	
	public function enableDB($db = '')
	{
		
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('admin_enabledb_error1_heading');
			$this->data['error_message'] = $this->lang->line('admin_enabledb_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//user needs to be admin to do this
		if( !$this->ion_auth->is_admin() ) {
		
			$this->data['error_message_heading'] = $this->lang->line('admin_enabledb_error2_heading');
			$this->data['error_message'] = $this->lang->line('admin_enabledb_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
				
		
		if( !$this->dbmodel->checkDB($db) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('admin_enabledb_error3_heading');
			$this->data['error_message'] = $this->lang->line('admin_enabledb_error3');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		//all good, enable the db
		
		$dbID = $this->dbmodel->addToDBAPP($db);
		
		//success message
		$this->data['success_message_heading'] = $this->lang->line('admin_enabledb_success_heading');
		$this->data['success_message'] = $this->lang->line('admin_enabledb_success');
		
		$return['message'] = $this->load->view('partials/message_success', $this->data, true);
		
		$return['response_code'] = 1;
		$return['database_id'] = $dbID;
		
		
		echo json_encode($return);
	
	}
	
	
	/*
		removes a database from DBAPP, does NOT delete the actual database though
	*/
	
	public function disableDB($db = '')
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('admin_disabledb_error1_heading');
			$this->data['error_message'] = $this->lang->line('admin_disabledb_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//user needs to be admin to do this
		if( !$this->ion_auth->is_admin() ) {
		
			$this->data['error_message_heading'] = $this->lang->line('admin_disabledb_error2_heading');
			$this->data['error_message'] = $this->lang->line('admin_disabledb_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//all good, disable the db
		
		$this->dbmodel->removeFromDBAPP($db);
		
		//success message
		$this->data['success_message_heading'] = $this->lang->line('admin_disabledb_success_heading');
		$this->data['success_message'] = $this->lang->line('admin_disabledb_success');
		
		$return['message'] = $this->load->view('partials/message_success', $this->data, true);
		
		$return['response_code'] = 1;
		
		
		echo json_encode($return);
	
	}
	
	
	/*
		creates a new database
	*/
	
	public function newDB()
	{
	
		//is this user admin?
		if( !$this->ion_auth->is_admin() ) {
		
			die( $this->lang->line('admin_newdb_error1') );
		
		}
		
		$this->data['page'] = 'admin';
		
		
		$this->form_validation->set_rules('dbname', $this->lang->line('admindb_newdb_database_name'), 'trim|required|xss_clean|alpha_dash');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('admin/db', $this->data);
			
		} else {
		
			//make sure this database does not exist yet
			
			if( !$this->dbmodel->isUnique($_POST['dbname']) ) {
				
				$temp = array();
				$temp['error_message_heading'] = $this->lang->line('admin_newdb_error2_heading');
				$temp['error_message'] = $this->lang->line('admin_newdb_error2');
							
				die( $this->load->view('shared/alert', array('data'=>$temp), true) );
			
			}
		
			//create database
			
			$this->dbmodel->createDB($_POST['dbname']);
			
			if( isset($_POST['enable']) && $_POST['enable'] == 'yes' ) {//enable in dbapp
				
				$this->dbmodel->addToDBAPP($_POST['dbname']);
			
			}
		
			$this->session->set_flashdata('success_message', $this->lang->line('admin_newdb_success'));
			
			redirect("/admin/db/", "refresh");
			
		}
			
	}
	
	
	/*
		deletes a database from the server
	*/
	
	public function deleteDB($db = '')
	{
	
		//is this user admin?
		if( !$this->ion_auth->is_admin() ) {
		
			die( $this->lang->line('admin_deletedb_error1') );
		
		}
		
		
		if( $db == '' || $db == 'undefined' ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('admin_deletedb_error2_heading');
			$temp['error_message'] = $this->lang->line('admin_deletedb_error2');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		$this->dbmodel->deleteDB($db);
		
		//all done
		
		$this->session->set_flashdata('success_message', $this->lang->line('admin_deletedb_success'));
		
		redirect("/admin/db/", "refresh");
	
	}
	
	
	/*
		lists a control panel to manage the files
	*/
	
	public function files()
	{
	
		$this->data['page'] = 'files';
	
	
		$subfolder = parse_url(base_url(), PHP_URL_PATH);	
		$subfolder = rtrim($subfolder, "/");
		
		//get all files
		$this->data['files'] = get_dir_file_info( $_SERVER['DOCUMENT_ROOT'].$subfolder.'/uploads/' );
				
		$this->load->view("admin/files", $this->data);
	
	}
	
	
	/*
		deletes a file
	*/
	
	public function deleteFile($file = '')
	{
	
		if( $file == '' ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('admin_delete_file_error1_heading');
			$temp['error_message'] = $this->lang->line('admin_delete_file_error1');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		if( strpos($file, 'customerFile_') !== false ) {
		
			$temp = array();
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "This file is part of the online demo and can not be deleted";
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		$subfolder = parse_url(base_url(), PHP_URL_PATH);	
		$subfolder = rtrim($subfolder, "/");
	
		if( unlink( $_SERVER['DOCUMENT_ROOT'].$subfolder."/uploads/".$file ) ) {
		
			$this->session->set_flashdata('success_message', $this->lang->line('admin_delete_file_success'));
		
		} else {
		
			$this->session->set_flashdata('error_message', $this->lang->line('admin_delete_file_error2'));
		
		}
		
		redirect("/admin/files/", "refresh");
	
	}
	
	
	/*
		deletes multiple files
	*/
	
	public function deleteFiles()
	{
		
		if( isset($_POST['ids']) && count($_POST['ids']) ) {
		
			foreach( $_POST['ids'] as $file ) {
				
				if( strpos($file, 'customerFile_') !== false ) {
				
					$temp = array();
					$temp['error_message_heading'] = "Ouch!";
					$temp['error_message'] = "This file is part of the online demo and can not be deleted";
								
					die( $this->load->view('shared/alert', array('data'=>$temp), true) );
				
				}
			
				$subfolder = parse_url(base_url(), PHP_URL_PATH);	
				$subfolder = rtrim($subfolder, "/");
			
				if( !unlink( $_SERVER['DOCUMENT_ROOT'].$subfolder."/uploads/".$file ) ) {
				
					$this->session->set_flashdata('error_message', $this->lang->line('admin_delete_files_error1'));
				
				}
			
			}
			
			$this->session->set_flashdata('success_message', $this->lang->line('admin_delete_files_success'));
		
		
		} else {
		
			$this->session->set_flashdata('error_message', $this->lang->line('admin_delete_files_error1'));
		
		}
		
		redirect("/admin/files/", "refresh");
	
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */