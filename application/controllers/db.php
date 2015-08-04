<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->model('tablemodel');
		$this->load->model('dbmodel');
		$this->load->model('revisionmodel');
		$this->load->model('usermodel');
		$this->load->model('tablenotemodel');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
				
	}
	
	
	/*
		main function for the table page, displays the first table in a database if none is provided
	*/
	
	public function index($db, $table = '', $clearSearch = false) 
	{
		
		//search reset?
		
		if( $clearSearch == true ) {
		
			$this->session->unset_userdata('searchItems');
			
			redirect(site_url("db/".$db."/".$table), 'location');
		
		} 
		
		//do we have any search parameters?
		
		if( isset( $_POST['columns'] ) && $_POST['db'] == $db && $_POST['table'] == $table ) {
		
			unset($_POST['columns'][0]);
			unset($_POST['selectors'][0]);
			unset($_POST['values'][0]);
			
			//unset old items
			$this->session->unset_userdata('searchItems');
			
			//phpinfo();
				
			$counter = 1;
			
			$searchItems = array();
				
			foreach( $_POST['columns'] as $col ) {
			
				if( $col != '' && isset( $_POST['operators'][$counter] ) && $_POST['operators'][$counter] != '' && isset( $_POST['values'][$counter] ) && $_POST['values'][$counter] != '' ) {
									
					$temp = array();
					$temp['column'] = $col;
					$temp['operator'] = $_POST['operators'][$counter];
					$temp['value'] = $_POST['values'][$counter];
				
					$searchItems[] = $temp;
					
				}
				
				$counter++;
			
			}
			
			if( count($searchItems) > 0 ) {
		
				$this->session->set_userdata('searchItems', $searchItems);
			
				$this->session->set_userdata('searchItems_db', $_POST['db']);
			
				$this->session->set_userdata('searchItems_table', $_POST['table']);
			
			}
			
			redirect(site_url("db/".$db."/".$table), 'location');
		}
		
		
		//check if the db exists
		
		if( !$this->dbmodel->exists($db) ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_index_error1_heading');
			$temp['error_message'] = sprintf( $this->lang->line('db_index_error1'), $this->config->item('support_email'), $this->config->item('support_email') );
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		//connect model with DB
		$this->tablemodel->initialize($db);
				
		//check if the table exists
		
		if( $table != '' && !$this->tablemodel->exists($table) ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_index_error2_heading');
			$temp['error_message'] = sprintf( $this->lang->line('db_index_error2'), $this->config->item('support_email'), $this->config->item('support_email') );
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}	
		
		$this->data['theDB'] = $db;
	
		$this->data['tables'] = $this->tablemodel->listAll(false);
				
		$this->data['tabless'] = $this->tablemodel->tablesPlusColumns($db);
								
		$this->data['dbs'] = $this->dbmodel->listAll();		
								
		if($table == "" && count($this->data['tables']) > 0) {
		
			$this->data['theTable'] = $this->data['tables'][0]['table'];
							
			$this->data['tableFields'] = $this->tablemodel->getFieldsFor($this->data['tables'][0]['table']);
						
			//fields incl FK data
			$this->data['tableFields_'] = $this->tablemodel->getFieldsFK($db, $this->data['tables'][0]['table']);			
			
		} else {
		
			$this->data['theTable'] = $table;
			
			if( count($this->data['tables']) > 0 ) {//only if our db has tables
			
				$this->data['tableFields'] = $this->tablemodel->getFieldsFor($table);
				
				//fields incl FK data
				$this->data['tableFields_'] = $this->tablemodel->getFieldsFK($db, $table);
				
			}
		
		}
		
		if( count($this->data['tables']) > 0 ) {
		
			$this->data['table_engine'] = $this->tablemodel->getEngine($this->data['theTable']);
		
		}
		
		//any fields registered with the session?
		if(!$this->session->userdata($db.".".$this->data['theTable'])) {
		
			$sessionFields = array();
		
			if( count($this->data['tables']) > 0 ) {//only if our db has tables
		
				foreach($this->data['tableFields'] as $field) {
			
					array_push($sessionFields, $field['field']);
			
				}
			
			}
			
			//delete old session data
			$this->session->unset_userdata($this->data['theTable']);
			
			$this->session->set_userdata($db.".".$this->data['theTable'], $sessionFields);
		
		}
		
		//$this->session->sess_destroy();
		
		//print_r($this->session->userdata($this->data['theTable']));
		
		//die("<br><br>".$this->data['theTable']);
		
		$this->data['page'] = "data";
		
		
		//does the user have update rights?
		if( $this->usermodel->hasTablePermission("update", $db, $this->data['theTable']) ) {
		
			$this->data['tableUpdateAllowed'] = 'yes';
		
		} else {
		
			$this->data['tableUpdateAllowed'] = 'no';
		
		}
		
		
		//does the user have insert rights?
		if( $this->usermodel->hasTablePermission("insert", $db, $this->data['theTable']) ) {
		
			$this->data['tableInsertAllowed'] = 'yes';
		
		} else {
		
			$this->data['tableInsertAllowed'] = 'no';
		
		}
			
				
		//does the user have delete table rights?
		if( $this->usermodel->hasDBPermission("drop", $db) || $this->usermodel->ownsTable($db, $this->data['theTable']) ) {
		
			$this->data['tableDropAllowed'] = 'yes';
		
		} else {
		
			$this->data['tableDropAllowed'] = 'no';
		
		}
				
		
		//does this table have a primary key set?
		
		if( count($this->data['tables']) > 0 ) {//only if our db has tables
		
			if( $this->tablemodel->getPrimaryKey($this->data['theTable']) ) {
			
				$this->data['hasPrimary'] = true;
				
				$temp = $this->tablemodel->getPrimaryKey($this->data['theTable']);
				
				$this->data['primaryKey'] = $temp->name;
								
			} else {
			
				$this->data['hasPrimary'] = false;
			
			}
			
			//the number of records in the table
			
			$this->data['nrOfFields'] = $this->tablemodel->nrOfFields($this->data['theTable']);
			
			//also, we'll return all the notes for this table
			$this->data['tableNotes'] = $this->tablenotemodel->getTableNotes($this->data['theDB'], $this->data['theTable']);
		
		}
		
		$this->load->view('table/table', $this->data);
	
	}
	
	
	/*
		ajax call
		adds column to the data view
	*/
	
	public function addField($db) 
	{//add field to data view
		
		//setup DB connection
		$this->tablemodel->initialize($db);
	
		$temp = explode(".", $_GET['field']);
		
		$table = $temp[0];
		$fieldToAdd = $temp[1];
		
		if($fieldToAdd == 'all') {
		
			//delete old session data
			$this->session->unset_userdata($table);
			
			$fields = $this->tablemodel->getFieldsFor($table);
			
			$sessionFields = array();
			
			foreach($fields as $field) {
			
				array_push($sessionFields, $field['field']);
			
			}
			
			$this->session->set_userdata($db.".".$table, $sessionFields);
		
		} else {
		
			if($this->session->userdata($db.".".$table)) {
		
				//sessionFields already exists
		
				if(!in_array($fieldToAdd, $this->session->userdata($db.".".$table))) {
		
					$sessionFields = $this->session->userdata($db.".".$table);
			
					array_push($sessionFields, $fieldToAdd);
			
					$this->session->set_userdata($db.".".$table, $sessionFields);
		
				}
		
			} else {
		
				//no fields registered with the session yet
				$sessionFields = array();
				$sessionFields[0] = $fieldToAdd;
			
				$this->session->set_userdata($db.".".$table, $sessionFields);
		
			}
		
		}
			
	}
	
	
	/*
	
		ajax call
		removes columns from the data view
	
	*/
	
	public function removeField($db) 
	{
	
		//setup DB connection
		$this->tablemodel->initialize($db);
			
		$temp = explode(".", $_GET['field']);
		
		$table = $temp[0];
		$fieldToRemove = $temp[1];
		
		if($fieldToRemove == 'all') {//remove all fields
		
			//delete old session data
			$this->session->unset_userdata($db.".".$table);
			
			$newSessionFields = array();
			
			$fields = $this->tablemodel->getFieldsFor($db.".".$table);
			
			array_push($newSessionFields, $fields[0]['field']);
			
			$this->session->set_userdata($db.".".$table, $newSessionFields);
					
		
		} else {//remove only single field
								
			if($this->session->userdata($db.".".$table)) {
						
				//sessionFields already exists
		
				if(in_array($fieldToRemove, $this->session->userdata($db.".".$table))) {
					
					$sessionFields = $this->session->userdata($db.".".$table);
				
					//delete old session data
					$this->session->unset_userdata($db.".".$table);
				
					$newSessionFields = array();
				
					foreach($sessionFields as $field) {
				
						if($field != $fieldToRemove) {
					
							array_push($newSessionFields, $field);
					
						}
				
					}
				
					$this->session->set_userdata($db.".".$table, $newSessionFields);
				
				}
						
			}
		
		}
						
	}
	
	
	/*
		ajax call
		
		updates a single cell
	*/
	
	public function saveField($db = '', $table = '', $column = '') 
	{
	
		$column = urldecode($column);
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $column == '' || $column == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('db_savefield_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_savefield_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		//make sure this user is allowed to edit fields
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('db_savefield_error2_heading');
			$this->data['error_message'] = $this->lang->line('db_savefield_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
	
		//setup DB connection
		$this->tablemodel->initialize($db);
		
		
		//setup DB connection
		$this->revisionmodel->initialize($db);
			
		$this->form_validation->set_rules('indexName', 'indexName', 'trim|required|xss_clean');
		
		//does this column have any custom restrictions?
		
		$columnRestrictions = $this->tablemodel->getColumnRestrictions($db, $table, $column, 'string');
		
		$columnDetails = $this->tablemodel->getColumnDetails($db, $table, $column);
		
		if( $columnRestrictions !=  false ) {
				
			$this->form_validation->set_rules('val', 'Value', "trim|required|xss_clean|".$columnRestrictions);
		
		} else {
				
			$this->form_validation->set_rules('val', 'Value', 'trim|required|xss_clean');
		
		}
		
		
		//max length forced by column specs
		if( $columnDetails['type'] == 'int' ) {
		
			$this->form_validation->set_rules('val', $column, 'trim|xss_clean|numeric|max_length['.$columnDetails['max_length'].']');
		
		} elseif( $columnDetails['type'] == 'varchar' ) {
		
			//die($columnDetails['max_length']);
		
			$this->form_validation->set_rules('val', $column, 'trim|xss_clean|max_length['.$columnDetails['max_length'].']');
		
		}
		
				
		$this->form_validation->set_rules('index', 'Index', 'trim|required|xss_clean');		
		
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('db_savefield_error3_heading');
			$this->data['error_message'] = $this->lang->line('db_savefield_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			//are we dealing with a primary key?
			
			$key = $this->tablemodel->getPrimaryKey($table);
			
			if( $key->name == $column && !$this->tablemodel->primaryAllowed($table, $key->name, $_POST['val']) ) {
			
				$this->data['error_message_heading'] = $this->lang->line('db_savefield_error4_heading');
				$this->data['error_message'] = $this->lang->line('db_savefield_error4');
				
				$return['response_code'] = 2;
				
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
				die(json_encode($return));
			
			}
		
			//before updating the database, we'd like to store the current value
			$this->revisionmodel->saveRevision($db, $table, $column, $_POST['indexName'], $_POST['index'], $_POST['val'], time());
			
			$this->tablemodel->updateField($column, $_POST['val'], $_POST['indexName'], $_POST['index'], $table);
				
			$this->data['success_message_heading'] = "Success!";
			$this->data['success_message'] = "Your data has been saved!";
				
			$revisions = $this->revisionmodel->getRevisions($db, $table, $column, $_POST['indexName'], $_POST['index']);
			
			$return['revisions'] = $this->load->view("partials/cellrevisions", array('revisions'=>$revisions), true);
				
			$return['response_code'] = 1;
			$return['success_message'] = $this->load->view("partials/message_success", $this->data, true);
			
				
		}
		
		echo json_encode($return);
		
	}
	
	
	/*
		ajax call
		
		returns a single database record (record being a selection of cells)
	*/
	
	public function getRecord($db = '', $table = '', $indexName = '', $recordID = '', $param = 'editrecord') 
	{
		
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
		
	
		$return = array();//data to send back the client
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('db_getrecord_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_getrecord_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		//make sure this user is allowed to select fields
		if( !$this->usermodel->hasTablePermission('select', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('db_getrecord_error2_heading');
			$this->data['error_message'] = $this->lang->line('db_getrecord_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
			
		//setup DB connection
		$this->dbmodel->initialize($db);
		
		//return the record
			
		$return = array();//data to send back the client
			
		$return['response_code'] = 1;
			
		$recordArray = array();
			
		$recordArray['recordData'] = $this->dbmodel->getRecord($db, $table, $indexName, $recordID);
		$recordArray['theDB'] = $db;
		$recordArray['theTable'] = $table;
		$recordArray['indexName'] = $indexName;
		$recordArray['recordID'] = $recordID;
		
		if( $param == 'editrecord' ) {
			
			$recordArray['mode'] = 'edit';
			$return['record'] = $this->load->view('partials/record', $recordArray, true);
		
		} elseif( $param == 'viewrecord' ) {
		
			$recordArray['mode'] = 'view';
			$return['record'] = $this->load->view('partials/viewrecord', $recordArray, true);
		
		}
			
		echo json_encode($return);
		
	
	}
	
	
	/*
		ajax call
		
		updates a single record
	*/
	
	public function updateRecord($db = '', $table = '', $indexName = '', $recordID = '')
	{
		
		$indexName = urldecode($indexName);
		$recordID = urldecode($recordID);
	
	
		$return = array();//array to send back to the browser
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $indexName == '' || $indexName == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('db_updaterecord_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_updaterecord_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//make sure this user is allowed to select fields
		if( !$this->usermodel->hasTablePermission('update', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('db_updaterecord_error2_heading');
			$this->data['error_message'] = $this->lang->line('db_updaterecord_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		//grab all fields in this db
		
		$this->tablemodel->initialize($db);
		
		$allFields = $this->tablemodel->getFieldsFK($db, $table);;
		
		foreach($allFields as $field) {
			
			//do we have any custom restrictions?
			$columnRestrictions = $this->tablemodel->getColumnRestrictions($db, $table, $field['field'], 'string');
			
			if( $columnRestrictions !=  false ) {
									
				if( $field['type'] == 'int' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|numeric|'.$columnRestrictions);
				
				} elseif( $field['type'] == 'varchar' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|'.$columnRestrictions);
				
				}
			
			} else {
			
				if( $field['type'] == 'int' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|numeric|max_length['.$field['max_length'].']');
				
				} elseif( $field['type'] == 'varchar' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|max_length['.$field['max_length'].']');
				
				}
			
			}
		
		}
		
		if ($this->form_validation->run() == FALSE) {
			
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('db_updaterecord_error3_heading');
			$this->data['error_message'] = $this->lang->line('db_updaterecord_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			
			//primary key check
			
			$key = $this->tablemodel->getPrimaryKey($table);
			
			foreach( $allFields as $field ) {
			
				if( $field['field'] == $key->name && isset($_POST[$field['field']]) && !$this->tablemodel->primaryAllowed($table, $key->name, $_POST[$field['field']]) ) {
				
					$this->data['error_message_heading'] = $this->lang->line('db_updaterecord_error4_heading');
					$this->data['error_message'] = $this->lang->line('db_updaterecord_error4');
					
					$return['response_code'] = 2;
					
					$return['message'] = $this->load->view('partials/message_error', $this->data, true);
					
					die(json_encode($return));
				
				}
			
			}
		
	
			//setup DB connection
			$this->dbmodel->initialize($db);
		
		
			$this->dbmodel->updateRecord($db, $table, $indexName, $recordID, $_POST);
			
			//return success message
			$this->data['success_message_heading'] = $this->lang->line('db_updaterecord_success_heading');
			$this->data['success_message'] = $this->lang->line('db_updaterecord_success');
						
			
		
			$return['response_code'] = 1;
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
			
			//return revisions
			
			$revisionsData = array();
			
			$revisionsData['db'] = $db;
			$revisionsData['recordID'] = $recordID;
			$revisionsData['indexName'] = $indexName;
			$revisionsData['table'] = $table;
			$revisionsData['revisions'] = $this->revisionmodel->loadRecordRevisions($db, $table, $indexName, $recordID);
			
			$return['revisions'] = $this->load->view("partials/revisions", $revisionsData, true);
		
		}
			
		echo json_encode($return);
		
	
	}
	
	
	/*
		ajax call
		
		created a new record for given table in given database
	*/
	
	public function newRecord($db, $table)
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('db_newrecord_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_newrecord_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('insert', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('db_newrecord_error2_heading');
			$this->data['error_message'] = $this->lang->line('db_newrecord_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//set some rules
		
		//grab all fields in this db
		
		$this->tablemodel->initialize($db);
		
		$allFields = $this->tablemodel->getFieldsFK($db, $table);;
		
		foreach($allFields as $field) {
		
			//do we have any custom restrictions?
			$columnRestrictions = $this->tablemodel->getColumnRestrictions($db, $table, $field['field'], 'string');
			
			if( $columnRestrictions !=  false ) {
									
				if( $field['type'] == 'int' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|numeric|'.$columnRestrictions);
				
				} elseif( $field['type'] == 'varchar' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|'.$columnRestrictions);
				
				}
			
			} else {
			
				if( $field['type'] == 'int' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|numeric|max_length['.$field['max_length'].']');
				
				} elseif( $field['type'] == 'varchar' ) {
				
					$this->form_validation->set_rules($field['field'], $field['field'], 'trim|xss_clean|max_length['.$field['max_length'].']');
				
				}
			
			}
		
		}
		
		
		if ($this->form_validation->run() == FALSE) {
			
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('db_newrecord_error3_heading');
			$this->data['error_message'] = $this->lang->line('db_newrecord_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
		
			//all is well, let's add the record
			
			//initialize the db connection in the dbmodel
			$this->dbmodel->initialize($db);
			
			$this->dbmodel->newRecord($db, $table, $_POST);
			
			
			//sucess message
			//return success message
			$this->data['success_message_heading'] = $this->lang->line('db_newrecord_success_heading');
			$this->data['success_message'] = $this->lang->line('db_newrecord_success');
			
			
			//return empty new record form as well
			$return['newrecordform'] = $this->load->view('partials/newrecordform', array('tableFields_'=>$allFields, 'theDB'=>$db, 'theTable'=>$table), true);
				
			
			$return['response_code'] = 1;
			
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
		
		}
		
		
		echo json_encode($return);
	
	}
	
	
	/*
		delete a record in the given db/table
	*/
	
	public function deleteRecord($db, $table, $recordID)
	{
	
		$recordID = urldecode($recordID);
		
	
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_deleterecord_error1_heading');
			$temp['error_message'] = $this->lang->line('db_deleterecord_error1');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		
		//is this user allowed to update fields?
		if( !$this->usermodel->hasTablePermission('delete', $db, $table) ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_deleterecord_error2_heading');
			$temp['error_message'] = $this->lang->line('db_deleterecord_error2');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		
		//initialize db connection
		$this->dbmodel->initialize($db);
		
		$this->dbmodel->deleteRecord($db, $table, $recordID);
		
		
		
		$this->session->set_flashdata('success_message', $this->lang->line('db_deleterecord_success'));
		
		redirect('/db/'.$db."/".$table, "refresh");
	
	}
	
	
	/*
		ajax call
		
		creates a new table
	*/
	
	public function newTable($db)
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('db_newtable_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_newtable_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to add tables?
		if( !$this->usermodel->hasDBPermission('create', $db) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('db_newtable_error2_heading');
			$this->data['error_message'] = $this->lang->line('db_newtable_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		$this->form_validation->set_rules('tableName', 'Table name', 'trim|required|xss_clean|alpha_dash');
		
		//rules for the columns
		
		$c = 1;
		
		foreach( $_POST['columns'] as $col ) {
		
			if( $c > 1 ) {
		
				$this->form_validation->set_rules("columns[$c][columnName]", "Column $c: Column name", 'trim|required|xss_clean|alpha_dash|callback_column_check');
				$this->form_validation->set_rules("columns[$c][columnType]", "Column $c: Column type", 'trim|required|xss_clean');
			
			}
			
			$c++;
		}
		
		//rules for first column
		$this->form_validation->set_rules("columns[1][columnName]", "Column 1: Column name", 'trim|required|xss_clean|alpha_dash|callback_column_check');
		
		if ($this->form_validation->run() == FALSE) {
		
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('db_newtable_error3_heading');
			$this->data['error_message'] = $this->lang->line('db_newtable_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			//initialize the db for the table model
			$this->tablemodel->initialize($db);
			
		
			//check to see if the table aleady exists
			
			if( $this->tablemodel->exists($_POST['tableName']) ) {
			
				//table already exists
				
				$this->data['error_message_heading'] = $this->lang->line('db_newtable_error4_heading');
				$this->data['error_message'] = sprintf( $this->lang->line('db_newtable_error4'), $_POST['tableName'] );
								
				$return['response_code'] = 2;
				
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
				die(json_encode($return));
			
			}
			
			
			//check to make sure all the column names are unique
			
			if( !$this->tablemodel->uniqueColumns($_POST['columns']) ) {
			
				$this->data['error_message_heading'] = $this->lang->line('db_newtable_error5_heading');
				$this->data['error_message'] = $this->lang->line('db_newtable_error5');
				
				$return['response_code'] = 2;
				
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
				die(json_encode($return));
			
			}
			
		
			//create the new table
			
			
			
			$this->tablemodel->newTable($db, $_POST);
			
			
			//return success message
			$this->data['success_message_heading'] = $this->lang->line('db_newtable_success_heading');
			$this->data['success_message'] = sprintf( $this->lang->line('db_newtable_success'), site_url('db/'.$db.'/'.$_POST['tableName']) );							
			
			$return['response_code'] = 1;
			
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
		
		}
		
		echo json_encode($return);
	
	}
	
	
	/*
		custom validation method to make sure no MySQL reserved names are used for the database name
	*/
	
	public function column_check($str)
	{
	
		if ($str == 'column') {
		
			$this->form_validation->set_message('column_check', $this->lang->line('db_column_check_message'));
			return FALSE;
		
		} else {
			
			return TRUE;
				
		}
	
	}
	
	
	/*
		deletes table from database
	*/
	
	public function deleteTable($db, $table)
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined') {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_deletetable_error1_heading');
			$temp['error_message'] = $this->lang->line('db_deletetable_error1');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		
		//is this user allowed to delete tables?
		if( !$this->usermodel->hasDBPermission('drop', $db) && !$this->usermodel->ownsTable($db, $table) ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_deletetable_error2_heading');
			$temp['error_message'] = $this->lang->line('db_deletetable_error2');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
				
		//any referencing tables?
		if( $this->tablemodel->getReferencedTables($db, $table) != false ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_deletetable_error3_heading');
			$temp['error_message'] = $this->lang->line('db_deletetable_error3_part1')."<br><br><ul>";
			
			$tempArray = $this->tablemodel->getReferencedTables($db, $table);
			
			foreach( $tempArray as $arr ) {
			
				$temp['error_message'] .= "<li><b>".$arr['table']."</b> => ".$arr['column']."</li>";
			
			}
			
			$temp['error_message'] .= "</ul><br>".sprintf( $this->lang->line('db_deletetable_error3_part2'), site_url('db/'.$db.'/'.$table), $table );
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		} 
		
		//initialize db connection
		$this->tablemodel->initialize($db);
		
		$this->tablemodel->deleteTable($db, $table);
		
		//all done, redirect back
		$this->session->set_flashdata('success_message', $this->lang->line('db_deletetable_success'));
		
		redirect('/db/'.$db, "refresh");
	
	}
	
	
	/*
		retrieve cell data
	*/
	
	public function getCell($db = '', $table = '', $column = '', $recordID = '')
	{
		
		$column = urldecode($column);
		$recordID = urldecode($recordID);
	
		
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $column == '' || $column == 'undefined' || $recordID == '' || $recordID == 'undefined') {
		
			$this->data['error_message_heading'] = "Ouch!";
			$this->data['error_message'] = "Some database connection details are missing. Please reload the page and try again.";
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to select records?
		if( !$this->usermodel->hasTablePermission('select', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('db_getcell_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_getcell_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
				
		//initialize db connection
		$this->dbmodel->initialize($db);
		
		$cell = $this->dbmodel->getCell($db, $table, $column, $recordID);
		
		$return['cell'] = $this->load->view('partials/cell', array('cell'=>$cell), true);
		
		echo json_encode($return);
	
	}
	
	/*
		updates a table
	*/
	
	public function updateTable($db = '', $table = '')
	{
		
		$this->data = array();
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined') {
			
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_updatetable_error1_heading');
			$temp['error_message'] = $this->lang->line('db_updatetable_error1');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		//is this user allowed to select records?
		if( !$this->usermodel->hasDBPermission('drop', $db) && !$this->usermodel->ownsTable($db, $table) ) {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('db_updatetable_error2_heading');
			$temp['error_message'] = $this->lang->line('db_updatetable_error2');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		$this->form_validation->set_rules('tableName', 'Table name', 'trim|required|xss_clean|alpha_dash');
		
		
		if ($this->form_validation->run() == FALSE) {
		
			//no good
			$this->session->set_flashdata('error_message', $this->lang->line('db_updatetable_error3').validation_errors());
			
			redirect('/db/'.$db."/".$table, 'refresh');
			
		
		} else {
		
			//initialize the db for the table model
			$this->tablemodel->initialize($db);
				
			
			//check to see if the table aleady exists
				
			if( $this->tablemodel->exists($_POST['tableName']) ) {
				
				$this->session->set_flashdata('error_message', sprintf( $this->lang->line('db_updatetable_error4'), $_POST['tableName'] ));
				
				redirect('/db/'.$db."/".$table, 'refresh');
				
			}
			
			//all good, update
			
			$this->tablemodel->updateTable($db, $table, $_POST);
			
			$this->session->set_flashdata('success_message', $this->lang->line('db_updatetable_success'));
			
			redirect('/db/'.$db."/".$_POST['tableName'], 'refresh');
			
		}
			
	}
	
	
	public function uploadCsv($db)
	{		
	
		//return array
		$return = array();
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined') {
			
			//no good
			$this->data['error_message_heading'] = $this->lang->line('db_uploadcsv_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_uploadcsv_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		
		//some form validation
		
		//$this->form_validation->set_rules('tableName', 'Table name', 'trim|required|xss_clean|alpha_dash');
		
		if (1 == FALSE) {
		
			//no good
			$this->data['error_message_heading'] = $this->lang->line('db_uploadcsv_error2_heading');
			$this->data['error_message'] = $this->lang->line('db_uploadcsv_error2').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
			
		
		} else {
		
			//initialize the db for the table model
			$this->tablemodel->initialize($db);
		
			
			//check to make sure the table name does not exist yet
			
			if( $this->tablemodel->exists($_POST['tableName']) ) {
			
				$this->data['error_message_heading'] = $this->lang->line('db_uploadcsv_error3_heading');
				$this->data['error_message'] = sprintf( $this->lang->line('db_uploadcsv_error3'), $_POST['tableName'] );
				
				$return['response_code'] = 2;
				
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
				die(json_encode($return));
			
			}
			
	
			$config['upload_path'] = './tmp/';
			$config['allowed_types'] = 'csv';

			$this->load->library('upload', $config);
			
			
			//check to see if the /tmp folder is writable
			

			if ( ! $this->upload->do_upload('thefile')) {
		
				//ouch, something's wrong!
			
				$this->data['error_message_heading'] = $this->lang->line('db_uploadcsv_error4_heading');
				$this->data['error_message'] = $this->lang->line('db_uploadcsv_error4').$this->upload->display_errors();
			
				$return['response_code'] = 2;
			
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
				die(json_encode($return));
			
			
			} else {
		
				//all good, we can now process the file
				
				//create the new table
				
				
				//grab the file data
				$fileData = $this->upload->data();
								
				
				$this->load->library('csvreader');
				
				//set the dilimiter
				
				//guess the delimiter by examinating the first three lines
				
				$suggestedDilimiter = $this->csvreader->guessDelimiter(base_url()."/tmp/".$fileData['file_name']);
								
				
				if( isset($_POST['separateColumns']) && $_POST['separateColumns'] != '' ) {
				
					//is the requested dilimiter different from the sniffed one?
					
					if( $suggestedDilimiter != $_POST['separateColumns'] ) {
					
						$this->data['error_message_heading'] = $this->lang->line('db_uploadcsv_error5_heading');
						$this->data['error_message'] = $this->lang->line('db_uploadcsv_error5');
						
						$return['response_code'] = 2;
						
						$return['message'] = $this->load->view('partials/message_error', $this->data, true);
						
						die(json_encode($return));
					
					} else {
				
						$dilimiter = $_POST['separateColumns'];
					
					}
				
				} else {
				
					$dilimiter = $suggestedDilimiter;
				
				}
				
				
				//set the enclosure
				if( isset($_POST['encloseColumns']) && $_POST['encloseColumns'] != '' ) {
				
					$enclosure = $_POST['encloseColumns'];
				
				} else {
				
					$enclosure = '"';
				
				}
				
				
				//check if the first rown contains the columns				
				if( isset($_POST['columns']) && $_POST['columns'] == 'yes' ) {
				
					//use the first row as column names
					
					$file = fopen(base_url()."/tmp/".$fileData['file_name'],"r");
					
					$firstRow = fgetcsv($file, 1000, $dilimiter, $enclosure);										
										
					fclose($file);
					
					$this->tablemodel->createTableforCSV( $db, $_POST['tableName'], $firstRow, $fileData, true, $dilimiter, $enclosure );
					
				
				} else {
				
					//create our own column names
					
					$file = fopen(base_url()."/tmp/".$fileData['file_name'],"r");
										
					$firstRow = fgetcsv($file, 1000, $dilimiter, $enclosure);
										
					fclose($file);
					
					$cols = array();
					
					$counter = 0;
					
					foreach( $firstRow as $row ) {
					
						$cols[$counter] = "Column_".$counter;
						
						$counter++;
					
					}
					
					$this->tablemodel->createTableforCSV( $db, $_POST['tableName'], $cols, $fileData, false, $dilimiter, $enclosure );
				
				}
				
				//remove file
				unlink($fileData['full_path']);
		
			}
			
			//return success message
			$this->data['success_message_heading'] = $this->lang->line('db_uploadcsv_success_heading');
			$this->data['success_message'] = sprintf( $this->lang->line('db_uploadcsv_success'), site_url('db/'.$db.'/'.$_POST['tableName']) );				
			
			$return['response_code'] = 1;
			
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
			
			die(json_encode($return));
			
		}
	
	}
	
	
	/*
		imports CSV data into an existing table
	*/
	
	public function importCsv($db)
	{
	
		//return array
		$return = array();
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined') {
			
			//no good
			$this->data['error_message_heading'] = $this->lang->line('db_importcsv_error1_heading');
			$this->data['error_message'] = $this->lang->line('db_importcsv_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		
		$config['upload_path'] = './tmp/';
		$config['allowed_types'] = 'csv';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('thefile')) {
		
			//ouch, something's wrong!
			
			$this->data['error_message_heading'] = $this->lang->line('db_importcsv_error2_heading');
			$this->data['error_message'] = $this->lang->line('db_importcsv_error2').$this->upload->display_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
			
			
		} else {
		
			//grab the file data
			$fileData = $this->upload->data();
			
			$this->load->library('csvreader');
			
			$suggestedDilimiter = $this->csvreader->guessDelimiter(base_url()."/tmp/".$fileData['file_name']);
			
			
			if( isset($_POST['separateColumns']) && $_POST['separateColumns'] != '' ) {
			
				//is the requested dilimiter different from the sniffed one?
				
				if( $suggestedDilimiter != $_POST['separateColumns'] ) {
				
					$this->data['error_message_heading'] = $this->lang->line('db_importcsv_error3_heading');
					$this->data['error_message'] = $this->lang->line('db_importcsv_error3');
					
					$return['response_code'] = 2;
					
					$return['message'] = $this->load->view('partials/message_error', $this->data, true);
					
					die(json_encode($return));
				
				} else {
			
					$dilimiter = $_POST['separateColumns'];
				
				}
			
			} else {
			
				$dilimiter = $suggestedDilimiter;
			
			}
			
			
			//set the enclosure
			if( isset($_POST['encloseColumns']) && $_POST['encloseColumns'] != '' ) {
			
				$enclosure = $_POST['encloseColumns'];
			
			} else {
			
				$enclosure = '"';
			
			}
			
			//initialize the db for the table model
			$this->tablemodel->initialize($db);
			
			
			$res = $this->tablemodel->importCSV($db, $_POST['tableName'], $fileData, $dilimiter, $enclosure);
			
			//remove file
			unlink($fileData['full_path']);
			
			if( $res ==  true ) {
				
				//success message
				$this->data['success_message_heading'] = $this->lang->line('db_importcsv_success_heading');
				$this->data['success_message'] = sprintf( $this->lang->line('db_importcsv_success'), site_url('db/'.$db.'/'.$_POST['tableName']) );
								
				$return['response_code'] = 1;
				
				$return['message'] = $this->load->view('partials/message_success', $this->data, true);
				
				die(json_encode($return));
			
			} elseif( $res == false ) {
				
				//error message
				$this->data['error_message_heading'] = $this->lang->line('db_importcsv_error4_heading');
				$this->data['error_message'] = $this->lang->line('db_importcsv_error4');
				
				$return['response_code'] = 2;
				
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
				die(json_encode($return));
			
			}
	
		}
	
	}
				
}

/* End of file db.php */
/* Location: ./application/controllers/db.php */