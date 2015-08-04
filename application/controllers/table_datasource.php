<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Table_datasource extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Datatables');
		$this->load->model('tablemodel');
		$this->load->model('usermodel');
		$this->load->helper('html_helper');
		//$this->load->library('session');
		$this->load->library('ion_auth');
		$this->load->library('encrypt');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		} 
		
	}
	
	
	/*
		required to connect to one of the databases
	*/
	
	public function connectDB($db) 
	{
	
		//manual dynamic database connection
		
		$config = array();
		
		$temp = $this->db->from('dbapp_databases')->where('dbapp_databases_database', $db)->get()->result();
		
		$config['hostname'] = $this->db->hostname;
			
		
		if( $this->ion_auth->is_admin() ) {//for admin/root access
			
			$config['username'] =  $this->db->username;
			$config['password'] =  $this->db->password;
			
		} else {//regular user access
		
			$decrypted_pass = $this->encrypt->decode($this->ion_auth->user()->row()->mysql_pw);
			
			$config['username'] = $this->ion_auth->user()->row()->mysql_user;
			$config['password'] = trim($decrypted_pass);
			
		}
			
		$config['database'] = $db;
		$config['dbdriver'] = 'mysql';
		$config['dbprefix'] = '';
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';
		$config['swap_pre'] = '';
		$config['autoinit'] = TRUE;
		$config['stricton'] = FALSE;
		
		if( $this->db->port != '' ) {
		
			$config['port'] = $this->db->port;
		
		}
			
		$this->theDB = $this->load->database($config, TRUE);
		$this->theDBname = $db;
	
	}
	
	
	/*
		ajax call
		
		used by jquery's datatables plugin to load a db table
	*/

	public function index($db, $table)
	{
		
		$this->load->database();
		
		$this->connectDB($db);
		
		//get primary key for this table
		$primaryKey = $this->tablemodel->getPrimaryKey($table);
				
		
		$this->datatables->set_DB($this->theDB);
		$this->datatables->from($table);
		
		
		
		if($this->session->userdata($db.".".$table)) {
		
			//we've got columns registered with this session
			
			$fields = $this->theDB->list_fields($table);
			
			$temp = array();
			
			$c = 0;//join counter
			
			foreach ($fields as $field) {
																	
			   	if(in_array($field, $this->session->userdata($db.".".$table))) {
			   		
					$res = $this->tablemodel->getForeignKey($db, $table, $field);
					
					if( $res ) {
												
						array_push($temp, "T".$c.".".$res['use_column']." as ".$res['referencing_field']);
						
						$this->datatables->join($res['referenced_table']." as T".$c, $table.".".$res['referencing_field']." = "."T".$c.".".$res['referenced_field'], 'left');
						
					} else {
					
			   			array_push($temp, $table.".".$field);
					
					}
			   	}
				
				$c++;
				
			} 
			
			$allColumnsString = implode(", ", $temp);
			
		
		} else {
		
			//no columns with session, display all
			$fields = $this->tablemodel->getFieldsFor($table);
			
			$fieldNames = array();
			
			$c = 0;//join counter
			
			foreach($fields as $field) {
				
				$res = $this->tablemodel->getForeignKey($db, $table, $field['field']);
				
				if( $res ) {
					
					array_push($temp, "T".$c.".".$res['use_column']." as ".$res['referencing_field']);
					
					$this->datatables->join($res['referenced_table']." as T".$c, $table.".".$res['referencing_field']." = "."T".$c.".".$res['referenced_field'], 'left');
					
				} else {
							
					array_push($fieldNames, $table.".".$field['field']);
				
				}
				
				$c++;
				
			}
			
			$allColumnsString = implode(", ", $fieldNames);
			
		}
		
		//die($allColumnsString);
		
		
		
				
		$this->datatables->select($allColumnsString);
		
				
		if( $this->tablemodel->isPrivate($db, $table) && !$this->ion_auth->is_admin() ) {
		
			$this->datatables->join($this->db->database.'.dbapp_users_records', $table.".".$primaryKey->name." = dbapp_users_records.dbapp_users_records_recordid", 'left');
		
			$user = $this->ion_auth->user()->row();
		
			$this->datatables->where('dbapp_users_records_userid', $user->id);
		
		}
		
		
		//do we have any search items set?
		
		if( $this->session->userdata('searchItems') != '' && $this->session->userdata('searchItems_db') == $db && $this->session->userdata('searchItems_table') == $table ) {
		
			$searchItems = $this->session->userdata('searchItems');
			
			$c = 0;
			
			foreach( $searchItems as $item ) {
				
				//linked data?
				$res = $this->tablemodel->getForeignKey($db, $table, $item['column']);
				
				if( $res ) {
					$this->datatables->join($res['referenced_table']." as Q".$c, $table.".".$res['referencing_field']." = "."Q".$c.".".$res['referenced_field'], 'left');
				}
			
				if( $item['operator'] == 'LIKE' ) {
				
					$this->datatables->like($item['column'], $item['value'], 'none');
				
				} elseif( $item['operator'] == 'LIKE%%' ) {
					
					if($res) {
						
						$this->datatables->like("Q".$c.".".$res['use_column'], $item['value'], 'both');
						
					} else {
				
						$this->datatables->like($item['column'], $item['value'], 'both');
					
					}
				
				} elseif( $item['operator'] == 'NOT LIKE%%' ) {
					
					if($res) {
					
						$this->datatables->not_like("Q".$c.".".$res['use_column'], $item['value']);
						
					} else {
				
						$this->datatables->not_like($item['column'], $item['value']);
					
					}
				
				} elseif( $item['operator'] == 'NOT LIKE' ) {
					
					if($res) {
						
						$this->datatables->not_like("Q".$c.".".$res['use_column'], $item['value']);
						
					} else {
				
						$this->datatables->not_like($item['column'], $item['value']);
					
					}
				
				} else {
			
					if($res) {
						
						$this->datatables->where("Q".$c.".".$res['use_column'].' '.$item['operator'], $item['value']);
						
					} else {
					
						$this->datatables->where($item['column'].' '.$item['operator'], $item['value']);
					
					}
				
				}
				
				$c++;
				
			}
		
		}
		
		
		if( $primaryKey != false ) {
		
			if( $this->usermodel->hasTablePermission("update", $db, $table) ) {
		
				//$this->datatables->edit_column($primaryKey->name, '<span class="recordID" id="record_$1">$1</span> <span class="pull-right tableCrud"><a href="#recordModal" id="record_$1" class="crudEdit" title="Edit this record" data-placement="right" data-toggle="modal"><span class="fui-new"></span></a>&nbsp;&nbsp;<a href="#" class="crudDel" id="$1" title="Delete this record" data-placement="right"><span class="fui-cross-inverted"></span></a></span>', $primaryKey->name);
			
				$this->datatables->add_column('actions', '<span class="recordID" id="record_$1"></span> <span class="pull-right tableCrud"><a href="#recordModal" id="record_$1" class="crudEdit" title="Edit this record" data-placement="right" data-toggle="modal"><span class="fui-new"></span></a>&nbsp;&nbsp;<a href="#" class="crudDel" id="$1" title="Delete this record" data-placement="right"><span class="fui-cross-inverted"></span></a></span>', $table.".".$primaryKey->name);
		
			} else {
		
				//$this->datatables->edit_column($primaryKey->name, '<span class="recordID" id="record_$1">$1</span> <span class="pull-right tableCrud"><a href="#recordViewModal" id="record_$1" class="crudView" title="View this record" data-placement="right" data-toggle="modal"><span class="fui-export"></span></a></span>', $primaryKey->name);
			
				$this->datatables->add_column('actions', '<span class="recordID" id="record_$1"></span> <span class="pull-right tableCrud"><a href="#recordViewModal" id="record_$1" class="crudView" title="View this record" data-placement="right" data-toggle="modal"><span class="fui-export"></span></a></span>', $table.".".$primaryKey->name);
		
			}
		
			echo $this->datatables->generate();
					
		}
				
	}
}

/* End of file table.php */
/* Location: ./application/controllers/table.php */