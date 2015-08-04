<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DbModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->model('tablemodel');
        $this->load->model('usermodel');
        $this->load->model('revisionmodel');
        
    }
    
    
    /*
    	the initialize function is required to be able to connect to an addional database (database other then the one
    	user by the app)
    */
    
    public function initialize($db) 
    {
    
    	//manual dynamic database connection
    	
    	$config = array();
    	
    	$tempp = $this->db->from('dbapp_databases')->where('dbapp_databases_database', $db)->get()->result();
    	
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
    	$config['db_debug'] = FALSE;
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
    	returns all databases managed by the app
    */
    
    function listAll($incl_tables = false) 
    {
        
    	$dbs = $this->db->from('dbapp_databases')->get()->result();
    	
    	$return = array();
    	
    	foreach($dbs as $db) {
    	
    		if($this->usermodel->hasAccessToDb($db->dbapp_databases_database)) {
    		
    			//verify that this db exists on the mysql server
    			if( !$this->dbmodel->exists($db->dbapp_databases_database) ) {
    			
    				$temp = array();
    				$temp['error_message_heading'] = "Invalid Database";
    				$temp['error_message'] = "The database: <b>".$db->dbapp_databases_database."</b> does not exist on this server. Please contact support at <a href='mailto:".$this->config->item('support_email')."'>".$this->config->item('support_email')."</a>";
    							
    				die( $this->load->view('shared/alert', array('data'=>$temp), true) );
    			
    			}
    	
    			$temp = array();
    			$temp['db'] = $db->dbapp_databases_database;
    			$temp['id'] = $db->dbapp_databases_id;
    		
    			if($incl_tables) {
    	    		
    				$temp['tables'] = $this->tablemodel->listAllFor($db->dbapp_databases_database);
    			
    			} 
    		
    			array_push($return, $temp);
    		
    		}
    	
    	}
    	
    	return $return;
    
    }
    
    
    /*
    	returns all the MySQL databases on the server, exl certain databases and marks those which 
    	are enabled in the app and those which can't be enabled in the app
    */
    
    public function listAllMySQL()
    {
    
    	$dbs = $this->db->query("show databases")->result();
    	    	
    	$return = array();
    	    	
    	foreach( $dbs as $db ) {    		
    	
    		if( $db->Database != $this->db->database && $db->Database != 'information_schema' && $db->Database != 'mysql' && $db->Database != 'performance_schema' ) {//reserved databases
    		
    			$temp = array();
    			
    			//is this db enabled
    			if( $this->db->from('dbapp_databases')->where('dbapp_databases_database', $db->Database)->get()->num_rows() == 0 ) {
    		
    				$temp['enabled'] = 'no';
    			
    			} else {
    			
    				$temp['enabled'] = 'yes';
    			
    			}
    			
    			
    			//does this db pass our test?
    			if( $this->checkDB($db->Database) ) {
    			
    				$temp['allowed'] = 'yes';
    			
    			} else {
    			
    				$temp['allowed'] = 'no';
    			
    			}
    			
    			
    			$temp['db'] = $db->Database;
    			
    			array_push($return, $temp);
    		
    		}
    	
    	}
    	
    	if( count($return) > 0 ) {
    	
    		return $return;
    	
    	} else {
    		
    		return false;
    	
    	}
    	    
    }
    
    
    /*
    	returns data for a single cell
    */
    
    public function getCell($db, $table, $column, $recordID)
    {
    
    	$cellArray = array();
    	
    
    	//get the primary key for this table
    	
    	$this->tablemodel->initialize($db);
    	
    	$primaryKey = $this->tablemodel->getPrimaryKey($table)->name;
    	
    	
    	//value
    	
    	$cellArray['column'] = $column;
    	
    	$tempp = $this->theDB->from($table)->where($primaryKey, $recordID)->get()->result();
    	    	
    	$cellArray['value'] = $tempp[0]->$column;
    
    	
    	//max_length and type
    	
    	$columns = $this->theDB->field_data($table);
    	
    	foreach( $columns as $col ) {
    	
    		if( $col->name == $column ) {
    		
    			$cellArray['type'] = $col->type;
    			$cellArray['max_length'] = $col->max_length;
    		
    		}
    	
    	}
    	
    	
    	//possible FK data
    	if( $this->tablemodel->hasFK($table, $column) ) {
    	    		    			
    		//grab the relation from the db
    		
    		$query = $this->db->from('dbapp_relations')->where('dbapp_relations_database', $db)->where('dbapp_relations_source_table', $table)->where('dbapp_relations_source_field', $column)->get();
    		
    		if( $query->num_rows() ) {
    			
    			$relation = $query->row();
    		
    			$cellArray['reference_table'] = $relation->dbapp_relations_reference_table;
    			$cellArray['reference_table_key'] = $relation->dbapp_relations_reference_field;
    			$cellArray['use_column'] = $relation->dbapp_relations_reference_use;
    		    			
    			//grab the referenced data
    			$referencedData = $this->theDB->select($cellArray['reference_table_key'])->select($cellArray['use_column'])->from($cellArray['reference_table'])->order_by($cellArray['use_column'])->get()->result_array();
    		
    			//die($this->theDB->last_query());
    		
    			$cellArray['referenced_data'] = $referencedData;
    		
    		}
    		    	
    	}
    	
    	//get additional columndata
    	$cellArray['additional_data'] = $this->tablemodel->getColumnDetails($db, $table, $column);
    	
    	return $cellArray;
    	
    }
    
    
    /*
    	returns a single record
    */
    
    public function getRecord($db, $table, $indexName, $recordID) 
    {
    
    	$tempp = $this->theDB->from($table)->where($indexName, urldecode($recordID))->get()->result_array();
		    
    	$record = $tempp[0];
    	
    	$return = array();
    	    	
    	//initialize db connecttion for table model
    	$this->tablemodel->initialize($db);
    	
    	foreach( $record as $col=>$val ) {
    	
    		$temp = array();
    		
    		$temp['val'] = $val;
    	
    		//find possible foreign keys
    		if( $this->tablemodel->hasFK($table, $col) ) {
    		    			    			
    			//grab the relation from the db
    			
    			$relation = $this->db->from('dbapp_relations')->where('dbapp_relations_database', $db)->where('dbapp_relations_source_table', $table)->where('dbapp_relations_source_field', $col)->get()->row();
    			
    			if( $relation ) {
    			
    				$temp['reference_table'] = $relation->dbapp_relations_reference_table;
    				$temp['reference_table_key'] = $relation->dbapp_relations_reference_field;
    				$temp['use_column'] = $relation->dbapp_relations_reference_use;
    			    			
    				//grab the referenced data
    				$referencedData = $this->theDB->select($temp['reference_table_key'])->select($temp['use_column'])->from($temp['reference_table'])->order_by($temp['use_column'])->get()->result_array();
    			
    				//die($this->theDB->last_query());
    			
    				$temp['referenced_data'] = $referencedData;
    			
    			}		
    		
    		}
    		
    		//get additional columndata
    		$temp['additional_data'] = $this->tablemodel->getColumnDetails($db, $table, $col);
    		
    		$return[$col] = $temp;
    		    		    	
    	}
    	    	
    	return $return;
    
    }
    
    
    /*
    	updates a single record
    */
    
    public function updateRecord($db, $table, $indexName, $recordID, $data)
    {
    
    	//do we need to store any revisions then?
    	$record = $this->getRecord($db, $table, $indexName, $recordID);
    	
    	//set up DB connection
    	$this->revisionmodel->initialize($db);
    	    	
    	foreach($data as $key=>$value) {
    	    	
    		//is the new value different from the stored one?
    		if( $record[$key] != $value ) {
    		
    			$this->revisionmodel->saveRevision($db, $table, $key, $indexName, $recordID, $value, time());
    		
    		}
    	
    	}
    	
    	$this->theDB->where($indexName, $recordID);
    	$this->theDB->update($table, $data);
    	
    	//echo $this->theDB->last_query();
    
    }
    
    
    /*
    	creates a new record in the given db/table
    */
    
    public function newRecord($db, $table, $data)
    {
    
    	//remove the empties
    	
    	foreach( $data as $key=>$value ) {
    	
    		if( $value == '' ) {
    			
    			//unset( $data[$key] );
    		
    		}
    	
    	}    	
    
    	$this->theDB->insert($table, $data);
    
    	
    	//update the ownership table	
    	$newRecordID = $this->theDB->insert_id();
    	
    	$user = $this->ion_auth->user()->row();
    	
    	$data = array(
    		'dbapp_users_records_userid' => $user->id,
    	   	'dbapp_users_records_database' => $db,
    	   	'dbapp_users_records_table' => $table,
    	   	'dbapp_users_records_recordid' => $newRecordID
    	);
    	
    	$this->db->insert('dbapp_users_records', $data); 
    
    }
    
    
    /*
    	deletes a record from the given table in the given db
    */
    
    public function deleteRecord($db, $table, $recordID)
    {
    
    	//get the primary key for this table
    	
    	$this->tablemodel->initialize($db);
    	    	
    	$field = $this->tablemodel->getPrimaryKey($table);
    	
    	
    	//if there's any foreign keys pointing to this value, we'll need to destroy 
    	
    	$config['hostname'] = $this->db->hostname;
    	$config['username'] = $this->db->username;
    	$config['password'] = $this->db->password;
    	$config['database'] = "information_schema";
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
    	
    	$this->theDB2 = $this->load->database($config, TRUE);
    	
    	$query = $this->theDB2->query("SELECT *
    	FROM
    	  KEY_COLUMN_USAGE
    	WHERE
    	  REFERENCED_TABLE_NAME = '$table'
    	  AND REFERENCED_COLUMN_NAME = '".$field->name."'
    	  AND TABLE_SCHEMA = '$db';");
    	
    	foreach( $query->result() as $row ) {
    	
    		//this ought to be recursive
    		
    		$field2 = $this->tablemodel->getPrimaryKey($row->TABLE_NAME);
    		
    		$query2 = $this->theDB2->query("SELECT *
    		FROM
    		  KEY_COLUMN_USAGE
    		WHERE
    		  REFERENCED_TABLE_NAME = '".$row->TABLE_NAME."'
    		  AND REFERENCED_COLUMN_NAME = '".$field2->name."'
    		  AND TABLE_SCHEMA = '$db';");
    		      		    		  
    		foreach( $query2->result() as $row2 ) {
    		
    			$referencingTable = $row2->TABLE_NAME;
    			$referencingColumn = $row2->COLUMN_NAME;
    			
    			//get referencing ID's
    			
    			$q = $this->theDB->from($row->TABLE_NAME)->where($row->COLUMN_NAME, $recordID)->get();
    			
    			foreach( $q->result_array() as $r ) {
    			
    				$this->theDB->where($referencingColumn, $r[$referencingColumn]);
    				$this->theDB->delete($referencingTable);
    			
    			}
    			    		
    		}
    		    	    		
    		$this->theDB->where($row->COLUMN_NAME, $recordID);
    		$this->theDB->delete($row->TABLE_NAME); 
    	
    	}
    	    	
    	/*
    	$relations = $this->db->from('dbapp_relations')->where('dbapp_relations_database', $db)->where('dbapp_relations_reference_table', $table)->where('dbapp_relations_reference_field', $field->name)->get();
    	
    	
    	if( $relations->num_rows() > 0 ) {
    	
    		//we've got an FK, double check
    		if( $this->tablemodel->hasFK( $relations->row()->dbapp_relations_source_table, $relations->row()->dbapp_relations_source_field ) ) {
    		
    			//we can't have any referencing values pointing this the record to be deleted, do we have any?
    			
    			
    			$query = $this->theDB->from($relations->row()->dbapp_relations_source_table)->where($relations->row()->dbapp_relations_source_field, $recordID)->get();
    			
    			//die( $this->theDB->last_query() );
    			    			
    			if( $query->num_rows() > 0 ) {
    			    			
    				//ok, we have some records with the value to be deleted, we'll need to fix that up
    				
    				//get the default value for this problem records
    				
    				$q = $this->theDB->query("SHOW FULL COLUMNS FROM `".$relations->row()->dbapp_relations_source_table."`");
    				
    				foreach( $q->result() as $row ) {
    				
    					if( $row->Field == $relations->row()->dbapp_relations_source_field ) {
    					
    						$default = $row->Default;
    					
    					}
    				
    				}
    				
    				//we'll need to make sure the default for this column is a valid ID for the referenced table
    				
    				$q = $this->theDB->from($relations->row()->dbapp_relations_reference_table)->where($relations->row()->dbapp_relations_reference_field, $default)->get();
    				    				    				
    				if( $q->num_rows() > 0 ) {
    					
    					//this value can be used!
    					
    					$data = array(
    						$relations->row()->dbapp_relations_source_field => $default
    					);
    				
    				} else {
    				
    					//we cant use the default value, so we'll go for the next best thing
    					    					
    					$val = $this->tablemodel->getKeyValue($relations->row()->dbapp_relations_reference_table, $recordID);
    					
    					$data = array(
    						$relations->row()->dbapp_relations_source_field => $val
    					);
    					    					    					    				
    				}
    				
    				$this->theDB->where($relations->row()->dbapp_relations_source_field, $recordID);
    				$this->theDB->update($relations->row()->dbapp_relations_source_table, $data);
    				    			
    			}
    		
    		}
    	
    	}
    	*/
    	
    	//destroy possible FKs
    	$this->tablemodel->destroyForeignKey($db, $table, $field->name);
    	
    
    	$this->theDB->where($field->name, $recordID);
    	$this->theDB->delete($table);
    	
    	
    	//delete from dbapp_cellrevisions
    	$this->db->where("dbapp_cellrevisions_database", $db);
    	$this->db->where("dbapp_cellrevisions_table", $table);
    	$this->db->where("dbapp_cellrevisions_indexname", $field->name);
    	$this->db->where("dbapp_cellrevisions_indexvalue", $recordID);
    	$this->db->delete("dbapp_cellrevisions");
    	
    	
    	//delete from dbapp_recordnotes
    	$this->db->where("dbapp_recordnotes_database", $db);
    	$this->db->where("dbapp_recordnotes_table", $table);
    	$this->db->where("dbapp_recordnotes_indexname", $field->name);
    	$this->db->where("dbapp_recordnotes_indexvalue", $recordID);
    	$this->db->delete("dbapp_recordnotes");
    	
    	
    	//delete from dbapp_users_records
    	$this->db->where("dbapp_users_records_table", $table);
    	$this->db->where("dbapp_users_records_database", $db);
    	$this->db->where("dbapp_users_records_recordid", $recordID);
    	$this->db->delete("dbapp_users_records");
    
    }
    
    
    /*
    	takes a database and makes sure it's ok for usage with the app
    */
    
    public function checkDB($db)
    {	
		
		$disallowedCharacters = '/[\'^£$%&*()}{@#~?><>,|=+¬\/ ]/';
		
		//check db name for non alpha characters
		if( preg_match($disallowedCharacters, $db) ) {
			
			return false;
			
		}
		
           	    	
    	//manual dynamic database connection
    	$config['hostname'] = $this->db->hostname;
    	$config['username'] = $this->db->username;
    	$config['password'] = $this->db->password;
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
		
		
    	
    	$this->theNewDB = $this->load->database($config, TRUE);
    	
    	//get all tables
    	
    	$tables = $this->theNewDB->list_tables();
    	
    	foreach($tables as $table) {
    	
    		//does the table have a primary key?
    		$query = $this->theNewDB->query("SHOW INDEXES FROM `$table` WHERE Key_name = 'PRIMARY'");
    		
    		if( $query->num_rows() > 0 ) {
    			
				//check table name for non alpha characters
				if( preg_match($disallowedCharacters, $table) ) {
			
					return false;
			
				} else {//so far, so good
					
					//check column names
					
					$fields = $this->theNewDB->list_fields( $table );
					
					foreach ($fields as $field) {
						
						if( preg_match($disallowedCharacters, $field) ) {
							
							return false;
						
					   	}
					
					}
					
				}
    		
    		} else {
    		
    			//die($table);
    		
    			return false;
    		
    		}
    		
    		
    		//are all tables innodb?
    		/*$query = $this->theNewDB->query("SHOW TABLE STATUS WHERE Name = '$table'");
    		
    		$row = $query->result()[0];
    		
    		if( $row->Engine != "InnoDB" ) {
    		
    			return false;
    		
    		}*/
    		    	
    	}
    	
    	return true;
    	
    }
    
    
    /*
    	adds db to app
    */
    
    public function addToDBAPP($db)
    {
    	
    	$db = strtolower($db);
    
    	$data = array(
    	   'dbapp_databases_database' => $db
    	);
    	
    	$this->db->insert('dbapp_databases', $data);
    	
    	return $this->db->insert_id();
    
    }
    
    
    /*
    	removes a DB from DBAPP (does NOT delete the database itself)
    */
    
    public function removeFromDBAPP($db)
    {
    
    	$this->db->where('dbapp_databases_database', $db);
    	$this->db->delete('dbapp_databases'); 
    
    }
    
    
    /*
    	creates a new database
    */
    
    public function createDB($db)
    {
    
    	$db = strtolower($db);
		
		//$this->db->query('SET collation_connection = utf8_unicode_ci');
		//$this->db->query('SET NAMES utf8');
    
    	$this->db->query("CREATE DATABASE `$db` CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    	
    	//set default engine
    	$this->db->query('SET storage_engine=INNODB');
    
    }
    
    
    /*
    	deletes a database from the server
    */
    
    public function deleteDB($db)
    {
    
    	$this->db->query("drop database `$db`");
    	
    	
    	//delete from dbapp_databases table
    	$this->db->where('dbapp_databases_database', $db);
    	$this->db->delete('dbapp_databases'); 
    	
    	
    	//delete from dbapp_cellrevisions
    	$this->db->where('dbapp_cellrevisions_database', $db);
    	$this->db->delete('dbapp_cellrevisions');
    	
    	
    	//delete from dbapp_columnnotes
    	$this->db->where('dbapp_columnnotes_database', $db);
    	$this->db->delete('dbapp_columnnotes');
    	
    	
    	//delete from dbapp_recordnotes
    	$this->db->where('dbapp_recordnotes_database', $db);
    	$this->db->delete('dbapp_recordnotes');
    	
    	
    	//delete from dbapp_tablenotes
    	$this->db->where('dbapp_tablenotes_database', $db);
    	$this->db->delete('dbapp_tablenotes');
    	
    	
    	//delete from dbapp_columnrestrictions
    	$this->db->where('dbapp_columnrestrictions_database', $db);
    	$this->db->delete('dbapp_columnrestrictions');
    	
    	
    	//delete from dbapp_columnrestrictions
    	$this->db->where('dbapp_columnselect_database', $db);
    	$this->db->delete('dbapp_columnselect');
    
    }
    
    
    /*
    	checks if database exists
    */
    
    public function isUnique($dbname)
    {
    
    	$dbs = $this->listAllMySQL();
    	
    	foreach( $dbs as $db ) {
    	    	
    		if( $db['db'] == $dbname ) {
    		
    			return false;
    		
    		}
    	
    	}
    	
    	return true;
      
    }
    
    
    /*
    	checks if a database exists
    */
    
    public function exists($dbname)
    {
    
    	$q = $this->db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");
    	
    	if( $q->num_rows() > 0 ) {
    	
    		return true;
    	
    	} else {
    	    	
    		return false;
    	
    	}
    
    	/*$dbs = $this->listAllMySQL();
    	
    	foreach( $dbs as $db ) {
    	    	
    		if( $db['db'] == $dbname ) {
    		
    			return true;
    		
    		}
    	
    	}
    	
    	return false;*/
      
    }
    
}