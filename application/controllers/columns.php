<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Columns extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->model('tablemodel');
		$this->load->model('usermodel');
		$this->load->model('columnnotemodel');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
		
	}
	
	
	/*
		ajax call
		
		return the details for a given table column
	*/
	
	public function getDetails($db = '', $table = '', $column = '')
	{
	
		$column = urldecode($column);		
		
		$return = array();//array to send back to the browser
	
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('alter', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('colums_getdetails_error1_heading');
			$this->data['error_message'] = $this->lang->line('colums_getdetails_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $column == '' || $column == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('colums_getdetails_error2_heading');
			$this->data['error_message'] = $this->lang->line('colums_getdetails_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
				
		
		$return['response_code'] = 1;
	
		//setup DB connection for the model
		$this->tablemodel->initialize($db);
		
		//get the column details
		
		$columnStuff = array();
		
		$columnStuff['columnDetails'] = $this->tablemodel->getColumnDetails($db, $table, $column);
		
		$columnStuff['tableFields'] = $this->tablemodel->getFieldsFor($table);
		
		$columnStuff['tables'] = $this->tablemodel->tablesPlusColumns($db);
		
		//check wether or not this table has a primary key set
		
		if( $this->tablemodel->getPrimaryKey($table) ) {
		
			$columnStuff['hasPrimary'] = true;
		
		}
		
		$columnStuff['db'] = $db;
		
		$columnStuff['table'] = $table;
		
		$columnStuff['table_engine'] = $this->tablemodel->getEngine($table);
		
		$columnStuff['column'] = $column;
		
		$return['column'] = $this->load->view('partials/column_edit', $columnStuff, true);
		
		$columnRestrictions = $this->tablemodel->getColumnRestrictions($db, $table, $column);
				
		$return['columnRestrictions'] = $this->load->view('partials/columnrestrictions', array('columnRestrictions'=>$columnRestrictions), true);
				
		$return['columnName'] = $column;
				
		//return the column notes as well
		
		$columnNotes = $this->columnnotemodel->getColumnNotes($db, $table, $column);
		
		$return['notes'] = $this->load->view("partials/columnnotes", array('notes'=>$columnNotes), true);
		
		echo json_encode($return);
	
	}
	
	
	/*
		ajax call
		
		updates a columns details
	*/
	
	public function update($db = '', $table = '')
	{
	
		$return = array();//array to send back to the browser
		
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('colums_update_error1_heading');
			$this->data['error_message'] = $this->lang->line('colums_update_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('alter', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('colums_update_error2_heading');
			$this->data['error_message'] = $this->lang->line('colums_update_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
	
	
		$this->form_validation->set_rules('columnName', 'Column name', 'required|trim|xss_clean|alpha_dash|callback_column_check');
		$this->form_validation->set_rules('columnType', 'Column type', 'required|trim|xss_clean');
		$this->form_validation->set_rules('columnOffset', 'Column position', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('colums_update_error3_heading');
			$this->data['error_message'] = $this->lang->line('colums_update_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			//initialize db connection
			$this->tablemodel->initialize($db);
			
			//check to make sure the new columns name is unique
			
			if( $_POST['columnName'] != $_POST['columnName_old'] && $this->tablemodel->getColumnDetails($db, $table, $_POST['columnName']) ) {//returns false if column does not exist
			
				$this->data['error_message_heading'] = $this->lang->line('colums_update_error4_heading');
				$this->data['error_message'] = $this->lang->line('colums_update_error4');
				
				$return['response_code'] = 2;
				
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
				die(json_encode($return));
			
			}
			
			//if this column is to be used as a relation, we'll need to make sure the column type matches with the primary key type of the referenced table
			
			if( isset($_POST['connectTo']) && $_POST['connectTo'] != '' ) {
			
				$temp = explode(".", $_POST['connectTo']);
								
				$pkey = $this->tablemodel->getPrimaryKey($temp[0])->name;
								
				$pkeyData = $this->tablemodel->getColumnDetails($db, $temp[0], $pkey);
								
				//make sure this is correct
				$_POST['columnType'] = strtolower($pkeyData['type']);
				
			
			} 
			
			//print_r($_POST['restrictions']);
			
			//die('');
			
			
			//all good, update the column
						
			$columnDetails = $this->tablemodel->updateColumn($db, $table, $_POST['columnName_old'], $_POST);
			
			//column form/details
			
			$columnStuff = array();
			
			$columnStuff['columnDetails'] = $columnDetails;
			
			$columnStuff['tableFields'] = $this->tablemodel->getFieldsFor($table);
			
			$columnStuff['tables'] = $this->tablemodel->tablesPlusColumns($db);
			
			//check wether or not this table has a primary key set
			
			if( $this->tablemodel->getPrimaryKey($table) ) {
			
				$columnStuff['hasPrimary'] = true;
			
			}
			
			$columnStuff['db'] = $db;
			$columnStuff['table'] = $table;
			$columnStuff['table_engine'] = $this->tablemodel->getEngine($table);
			$columnStuff['column'] = $columnDetails['name'];
			
			//the column from
			$return['column'] = $this->load->view('partials/column_edit', $columnStuff, true);
			
			//restrictions
			$columnRestrictions = $this->tablemodel->getColumnRestrictions($db, $table, $columnDetails['name']);
					
			$return['columnRestrictions'] = $this->load->view('partials/columnrestrictions', array('columnRestrictions'=>$columnRestrictions), true);
			
			$return['columnName'] = $columnDetails['name'];
			
			
			//the updates column row to update the table with
			$cData = array();
			$cData['theDB'] = $db;
			$cData['theTable'] = $table;
			$cData['tableFields'] = $this->tablemodel->getFieldsFor($table);
			
			$return['columns'] = $this->load->view("partials/column_table", $cData, true);
			
			//success message
			$this->data['success_message_heading'] = $this->lang->line('colums_update_success_heading');
			$this->data['success_message'] = $this->lang->line('colums_update_success');
			
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
			
			$return['response_code'] = 1;
				
		}
		
		echo json_encode($return);
	
	}
	
	/*
		custom validation method to make sure no MySQL reserved names are used for the database name
	*/
	
	public function column_check($str)
	{
	
		if ($str == 'column') {
		
			$this->form_validation->set_message('column_check', $this->lang->line('colums_column_check_message'));
			return FALSE;
		
		} else {
			
			return TRUE;
				
		}
	
	}
	
	
	/*
		deletes an entire column from the given table in the given database
	*/
	
	public function delete($db = '', $table = '', $column = '')
	{
		
		$column = urldecode($column);
	
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined' || $column == '' || $column == 'undefined') {
		
			$temp = array();
			$temp['error_message_heading'] = $this->lang->line('colums_delete_error1_heading');
			$temp['error_message'] = $this->lang->line('colums_delete_error1');
						
			die( $this->load->view('shared/alert', array('data'=>$temp), true) );
		
		}
		
		//is this user allowed to edit columns?
		if( !$this->usermodel->hasTablePermission('alter', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('colums_delete_error2_heading');
			$this->data['error_message'] = $this->lang->line('colums_delete_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
	
		//at some point we'd like to implement backing up a column before deleting it
		
		//initialize tablemodel db connection
		$this->tablemodel->initialize($db);
			
		$this->tablemodel->deleteColumn($db, $table, $column);
			
		$this->session->set_flashdata('success_message', 'The column was successfully deleted from <b>'.$table."</b> in <b>".$db."</b>");
			
		redirect("/db/".$db."/".$table, "refresh");
		
	
	}
	
	
	/*
		ajax call
		
		creates a new column
	*/
	
	public function addColumn($db = '', $table = '')
	{
	
		$return = array();//array to send back to the browser
		
		//make sure we've got all the required db details
		if($db == '' || $db == 'undefined' || $table == '' || $table == 'undefined') {
		
			$this->data['error_message_heading'] = $this->lang->line('colums_addcolumn_error1_heading');
			$this->data['error_message'] = $this->lang->line('colums_addcolumn_error1');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//is this user allowed to mess around with columns?
		if( !$this->usermodel->hasTablePermission('alter', $db, $table) ) {
		
			$this->data['error_message_heading'] = $this->lang->line('colums_addcolumn_error2_heading');
			$this->data['error_message'] = $this->lang->line('colums_addcolumn_error2');
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
			
			die(json_encode($return));
		
		}
		
		
		//now validate the form data
		$this->form_validation->set_rules('columnName', 'Column name', 'required|trim|xss_clean|alpha_dash');
		$this->form_validation->set_rules('columnType', 'Column type', 'required|trim|xss_clean');
		$this->form_validation->set_rules('columnOffset', 'Column position', 'required|trim|xss_clean');
		
		
		if ($this->form_validation->run() == FALSE) {
			
			//something ain't right
			
			$this->data['error_message_heading'] = $this->lang->line('colums_addcolumn_error3_heading');
			$this->data['error_message'] = $this->lang->line('colums_addcolumn_error3').validation_errors();
			
			$return['response_code'] = 2;
			
			$return['message'] = $this->load->view('partials/message_error', $this->data, true);
		
		} else {
		
			//initialize db connection
			$this->tablemodel->initialize($db);
		
			//check to make sure the new columns name is unique
			
			if( $this->tablemodel->getColumnDetails($db, $table, $_POST['columnName']) ) {//returns false if column does not exist
			
				$this->data['error_message_heading'] = $this->lang->line('colums_addcolumn_error4_heading');
				$this->data['error_message'] = $this->lang->line('colums_addcolumn_error4');
				
				$return['response_code'] = 2;
				
				$return['message'] = $this->load->view('partials/message_error', $this->data, true);
				
				die(json_encode($return));
			
			}
			
			//if this column is to be used as a relation, we'll need to make sure the column type matches with the primary key type of the referenced table
			
			if( isset($_POST['connectTo']) && $_POST['connectTo'] != '' ) {
			
				$temp = explode(".", $_POST['connectTo']);
				
				$pkey = $this->tablemodel->getPrimaryKey($temp[0])->name;
				
				$pkeyData = $this->tablemodel->getColumnDetails($db, $temp[0], $pkey);
				
				//make sure this is correct
				$_POST['columnType'] = strtolower($pkeyData['type']);
				
			
			} 
			
			
			//all good, update the column
			
			//print_r($_POST['restrictions']);
			
			//die();
						
			$this->tablemodel->newColumn($db, $table, $_POST);
			
			//success message
			$this->data['success_message_heading'] = $this->lang->line('colums_addcolumn_success_heading');
			$this->data['success_message'] = sprintf( $this->lang->line('colums_addcolumn_success'), site_url('db/'.$db.'/'.$table) );
			
			$return['message'] = $this->load->view('partials/message_success', $this->data, true);
			
			$return['response_code'] = 1;
				
		}
		
		
		echo json_encode($return);
		
	}
	
}

/* End of file columns.php */
/* Location: ./application/controllers/columns.php */