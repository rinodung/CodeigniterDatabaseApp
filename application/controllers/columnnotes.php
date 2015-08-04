<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Columnnotes extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->model('columnnotemodel');
		$this->load->model('usermodel');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
				
	}
	
	
	/*
		ajax call
	
		returns all notes for a certain column
	*/

	public function getColumnNotes($db = '', $table = '', $field = '')
	{
		
		$field = urldecode($field);
	
		$return = array();//araay to send back to the browser
				
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $field == '' || $field == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_getcolumnnotes_error1_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_getcolumnnotes_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('select', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_getcolumnnotes_error2_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_getcolumnnotes_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		$return['response_code'] = 1;
	
		$notes = $this->columnnotemodel->getColumnNotes($db, $table, $field);
		
		$return['notes'] = $this->load->view("partials/columnnotes", array('notes'=>$notes), true);
		
		echo json_encode($return);
		
	}
	
	
	/*
		ajax call
		
		createa new column note
	*/
	
	public function newNote($db = '', $table = '', $field = '')
	{
	
		$field = urldecode($field);
	
		$return = array();//array to send back to the browser
	
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $field == '' || $field == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_newnote_error1_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_newnote_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('alter', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_newnote_error2_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_newnote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		$this->form_validation->set_rules('note', 'Column note', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_newnote_error3_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_newnote_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			$this->columnnotemodel->newColumnNote($db, $table, $field, $_POST['note']);
				
			//get all notes for this column and send back to the browser
				
			$return['response_code'] = 1;
				
			$notes = $this->columnnotemodel->getColumnNotes($db, $table, $field);
					
			$return['notes'] = $this->load->view("partials/columnnotes", array('notes'=>$notes), true);
				
				
			//display our success message as well
				
			$this->data['success_message_heading'] = $this->lang->line('columnnotes_newnote_success_heading');
			$this->data['success_message'] = $this->lang->line('columnnotes_newnote_success');
				
			$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
							
		
		}
		
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		deletes a column note
	*/
	
	public function deleteNote($db = '', $table = '', $field = '', $noteID = '')
	{
	
		$field = urldecode($field);
		$noteID = urldecode($noteID);
	
		$return = array();//array to send back to the browser
	
	
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $field == '' || $field == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_deletenote_error1_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_deletenote_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('alter', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_deletenote_error2_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_deletenote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//we'll need to check if the current user is the owner of the comment to edit
		
		if( !$this->columnnotemodel->isMine($noteID) ) {
		
			$return['response_code'] = 2;
			
			$return['error'] = $this->lang->line('columnnotes_deletenote_error3');
			
			die(json_encode($return));
		
		}
		
	
		//we need the note ID
		if($noteID != '') {
		
			$this->columnnotemodel->deleteColumnNote($noteID);
		
			$return['repsonse_code'] = 1;
			
			//success message
			
			$this->data['success_message_heading'] = $this->lang->line('columnnotes_deletenote_success_heading');
			$this->data['success_message'] = $this->lang->line('columnnotes_deletenote_success');
			
			$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
			
			
			//return updates notes as well
			
			$notes = $this->columnnotemodel->getColumnNotes($db, $table, $field);
				
			$return['notes'] = $this->load->view("partials/columnnotes", array('notes'=>$notes), true);
			
		
		} else {
		
			$return['response_code'] = 2;
			$return['error'] = $this->lang->line('columnnotes_deletenote_error4');
		
		}
		
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
	
		updates a column note
	*/
	
	public function updateNote($db = '', $table = '', $field = '', $noteID = '')
	{
	
		$field = urldecode($field);
		$noteID = urldecode($noteID);
	
		$return = array();//array to send back to the browser
		
	
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $field == '' || $field == 'undefined' || $noteID == '' || $noteID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_updatenote_error1_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_updatenote_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('alter', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_updatenote_error2_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_updatenote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//we'll need to check if the current user is the owner of the comment to edit
		
		if( !$this->columnnotemodel->isMine($noteID) ) {
		
			$return['response_code'] = 2;
			
			$return['error'] = $this->lang->line('columnnotes_updatenote_error3');
			
			die(json_encode($return));
		
		}
		
		
		$this->form_validation->set_rules('note', 'Column note', 'required|trim|xss_clean');
		
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('columnnotes_updatenote_error4_heading');
			$this->data['error_message'] = $this->lang->line('columnnotes_updatenote_error4').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
		
		} else {
		
			$return['response_code'] = 1;
				
			//update the note
			$this->columnnotemodel->updateNote($noteID, $_POST['note']);
			
			
			//return updates notes as well
				
			$notes = $this->columnnotemodel->getColumnNotes($db, $table, $field);
					
			$return['notes'] = $this->load->view("partials/columnnotes", array('notes'=>$notes), true);
				
				
			//success message
				
			$this->data['success_message_heading'] = $this->lang->line('columnnotes_updatenote_success_heading');
			$this->data['success_message'] = $this->lang->line('columnnotes_updatenote_success');
				
			$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
		
		}
		
		echo json_encode($return);
	
	}
	
}

/* End of file columnnotes.php */
/* Location: ./application/controllers/columnnotes.php */