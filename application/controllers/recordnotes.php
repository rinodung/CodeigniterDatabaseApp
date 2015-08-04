<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recordnotes extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->model("recordnotemodel");
		$this->load->model("usermodel");
		
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
	
	public function getRecordNotes($db = '', $table = '', $indexName = '', $recordID = '')
	{
		
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
		
		
		$return = array();//araay to send back to the browser
	
	
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_getrecordnotes_error1_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_getrecordnotes_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_getrecordnotes_error2_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_getrecordnotes_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
			
		
			
		$return['response_code'] = 1;
		
		$notes = $this->recordnotemodel->getRecordNotes($db, $table, $indexName, $recordID);
			
		$return['notes'] = $this->load->view("partials/recordnotes", array('notes'=>$notes), true);
			
		echo json_encode($return);
			
	}
	
	
	/*
		ajax call
		
		creates a new record note
	*/
	
	public function newNote($db = '', $table = '', $indexName = '', $recordID = '')
	{	
	
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
		
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_newnote_error1_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_newnote_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_newnote_error2_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_newnote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
	
		//form validation
		
		$this->form_validation->set_rules('note', 'Note', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_newnote_error3_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_newnote_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
			
		
		} else {
	
		
			//add the new note
			$this->recordnotemodel->newRecordNote($db, $table, $indexName, $recordID, $_POST['note']);
		
			$return['response_code'] = 1;
			
			
			//succcess message
			$this->data['success_message_heading'] = $this->lang->line('recordnotes_newnote_success_heading');
			$this->data['success_message'] = $this->lang->line('recordnotes_newnote_success');
			
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
		
			
			//return all record notes
			$notes = $this->recordnotemodel->getRecordNotes($db, $table, $indexName, $recordID);
			
			$return['notes'] = $this->load->view('partials/recordnotes', array('notes'=>$notes), true);
		
		}
		
		
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		updates a record note
	*/
	
	public function updateNote($db = '', $table = '', $indexName = '', $recordID = '', $noteID = '')
	{
		
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
		
		
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined' || $noteID == '' || $noteID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_updatenote_error1_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_updatenote_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = "Ouch!";
			$this->data['error_message'] = "You don't have permission to do this.";
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
			
			
		//we'll need to check if the current user is the owner of the comment to edit
			
		if( !$this->recordnotemodel->isMine($noteID) ) {
			
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_updatenote_error2_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_updatenote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
			
		}
		
		$this->form_validation->set_rules('note', 'Note', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_updatenote_error3_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_updatenote_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			//all good!
		
			$return['response_code'] = 1;
				
			//update the note
			$this->recordnotemodel->updateNote($noteID, $_POST['note']);
			
			
			//return updates notes as well
				
			$notes = $this->recordnotemodel->getRecordNotes($db, $table, $indexName, $recordID);
					
			$return['notes'] = $this->load->view("partials/recordnotes", array('notes'=>$notes), true);
				
				
			//success message
				
			$this->data['success_message_heading'] = $this->lang->line('recordnotes_updatenote_success_heading');
			$this->data['success_message'] = $this->lang->line('recordnotes_updatenote_success');
				
			$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
		
		}
		
			
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		deletes a record note
	*/
	
	public function deleteNote($db = '', $table = '', $indexName = '', $recordID = '', $noteID = '')
	{
	
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
		
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined' || $noteID == '' || $noteID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_deletenote_error1_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_deletenote_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
	
	
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_deletenote_error2_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_deletenote_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
	
			
			
		//we'll need to check if the current user is the owner of the comment to edit
			
		if( !$this->recordnotemodel->isMine($noteID) ) {
			
			$this->data['error_message_heading'] = $this->lang->line('recordnotes_deletenote_error3_heading');
			$this->data['error_message'] = $this->lang->line('recordnotes_deletenote_error3');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
			
		}
			
			
		$this->recordnotemodel->deleteRecordNote($noteID);
			
		$return['repsonse_code'] = 1;
				
		//success message
				
		$this->data['success_message_heading'] = $this->lang->line('recordnotes_deletenote_success_heading');
		$this->data['success_message'] = $this->lang->line('recordnotes_deletenote_success');
				
		$return['success_message'] = $this->load->view('partials/message_success', $this->data, true);
				
				
		//return updates notes as well
				
		$notes = $this->recordnotemodel->getRecordNotes($db, $table, $indexName, $recordID);
					
		$return['notes'] = $this->load->view("partials/recordnotes", array('notes'=>$notes), true);
				
			
		echo json_encode($return);
	
	}
	
}

/* End of file recordnotes.php */
/* Location: ./application/controllers/recordnotes.php */