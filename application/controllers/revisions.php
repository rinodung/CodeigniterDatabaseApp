<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Revisions extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		//$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('revisionmodel');
		$this->load->model('dbmodel');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
				
	}
	
	
	/* 
		
		ajax call
		
		returns a selection of cell revisions
	
	*/

	public function index($db = '', $table = '', $field = '', $indexName = '', $indexValue = '')
	{
		
		$field = urldecode($field);
		$indexName = urldecode($indexName);
		$indexValue = urldecode($indexValue);
	
		
		$return = array();//array to return to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $field == '' || $field == 'undefined' || $indexName == '' || $indexName == 'undefined' || $indexValue == '' || $indexValue == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_index_error1_heading');
			$this->data['error_message'] = $this->lang->line('revisions_index_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
	
		
		//is this user allowed to update fields?
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_index_error2_heading');
			$this->data['error_message'] = $this->lang->line('revisions_index_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		$revisions = $this->revisionmodel->getRevisions($db, $table, $field, $indexName, $indexValue);
		
		$return['response_code'] = 1;
		
		$return['revisions'] = $this->load->view('partials/cellrevisions', array('revisions'=>$revisions), true);
		
		echo json_encode($return);
		
	}
	
	
	/*
		ajax call
		
		returns all relevant revisions for a single record
	*/
	
	public function loadRecordRevisions($db = '', $table = '', $indexName = '', $recordID = '')
	{
		
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
	
		
		$return = array();//array to send back the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$this->data['error_message_heading'] = "Ouch!";
			$this->data['error_message'] = "Some database connection details are missing. Please reload the page and try again.";
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to update fields?
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_loadrecordrevisions_error1_heading');
			$this->data['error_message'] = $this->lang->line('revisions_loadrecordrevisions_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		$return['response_code'] = 1;
		
		$revisionData = array();
	
		$revisionData['revisions'] = $this->revisionmodel->loadRecordRevisions($db, $table, $indexName, $recordID);
		$revisionData['db'] = $db;
		$revisionData['table'] = $table;
		$revisionData['indexName'] = $indexName;
		$revisionData['recordID'] = $recordID;
		
		$return['revisions'] = $this->load->view('partials/revisions', $revisionData, true);
		
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		deletes a single cell revision
	*/
	
	public function removeRevision($revisionID = '') 
	{
		
		$return = array();//array to return to the browser
		
		//make sure we've got all the required db details
		if($revisionID == '' || $revisionID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_removerevision_error1_heading');
			$this->data['error_message'] = $this->lang->line('revisions_removerevision_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//get some db details for the revisionID
		
		$recordData = $this->revisionmodel->getRecordFrom($revisionID);
		
		
		//is this user allowed to update fields?
		if( !$this->usermodel->hasTablePermission('update', $recordData['db'], $recordData['table']) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_removerevision_error2_heading');
			$this->data['error_message'] = $this->lang->line('revisions_removerevision_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
	
		
		$this->revisionmodel->removeRevision($revisionID);
			
			
		$return['response_code'] = 1;
			
		$this->data['success_message_heading'] = $this->lang->line('revisions_removerevision_success_heading');
		$this->data['success_message'] = $this->lang->line('revisions_removerevision_success');
		
		$return['success_message'] = $this->load->view("partials/message_success", $this->data, true);
			
			
		echo json_encode($return);
		
	
	}
	
	
	/*
		ajax call
		
		restores a single cell revision
	*/
	
	public function restoreRevision($db = '', $revisionID = '') 
	{
		
		$return = array();//array to return to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $revisionID == '' || $revisionID == 'undefined') {
		
			$this->data['error_message_heading'] = "Ouch!";
			$this->data['error_message'] = "Some database connection details are missing. Please reload the page and try again.";
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
	
		//get some db details for the revisionID
		
		$recordData = $this->revisionmodel->getRecordFrom($revisionID);
		
		
		//is this user allowed to update fields?
		if( !$this->usermodel->hasTablePermission('update', $recordData['db'], $recordData['table']) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_restorerevision_error1_heading');
			$this->data['error_message'] = $this->lang->line('revisions_restorerevision_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
	
		//set up DB connection
		$this->revisionmodel->initialize($db);
	
			
		$return['response_code'] = 1;
			
		$return['theValue'] = $this->revisionmodel->restoreRevision($db, $revisionID);
			
			
		//return the updates cell revisions as well
			
		$recordDetails = $this->revisionmodel->getRecordFrom($revisionID);
			
		$revisions = $this->revisionmodel->getRevisions($recordDetails['db'], $recordDetails['table'], $recordDetails['field'], $recordDetails['indexName'], $recordDetails['recordID']);
			
		$return['revisions'] = $this->load->view("partials/cellrevisions", array('revisions'=>$revisions), true);
			
		//success message
			
		$this->data['success_message_heading'] = $this->lang->line('revisions_restorerevision_success_heading');
		$this->data['success_message'] = $this->lang->line('revisions_restorerevision_success');
			
		$return['success_message'] = $this->load->view("partials/message_success", $this->data, true);
			
		echo json_encode($return);
			
	}
	
	
	/*
		displays a single cell revision
	*/
	
	public function viewCell($revisionID = '') 
	{
			
		if($revisionID != '') {
	
			$recordData = $this->revisionmodel->getRecordFrom($revisionID);
		
		
			//is this user allowed to update fields?
			if( !$this->usermodel->hasTablePermission('update', $recordData['db'], $recordData['table']) ) {
		
				$temp = array();
				$temp['error_message_heading'] = $this->lang->line('revisions_viewcell_error1_heading');
				$temp['error_message'] = $this->lang->line('revisions_viewcell_error1');
							
				die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
			}
		
		
			$this->data['revision'] = $this->revisionmodel->getRevision($revisionID);
		
			$this->load->view('revisions/cell', $this->data);
		
		} else {
		
			echo $this->lang->line('revisions_viewcell_error2');
		
		}
	
	}
	
	
	/*
		displays a selection of revisions for a record
	*/
	
	public function viewRecord($db = '', $table = '', $indexName = '', $recordID = '', $timestamp = '') 
	{
	
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined' || $timestamp == '' || $timestamp == 'undefined') {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('revisions_viewrecord_error1_heading');
			$temp['error_message'] = $this->lang->line('revisions_viewrecord_error1');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		
		//has this user permissions to view records in this table?
		//is this user allowed to update fields?
		if( !$this->usermodel->hasTablePermission('select', $db, $table) ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('revisions_viewrecord_error2_heading');
			$temp['error_message'] = $this->lang->line('revisions_viewrecord_error2');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
			
		$this->data['recordRevision'] = $this->revisionmodel->loadRecordRevision($db, $table, $indexName, $recordID, $timestamp);
		
		$this->load->view('revisions/record', $this->data);
	
	}
	
	
	/*
		ajax call
		
		retores a selection of revisions for a certain record
	*/
	
	public function restoreRecordRevision($db = '')
	{
	
		//return array
		$return = array();
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_restorerecordrevision_error1_heading');
			$this->data['error_message'] = $this->lang->line('revisions_restorerecordrevision_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
	
		if(isset($_POST['revisions']) && is_array($_POST['revisions'])) {
		
			//set up DB connection
			$this->revisionmodel->initialize($db);
		
			//each value in the $_POST['revions'] array holds an ID of a revision to restore
			foreach($_POST['revisions'] as $revisionID) {
			
				$this->revisionmodel->restoreRevision($db, $revisionID, time());
			
			}
			
			
			
			$this->data['success_message_heading'] = $this->lang->line('revisions_restorerecordrevision_success_heading');
			$this->data['success_message'] = $this->lang->line('revisions_restorerecordrevision_success');
			
			$return['response_code'] = 1;
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
			
			$recordDetails = $this->revisionmodel->getRecordFrom($_POST['revisions'][0]);
			
			//initialize database
			$this->dbmodel->initialize($db);
			
			$return['record'] = $this->dbmodel->getRecord($recordDetails['db'], $recordDetails['table'], $recordDetails['indexName'], $recordDetails['recordID']);
			
			
			//the updated record form
			$recordFormData = array();
			
			$recordFormData['recordData'] = $return['record'];
			$recordFormData['theDB'] = $recordDetails['db'];
			$recordFormData['theTable'] = $recordDetails['table'];
			$recordFormData['indexName'] = $recordDetails['indexName'];
			$recordFormData['recordID'] = $recordDetails['recordID'];
						
			$return['recordForm'] = $this->load->view('partials/record', $recordFormData, true);
			
			//the updates revisions
			
			$revisionsData = array();
			
			$revisionsData['db'] = $db;
			$revisionsData['recordID'] = $recordDetails['recordID'];
			$revisionsData['indexName'] = $recordDetails['indexName'];
			$revisionsData['table'] = $recordDetails['table'];
			$revisionsData['revisions'] = $this->revisionmodel->loadRecordRevisionsFromRevision($_POST['revisions'][0]);
			
			
			$return['revisions'] = $this->load->view('partials/revisions', $revisionsData, true);
						
		
		} else {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_restorerecordrevision_error2_heading');
			$this->data['error_message'] = $this->lang->line('revisions_restorerecordrevision_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		delete an selection of revisions for a certain record
	*/
	
	public function deleteRecordRevision($db = '', $table = '', $indexName = '', $recordID = '')
	{
		
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
	
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_deleterecordrevision_error1_heading');
			$this->data['error_message'] = $this->lang->line('revisions_deleterecordrevision_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to update fields?
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_deleterecordrevision_error2_heading');
			$this->data['error_message'] = $this->lang->line('revisions_deleterecordrevision_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
	
		if(isset($_POST['timestamp']) && $_POST['timestamp'] != '') {
		
			$numrows = $this->data['numrows'] = $this->revisionmodel->removeRecordRevisions($db, $table, $indexName, $recordID, $_POST['timestamp']);
						
			$return['response_code'] = 1;
			
			$successData = array();
			
			$successData['success_message_heading'] = $this->lang->line('revisions_deleterecordrevision_success_heading');
			$successData['success_message'] = sprintf( $this->lang->line('revisions_deleterecordrevision_success'), $numrows );
			
			$return['sucess_message'] = $this->load->view('partials/message_success', $successData, true);
			
		
		} else {
		
			$this->data['error_message_heading'] = $this->lang->line('revisions_deleterecordrevision_error3_heading');
			$this->data['error_message'] = $this->lang->line('revisions_deleterecordrevision_error3');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		}
		
		echo json_encode($return);
	
	}
	
}

/* End of file revisions.php */
/* Location: ./application/controllers/revisions.php */