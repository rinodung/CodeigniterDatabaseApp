<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tablenotes extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->model('tablenotemodel');
		$this->load->model('usermodel');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
				
	}
	
	
	/*
		creates a new table note
	*/
	
	public function newNote($db = '', $table = '')
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_newnote_error1_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_newnote_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('select', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_newnote_error2_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_newnote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		$this->form_validation->set_rules('note', 'Table note', 'required|trim|xss_clean');
		
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_newnote_error3_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_newnote_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			//all good
			
			$this->tablenotemodel->newTableNote($db, $table, $_POST['note']);
			
			$return['response_code'] = 1;
			
			//success message
			
			//display our success message as well
				
			$this->data['success_message_heading'] = $this->lang->line('tablenotes_newnote_success_heading');
			$this->data['success_message'] = $this->lang->line('tablenotes_newnote_success');
				
			$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
			
			
			//also, we'll return all the notes for this table
			$tableNotes = $this->tablenotemodel->getTableNotes($db, $table);
			
			$return['notes'] = $this->load->view("partials/tablenotes", array('tableNotes'=>$tableNotes), true);
			
		}
	
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		deletes a note for a given db+table
	*/
	
	public function deleteNote($db = '', $table = '', $noteID = '')
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $noteID == '' || $noteID == 'undefined') {
			
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_deletenote_error1_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_deletenote_error1');
				
			$return['response_code'] = 2;
				
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
			die(json_encode($return));
			
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('select', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_deletenote_error2_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_deletenote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//we'll need to check if the current user is the owner of the comment to edit
		
		if( !$this->tablenotemodel->isMine($noteID) ) {
		
			$return['response_code'] = 2;
			
			$return['error'] = $this->lang->line('tablenotes_deletenote_error3');
			
			die(json_encode($return));
		
		}
		
		
		//all set, delete the note
		
		$this->tablenotemodel->deleteTableNote($noteID);
		
		$return['repsonse_code'] = 1;
			
		//success message
			
		$this->data['success_message_heading'] = $this->lang->line('tablenotes_deletenote_success_heading');
		$this->data['success_message'] = $this->lang->line('tablenotes_deletenote_success');
			
		$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
			
			
		//return updated notes as well
			
		$tableNotes = $this->tablenotemodel->getTableNotes($db, $table);
		
		$return['notes'] = $this->load->view("partials/tablenotes", array('tableNotes'=>$tableNotes), true);
		
		
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		updates a table note
	*/
	
	public function updateNote($db, $table, $noteID)
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $noteID == '' || $noteID == 'undefined') {
			
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_updatenote_error1_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_updatenote_error1');
				
			$return['response_code'] = 2;
				
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
			die(json_encode($return));
			
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('select', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_updatenote_error2_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_updatenote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//we'll need to check if the current user is the owner of the comment to edit
		
		if( !$this->tablenotemodel->isMine($noteID) ) {
		
			$return['response_code'] = 2;
			
			$return['error'] = $this->lang->line('tablenotes_updatenote_error3');
			
			die(json_encode($return));
		
		}
		
		
		$this->form_validation->set_rules('note', 'Table note', 'required|trim|xss_clean');
		
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('tablenotes_updatenote_error4_heading');
			$this->data['error_message'] = $this->lang->line('tablenotes_updatenote_error4').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			$return['response_code'] = 1;
				
			//update the note
			$this->tablenotemodel->updateNote($noteID, $_POST['note']);
			
			//success message
				
			$this->data['success_message_heading'] = $this->lang->line('tablenotes_updatenote_success_heading');
			$this->data['success_message'] = $this->lang->line('tablenotes_updatenote_success');
				
			$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
				
				
			//return updated notes as well
				
			$tableNotes = $this->tablenotemodel->getTableNotes($db, $table);
			
			$return['notes'] = $this->load->view("partials/tablenotes", array('tableNotes'=>$tableNotes), true);
		
		}
		
	
		echo json_encode($return);
	
	}
	
}

/* End of file tablenotes.php */
/* Location: ./application/controllers/tablenotes.php */