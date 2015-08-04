<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TableModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('ion_auth');
        $this->load->model('usermodel');
        $this->load->model('rolemodel');
        
        if(!$this->ion_auth->logged_in()) {
        	
        	redirect('/login');
        
        }
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
    	lists all tables within a database
    */
    
    public function listAll() 
   	{
        
    	$tables = $this->theDB->list_tables();
    	    	    		
    	sort($tables);
    	    	
    	$tables_new = array();
    	    	
    	foreach ($tables as $table)
    	{
    	   	    	   	
    	   	//exlclude dbapp tables
    	   	if (strpos($table,'dbapp') === false && $this->usermodel->hasTablePermission("select", $this->theDBname, $table)) {
    	   	    $temp = array();
    	   	    $temp['table'] = $table;
    	   	    
    	   	    //$temp['rows'] = $this->theDB->get($table)->num_rows();
    	   	    
    	   	   	array_push($tables_new, $temp); 
    	   	}
    	   	
    	}
    	    	    	    	    	
    	$this->theDB->close();
    	    	
    	return $tables_new;
    
    }
    
    
    /*
    	returns all tables given a database name
    */
    
    public function listAllFor($db) 
    {
    
    	//connect to $db database
    	
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
    	
    	$tables = $this->theDB->list_tables();
    	
    	$this->theDB->close();
    	
    	return $tables;
    
    }
    
    
    /*
    	list all tables plus columns in array
    */
    
    public function tablesPlusColumns($db)
    {
    
    	$tables = $this->theDB->list_tables();
    	
    	$all = array();
    	
    	foreach ($tables as $table) {
    	    	
    		//only do this table if the user has access to it
    		
    		if( $this->usermodel->hasTablePermission('select', $db, $table) ) {
    		    	
    			$tableArray = array();
    	    	
    	   		$fields = $this->theDB->field_data($table);
    	   	
    	   		foreach ($fields as $field) {
    	   	    	   		
    	   			$fieldArray = array();
    	   		
    	   	 	 	$fieldArray['field'] = $field->name;
    	   	   		$fieldArray['type'] = $field->type;
    	   	   		$fieldArray['max_length'] = $field->max_length;
    	   	   		$fieldArray['primary_key'] = $field->primary_key;
    	   	   	
    	   	   		array_push($tableArray, $fieldArray);
    	   		}
    	   	
    	   		$all[$table] = $tableArray;
    	   	
    	   	}
    	
    	}
    	
    	return $all;
    
    }
    
    
    /*
    	returns all fields in a given table
    */
    
    public function getFieldsFor($table) 
    {
        
    	$fields = $this->theDB->field_data($table);
    	
    	$return = array();
    	
    	foreach($fields as $field) {
    	
    		$temp = array();
    		$temp['field'] = $field->name;
    		$temp['type'] = $field->type;
    		$temp['max_length'] = $field->max_length;
    		
    		
    		$indexation = $this->theDB->query("SHOW KEYS FROM `$table`")->result();
    		
    		foreach($indexation as $index) {
    		
    			if($index->Key_name == "PRIMARY" && $index->Column_name == $field->name) {
    			
    				$temp['index'] = 'primary';
    				
    				break;
    			
    			} elseif($index->Column_name == $field->name && $index->Non_unique == 0) {
    			
    				$temp['index'] = 'unique';
    				
    				break;
    			
    			} elseif($index->Column_name == $field->name && $index->Non_unique == 1) {
    			
    				$temp['index'] = 'index';
    				
    				break;
    			
    			} 
    		
    		}
    		
    		if( !isset($temp['index']) ) {
    			
    			$temp['index'] = 'none';
    		
    		}
    		
    		
    		//select field?
    		
    		$query = $this->db->from('dbapp_columnselect')->where('dbapp_columnselect_database', $this->theDB->database)->where('dbapp_columnselect_table', $table)->where('dbapp_columnselect_column', $field->name)->get();
    		
    		//die( $this->db->last_query() );
    		
    		if( $query->num_rows() > 0 ) {
    		
    			$temp['type'] = "select";
    		
    		}
    		
    		
    		array_push($return, $temp);
    	
    	}
    	
    	$this->theDB->close();
    	    	
    	return $return;
    
    }
    
    
    /*
    	returns all fields incl foreign key data
    */
    
    public function getFieldsFK($db, $table)
    {
    	
    	$columns = $this->theDB->field_data($table);
    	
    	$return = array();
    	    	
    	foreach($columns as $col) {
    	
    		$temp = array();
    		$temp['field'] = $col->name;
    		$temp['type'] = $col->type;
    		$temp['max_length'] = $col->max_length;	
    		
    		//grab the relation from the db
    		
    		if( $this->tablemodel->hasFK($table, $col->name) ) {
    		    		
    			$relation = $this->db->from('dbapp_relations')->where('dbapp_relations_database', $db)->where('dbapp_relations_source_table', $table)->where('dbapp_relations_source_field', $col->name)->get()->row();
    			
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
    		
    		$temp['additional_data'] = $this->getColumnDetails($db, $table, $col->name);
    		
    		
    		array_push($return, $temp);
    	
    	}
    	
    	$this->theDB->close();
    	    	
    	return $return;
    
    }
    
    
    /*
    	returns the number of fields in given table
    */
    
    public function nrOfFields($table)
    {
    
    	$query = $this->theDB->get($table);
    
    	return $query->num_rows();
    	    
    }
    
    
    /*
    	updates a record in a database
    */
    
    public function updateField($field, $value, $indexName, $index, $table) 
    {
    
    	//did the value actually change? If not, no action is needed
    	
    	$tempp = $this->theDB->from($table)->select($field)->where($indexName, $index)->get()->result_array();
    	
    	if($value != $tempp[0][$field]) {
    
    		$data = array(
    	   		$field => $value
    		);
    	
    		$this->theDB->where($indexName, $index);
    		$this->theDB->update($table, $data);
    	
    		$this->theDB->close();
    	
    	}
    
    }
    
    
    /*
    	returns the primary key for a given table
    */
    
    public function getPrimaryKey($table) 
    {
    
    	$fields = $this->theDB->field_data($table);
    	
    	$return = array();
    	
    	foreach($fields as $field) {
    	
    		if($field->primary_key == 1) {
    		
    			return $field;
    		
    		}
    	}
    	    	
    	return false;
    
    }
    
    
    /*
    	checks if value for primary key already exists
    */
    
    public function primaryAllowed($table, $primaryKey, $val)
    {
    
    	$query = $this->theDB->from($table)->where($primaryKey, $val)->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		return false;
    	
    	} else {
    	
    		return true;
    	
    	}
    
    }
    
    
    /*
    	returns a valid value for the primary key of the table
    */
    
    public function getKeyValue($table, $not = '')
    {
    	
    	//get the primary key
    	
    	$tempp = $this->getPrimaryKey($table);
    	
    	$keyName = $tempp->name;
    	
    	if( $not != '' ) {
    	
    		//exclude $not
    		
    		foreach( $this->theDB->get($table)->result() as $row ) {
    		
    			if( $row->$keyName != $not ) {
    			
    				return $row->$keyName;
    			
    			}
    		
    		}
    	
    	} else {
    	
    		$tempp = $this->theDB->get($table)->result();
    
    		$row = $tempp[0];
    		return $row->$keyName;
    	
    	}
    
    }
    
    
    
    /*
    	returns foreign key for column or false if none exists
    */
    
    public function getForeignKey($db, $table, $column)
    {
    
    	$query = $this->theDB->query("select *, concat(table_name, '.', column_name) as 'foreign key',  
    	    concat(referenced_table_name, '.', referenced_column_name) as 'references', CONSTRAINT_NAME as constraint_name from information_schema.key_column_usage where
    	    referenced_table_name is not null && constraint_schema = '$db' && table_name = '$table' && column_name = '$column'");
			
		    	    
    	//die($this->theDB->last_query());
    	
    	//echo $this->theDB->last_query()";
    
    	if( $query->num_rows() > 0 ) {
			
			//die( $this->theDB->last_query() );
    	
    		$tempp = $query->result();
    	
    		$res = $tempp[0];
    	
    		$temp = array();
    		$temp['foreign_key'] = $res->references;
    		$temp['constraint_name'] = $res->constraint_name;
			$temp['referenced_table'] = $res->REFERENCED_TABLE_NAME;
			$temp['referenced_field'] = $res->REFERENCED_COLUMN_NAME;
			$temp['referencing_field'] = $res->COLUMN_NAME;
    		
    		//get some other details
    		
    		$query = $this->db->from('dbapp_relations')->where('dbapp_relations_database', $db)->where('dbapp_relations_source_table', $table)->where('dbapp_relations_source_field', $column)->get();
    		
    		//echo $this->db->last_query();
    		
    		if( $query->num_rows() > 0 ) {
    		
    			$tempp = $query->result();
    		
    			$res = $tempp[0];
				
    			$temp['use_column'] = $res->dbapp_relations_reference_use;
    		
    		} else {//no use column specified, use the primary key from the referenced table
    			
				$temp['use_column'] = $temp['referenced_field'];
				
    		}
    		
    		//die("array");
    		    			
    		return $temp;
    	
    	} else {
    	
    		//die("false");
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	checks wether a foreign key is set for this db/column
    */
    
    public function hasFK($table, $column)
    {
    
    	$query = $this->db->query("select concat(table_name, '.', column_name) as 'foreign key',  
    		    concat(referenced_table_name, '.', referenced_column_name) as 'references', CONSTRAINT_NAME as constraint_name from information_schema.key_column_usage where
    		    referenced_table_name is not null && table_name = '$table' && column_name = '$column'");
    	
    	if( $query->num_rows() > 0 ) {
    		
    		return true;
    		
    	} else {
    	    		
    		return false;
    		
    	}
    
    }
    
    
    /*
    	returns an array of tables referencing the given table
    */
    
    public function getReferencingTables($db, $table)
    {
    	
    	$query = $this->db->query("select REFERENCED_TABLE_NAME from information_schema.key_column_usage where
    	    referenced_table_name is not null && table_name = '$table' && table_schema = '$db'");
    	    
    	        	    
		if( $query->num_rows() > 0 ) {
		
			$return = array();
			
			foreach( $query->result() as $row ) {
			
				array_push($return, $row->REFERENCED_TABLE_NAME);
			
			}
						
			return $return;
		
		} else {
		
			return false;
		
		}
    
    }
    
    
    
    /*
    	returns possible referenced tables + columns
    */
    
    public function getReferencedTables($db, $table)
    {
    
    	$query = $this->db->query("select * from information_schema.key_column_usage where
    	    referenced_table_name is not null && referenced_table_name = '$table' && table_schema = '$db'");
    	    
    	
    	
    	if( $query->num_rows() > 0 ) {
    	
    		$return = array();
    		
    		foreach( $query->result() as $row ) {
    		
    			$temp = array();
    			
    			$temp['table'] = $row->TABLE_NAME;
    			$temp['column'] = $row->COLUMN_NAME;
    		
    			array_push($return, $temp);
    		
    		}
    					
    		return $return;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	takes a source table/column and referenced table and makes sure a foreign key can be setup
    */
    
    public function fixForForeignKey($sourceTable, $sourceColumn, $referencedTable)
    {
    	    	
    	$sourcedTablePrimaryKey = $this->getPrimaryKey($sourceTable)->name;
    	$referencedTablePrimaryKey = $this->getPrimaryKey($referencedTable)->name;
    
    	$query = $this->theDB->query("select `$sourceTable`.`$sourcedTablePrimaryKey` from `$sourceTable` left join `$referencedTable` on `$sourceTable`.`$sourceColumn` = `$referencedTable`.`$referencedTablePrimaryKey` where `$referencedTable`.`$referencedTablePrimaryKey` is null;");
    	
    	//update
    	
    	foreach( $query->result() as $row ) {
    	
    		$ID = $row->$sourcedTablePrimaryKey;
    		
    		$data = array(
    			$sourceColumn => $this->getKeyValue($referencedTable)
    		);
    		
    		$this->theDB->where($sourcedTablePrimaryKey, $ID);
    		$this->theDB->update($sourceTable, $data); 
    	
    	}
    
    }
    
    
    
    /*
    	removes a foreign key if it exists
    */
    
    public function destroyForeignKey($db, $table, $column)
    {
    
    	$fk = $this->getForeignKey($db, $table, $column);
    	
    	if( $fk ) {
    	
    		$this->theDB->query("alter table `$table` drop foreign key ".$fk['constraint_name']);
    		
    		//delete from dbapp_relations
    		
    		$this->db->where('dbapp_relations_database', $db);
    		$this->db->where('dbapp_relations_source_table', $table);
    		$this->db->where('dbapp_relations_source_field', $column);
    		$this->db->delete('dbapp_relations'); 
    	
    	}
    
    }
    
    
    /*
    	returns an array with column restrictions or false if non-existent
    */
    
    public function getColumnRestrictions($db, $table, $column, $type = 'array')
    {
    
    	$query = $this->db->from('dbapp_columnrestrictions')->where('dbapp_columnrestrictions_database', $db)->where('dbapp_columnrestrictions_table', $table)->where('dbapp_columnrestrictions_column', $column)->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		if( $type == 'array' ) {
    		
    			$temp = $query->result();
    	
    			$restrictionString = $temp[0]->dbapp_columnrestrictions_restrictions;
    	
    			$restrictions = explode("|", $restrictionString);
    	
    			return $restrictions;
    		
    		} else {
    		
    			$temp = $query->result();
    			
    			return $temp[0]->dbapp_columnrestrictions_restrictions;
    		
    		}
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	returns details for a given column
    */
    
    public function getColumnDetails($db, $table, $column)
    {
    
    	$fields = $this->theDB->field_data($table);
    	
    	$columnDetails = array();//new array to contain the column details
    	
    	
    	//default data provided by codeigniter
    	foreach ($fields as $field) {
    	
    		if($field->name == $column) {
    	
    	   		$columnDetails['name'] = $field->name;
    	   		$columnDetails['type'] = $field->type;
    	   		$columnDetails['max_length'] = $field->max_length;
    	   		$columnDetails['primary_key'] = $field->primary_key;
    	   
    	   }
    	
    	}
    	
    	//does the column exist?
    	
    	if( !isset($columnDetails['name']) ) {
    	
    		return false;
    	
    	}
    	
    	
    	//grab the default value
    	
    	$tempp = $this->theDB->query("SELECT COLUMN_DEFAULT FROM information_schema.columns WHERE TABLE_SCHEMA = '$db' AND TABLE_NAME = '$table' AND COLUMN_NAME = '$column'")->result();
    	
    	$columnDetails['default'] = $tempp[0]->COLUMN_DEFAULT;
    	
    	
    	//index?
    	
    	$indexation = $this->theDB->query("SHOW KEYS FROM `$table`")->result();
    	
    	foreach($indexation as $index) {
    	
    		if($index->Key_name == "PRIMARY" && $index->Column_name == $column) {
    		
    			$columnDetails['index'] = 'primary';
    			
    			//check if the column has auto_increment set
    			
    			$query = $this->db->query("SELECT *
    			FROM INFORMATION_SCHEMA.COLUMNS
    			WHERE TABLE_NAME = '$table'
    			    AND COLUMN_NAME = '$column'
    			    AND DATA_TYPE = 'int'
    			    AND COLUMN_DEFAULT IS NULL
    			    AND IS_NULLABLE = 'NO'
    			    AND EXTRA like '%auto_increment%'");
    			    
    			 if( $query->num_rows() > 0 ) {
    			 
    			 	$columnDetails['auto_increment'] = '';
    			 
    			 }
    			
    			break;
    		
    		} elseif($index->Column_name == $column && $index->Non_unique == 0) {
    		
    			$columnDetails['index'] = 'unique';
    			
    			break;
    		
    		} elseif($index->Column_name == $column && $index->Non_unique == 1) {
    		
    			$columnDetails['index'] = 'index';
    			
    			break;
    		
    		} 
    	
    	}
    	
    	if( !isset($columnDetails['index']) ) {
    		
    		$columnDetails['index'] = 'none';
    	
    	}
    	
    	//foreign keys?
    	if( $this->getForeignKey($db, $table, $column) ) {
    	
    		$columnDetails['foreign_key'] = $this->getForeignKey($db, $table, $column);
    	
    	}
    	
    	
    	//is this an option column?
    	
    	$query = $this->db->from('dbapp_columnselect')->where('dbapp_columnselect_database', $db)->where('dbapp_columnselect_table', $table)->where('dbapp_columnselect_column', $column)->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		$temp = $query->result();
    	
    		$columnDetails['select'] = $temp[0]->dbapp_columnselect_values;
    	
    	}
    	
    	
    	//finally, the column offset
    	
    	$allColumns = $this->theDB->list_fields($table);
    	
    	$c = 0;
    	
    	foreach($allColumns as $field) {
    	
    		if($field == $column) {
    	   
    	   		$columnDetails['offset'] = $c;
    	   		
    	   		break;
    	   
    	   	}
    	   	
    	   	$c++;
    	
    	}
    	
    	//print_r($columnDetails);
    	
    	//die('');
    	
    	return $columnDetails;
    
    }
    
    
    /*
    	updates a table, name only for now
    */
    
    public function updateTable($db, $table, $data)
    {
    
    	//change table name first
    	
    	$this->theDB->query("RENAME TABLE `$table` TO `".$data['tableName']."`");
    	
    	
    	//update some dbapp stuff
    	
    	//first dbapp_cellrevisions
    	
    	$udata = array(
    		'dbapp_cellrevisions_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_cellrevisions_database', $db);
    	$this->db->where('dbapp_cellrevisions_table', $table);
    	
    	$this->db->update('dbapp_cellrevisions', $udata);
    	
    	
    	//next, dbapp_columnnotes
    	
    	$udata = array(
    		'dbapp_columnnotes_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_columnnotes_database', $db);
    	$this->db->where('dbapp_columnnotes_table', $table);
    	
    	$this->db->update('dbapp_columnnotes', $udata);
    	
    	
    	//next, dbapp_record notes
    	
    	$udata = array(
    		'dbapp_recordnotes_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_recordnotes_database', $db);
    	$this->db->where('dbapp_recordnotes_table', $table);
    	
    	$this->db->update('dbapp_recordnotes', $udata);
    	
    	
    	//next, dbapp_tablenotes
    	
    	$udata = array(
    		'dbapp_tablenotes_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_tablenotes_database', $db);
    	$this->db->where('dbapp_tablenotes_table', $table);
    	
    	$this->db->update('dbapp_tablenotes', $udata);
    	
    	//next: dbapp_relations
    	
    	$udata = array(
    		'dbapp_relations_source_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_relations_database', $db);
    	$this->db->where('dbapp_relations_source_table', $table);
    	
    	$this->db->update('dbapp_relations', $udata);
    	
    	
    	//dbapp_relations once more
    	
    	$udata = array(
    		'dbapp_relations_reference_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_relations_database', $db);
    	$this->db->where('dbapp_relations_reference_table', $table);
    	
    	$this->db->update('dbapp_relations', $udata);
    	
    	
    	//dbapp_columnrestrictions
    	
    	$udata = array(
    		'dbapp_columnrestrictions_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_columnrestrictions_database', $db);
    	$this->db->where('dbapp_columnrestrictions_table', $table);
    	
    	$this->db->update('dbapp_columnrestrictions', $udata);
    	
    	
    	//dbapp_columnselect
    	
    	$udata = array(
    		'dbapp_columnselect_table' => $data['tableName']
    	);
    	
    	$this->db->where('dbapp_columnselect_database', $db);
    	$this->db->where('dbapp_columnselect_table', $table);
    	
    	$this->db->update('dbapp_columnselect', $udata);
    	
    	
    	//update group permissions
    	
    	$groups = $this->db->get('dbapp_groups')->result();
    	    	    	
    	foreach( $groups as $group ) {
    	
    		if( $group->id > 1 ) {//no need to do this for admins
    	
    			$groupPermissions = json_decode($group->permissions, true);
    			
    			foreach( $groupPermissions as $database=>$perms ) {
    			
    				if( isset( $groupPermissions[$database][$table] ) ) {
    					
    					//save the permissions temporarily
    					
    					$temp = $groupPermissions[$database][$table];
    					
    					unset( $groupPermissions[$database][$table] );
    					
    					//put in the permissions under the new table name
    					
    					$groupPermissions[$database][$data['tableName']] = $temp;
    					
    					//update the dbapp_groups table
    					
    					$udata = array(
    						'permissions' => json_encode($groupPermissions)
    					);
    					
    					$this->db->where('id', $group->id);
    					
    					$this->db->update('dbapp_groups', $udata);
    					
    					
    					//now, we'll need to update the MySQL permissions for each user in this group
    					
    					$users = $this->db->from('dbapp_users_groups')->join('dbapp_users', 'dbapp_users_groups.user_id = dbapp_users.id')->where('group_id', $group->id)->get();
    					
    					if( $users->num_rows() > 0 ) {
    					
    						foreach( $users->result() as $user ) {
    						
    							$this->rolemodel->applyPermissions($groupPermissions, $user->mysql_user);
    						        					    					
    						}
    					
    					}
    				
    				}
    			
    			}
    			
    		}
    	
    	}
    	
    	
    	//update private tables if any
    	
    	$users = $this->db->get('dbapp_users')->result();
    	
    	foreach( $users as $user ) {
    	
    		if( $user->tables != '' ) {
    	
    			$tables = json_decode($user->tables, true);
    		    		
    			foreach( $tables as $key=>$t ) {
    		
    				if( $t == $db.".".$table ) {
    			
    					unset( $tables[$key] );
    				
    					array_push($tables, $db.".".$data['tableName']);
    					
    					$udata = array(
    						'tables' => json_encode($tables)
    					);
    					
    					$this->db->where('id', $user->id);
    					
    					$this->db->update('dbapp_users', $udata);
    					
    					
    					//permission stuff
    					
    					//revoke for all table
    					$this->db->query("REVOKE ALL PRIVILEGES  ON `$db`.`$table` FROM '".$user->mysql_user."'@'".$this->db->hostname."'");
    					
    					//right for new table
    					$this->db->query("GRANT ALL ON `".$db."`.`".$data['tableName']."` TO '".$user->mysql_user."'@'".$this->db->hostname."'");
    					
    					$this->db->query("GRANT INSERT ON `".$db."`.* TO '".$user->mysql_user."'@'".$this->db->hostname."'");
    		    			
    				}
    		
    			}
    		
    		}
    	
    	}
    	    	    
    }
    
    
    /*
    	updates column details
    */
    
    public function updateColumn($db, $table, $column, $data)
    {
		
		
		
    	//get the details for this column
    	
    	$columnDetails = $this->getColumnDetails($db, $table, $column);
		    	
    	$columnDetailsUpdated = $columnDetails;
		    
    	//change the column name?
    	if( $column != $data['columnName'] ) {
			    	    	
    		//we'll need to destroy possible FKs before we change the name, if any FK exists and gets dropped, it will recreated automatically further down this function
    		
    		if( $this->hasFK($table, $column) ) {
    		
    			$this->destroyForeignKey($db, $table, $column);
    		
    		}
    		
    	
    		if($columnDetails['max_length'] != '') {
    		
    			$this->theDB->query("ALTER TABLE `$table` CHANGE `$column` `".$data['columnName']."` ".$columnDetails['type']."(".$columnDetails['max_length'].")");
    			    			    		
    		} else {
    	
    			$this->theDB->query("ALTER TABLE `$table` CHANGE `$column` `".$data['columnName']."` ".$columnDetails['type']);
    		
    		}
    		
    		
    		$columnDetailsUpdated['name'] = $data['columnName'];
    		
    		//column names are used to store notes and revisions as well, so we'll need to make some more updates to the db
    		
    		//first up: dbapp_cellrevisions
    		
    		$udata = array(
    			'dbapp_cellrevisions_field' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_cellrevisions_field', $columnDetails['name']);
    		$this->db->where('dbapp_cellrevisions_database', $db);
    		$this->db->where('dbapp_cellrevisions_table', $table);
    		
    		$this->db->update('dbapp_cellrevisions', $udata);
    		
    		
    		$udata = array(
    			'dbapp_cellrevisions_indexname' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_cellrevisions_indexname', $columnDetails['name']);
    		$this->db->where('dbapp_cellrevisions_database', $db);
    		$this->db->where('dbapp_cellrevisions_table', $table);
    		
    		$this->db->update('dbapp_cellrevisions', $udata);
    	
    		
    		//next: dbapp_columnnotes
    		
    		$udata = array(
    			'dbapp_columnnotes_field' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_columnnotes_field', $columnDetails['name']);
    		$this->db->where('dbapp_columnnotes_database', $db);
    		$this->db->where('dbapp_columnnotes_table', $table);
    		
    		$this->db->update('dbapp_columnnotes', $udata);
    		
    		
    		//next: dbapp_recordnotes
    		
    		$udata = array(
    			'dbapp_recordnotes_indexname' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_recordnotes_indexname', $columnDetails['name']);
    		$this->db->where('dbapp_recordnotes_database', $db);
    		$this->db->where('dbapp_recordnotes_table', $table);
    		
    		$this->db->update('dbapp_recordnotes', $udata);
    		
    		
    		//next: dbapp_relations
    		$udata = array(
    			'dbapp_relations_source_field' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_relations_database', $db);
    		$this->db->where('dbapp_relations_source_table', $table);
    		
    		$this->db->update('dbapp_relations', $udata);
    		
    		
    		//dbapp_relations again
    		$udata = array(
    			'dbapp_relations_reference_field' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_relations_database', $db);
    		$this->db->where('dbapp_relations_reference_table', $table);
    		
    		$this->db->update('dbapp_relations', $udata);
    		
    		
    		//dbapp_columnrestrictions
    		$udata = array(
    			'dbapp_columnrestrictions_column' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_columnrestrictions_database', $db);
    		$this->db->where('dbapp_columnrestrictions_table', $table);
    		
    		$this->db->update('dbapp_columnrestrictions', $udata);
    		
    		
    		//dbapp_columnselect
    		$udata = array(
    			'dbapp_columnselect_column' => $data['columnName']
    		);
    		
    		$this->db->where('dbapp_columnselect_database', $db);
    		$this->db->where('dbapp_columnselect_table', $table);
    		
    		$this->db->update('dbapp_columnselect', $udata);
    		
    		
    		
    		//remove old column name from the session and add the new column name if previously registered
    		if( in_array($column, $this->session->userdata($db.".".$table)) ) {
    			
    			//old column was registered for view with the session
    			$theColumns = $this->session->userdata($db.".".$table);
    			
    			$this->session->unset_userdata($db.".".$table);
    			
    			//find the key for the column
    			$key = array_search ($column, $theColumns);
    			
    			//replace with the new column
    			$theColumns[$key] = $columnDetailsUpdated['name'];
    			
    			$this->session->set_userdata($db.".".$table, $theColumns);
    		
    		}
    	
    	}
    	
    	//change content type?
		
    	if( $columnDetails['type'] != $data['columnType'] ) {
			    	
    		if( $data['columnType'] == 'int' ) {
    			
    			$this->theDB->query("alter table `$table` modify `".$columnDetailsUpdated['name']."` int(11)");
    			
    			$columnDetailsUpdated['max_length'] = 11;
    		
    		} elseif( $data['columnType'] == 'double' ) {
    			
				$this->theDB->query("alter table `$table` modify `".$columnDetailsUpdated['name']."` double");
				
    		} elseif( $data['columnType'] == 'varchar' ) {
    		
    			$this->theDB->query("alter table `$table` modify `".$columnDetailsUpdated['name']."` varchar(255)");
    			
    			$columnDetailsUpdated['max_length'] = 255;
    		
    		} elseif( $data['columnType'] == 'text' ) {
    		
    			$this->theDB->query("alter table `$table` modify `".$columnDetailsUpdated['name']."` text");
    			
    			$columnDetailsUpdated['max_length'] = "";
    		
    		} elseif( $data['columnType'] == 'blob' ) {
    		
    			$this->theDB->query("alter table `$table` modify `".$columnDetailsUpdated['name']."` blob");
    			
    			$columnDetailsUpdated['max_length'] = "";
    		
    		} elseif( $data['columnType'] == 'date' ) {
    		
    			$this->theDB->query("alter table `$table` modify `".$columnDetailsUpdated['name']."` date");
    		
    		} elseif( $data['columnType'] == 'select' ) {
    		
    			$this->theDB->query("alter table `$table` modify `".$columnDetailsUpdated['name']."` varchar(255)");
    			
    			$columnDetailsUpdated['max_length'] = 255;
    		
    		}
    		
    		$columnDetailsUpdated['type'] = $data['columnType'];
    	
    	}
    	
    	unset($columnDetailsUpdated['select']);
    	
    	//delete possible select values
    	
    	$this->db->where('dbapp_columnselect_database', $db);
    	$this->db->where('dbapp_columnselect_table', $table);
    	$this->db->where('dbapp_columnselect_column', $columnDetailsUpdated['name']);
    	$this->db->delete('dbapp_columnselect');
    	
    	if( $data['columnType'] == 'select' ) {
    	
    		$optionArray = preg_split('/\n|\r/', $data['columnSelect'], -1, PREG_SPLIT_NO_EMPTY);
    		    		
    		$insertData = array(
    		   'dbapp_columnselect_database' => $db,
    		   'dbapp_columnselect_table' => $table,
    		   'dbapp_columnselect_column' => $columnDetailsUpdated['name'],
    		   'dbapp_columnselect_values' => json_encode($optionArray)
    		);
    		
    		$this->db->insert('dbapp_columnselect', $insertData);
    		
    		$columnDetailsUpdated['select'] = json_encode($optionArray);
    		$columnDetailsUpdated['type'] = "varchar";
    	
    	}
    	
    	
    	//change default value?
    	if( $columnDetails['default'] != $data['columnDefault'] ) {
    	    	
    		if($columnDetailsUpdated['max_length'] != '') {
    		    		
    			if($data['columnDefault'] == 'null' || $data['columnDefault'] == 'NULL') {
    			
    				$this->theDB->query("ALTER TABLE `$table` CHANGE `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']."( ".$columnDetailsUpdated['max_length']." ) NULL DEFAULT NULL");
    			
    			} else {
    		
    				$this->theDB->query("ALTER TABLE `$table` CHANGE `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']."( ".$columnDetailsUpdated['max_length']." ) NOT NULL DEFAULT '".$data['columnDefault']."'");
    			
    			}
    			
    			//die($this->theDB->last_query());
    		
    		} else {
    		    		
    			if($data['columnDefault'] == 'null' || $data['columnDefault'] == 'NULL') {
    			
    				$this->theDB->query("ALTER TABLE `$table` CHANGE `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']." NULL DEFAULT NULL");
    			
    			} else {
    			
    				$this->theDB->query("ALTER TABLE `$table` CHANGE `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']." NOT NULL DEFAULT '".$data['columnDefault']."'");
    		
    			}
    			
    		}
    		
    		$columnDetailsUpdated['default'] = $data['columnDefault'];
    	
    	}
        	    	
    	//change the index situation on this column?
    	if( isset($data['columnIndex']) && $data['columnIndex'] != '' && $columnDetails['index'] != $data['columnIndex'] ) {
						    	    	    	    	
    		//first drop whatever index is currently on this column
    		
    		$query = $this->theDB->query("SHOW INDEX FROM `$table` WHERE KEY_NAME = '".$columnDetailsUpdated['name']."'")->result();
    		
    		if( count($query) > 0 ) {//has an index
    		
    			$this->theDB->query("DROP INDEX `".$columnDetailsUpdated['name']."` ON `$table`");
    		
    		}
    		
    		//setup index if needed
    		if( $data['columnIndex'] == 'primary' ) {
    		
    			$this->theDB->query("ALTER TABLE `$table` ADD PRIMARY KEY ( `".$columnDetailsUpdated['name']."` )");
    			
    			$columnDetailsUpdated['index'] = "primary";
    		
    		} elseif( $data['columnIndex'] == 'unique' ) {
    		
    			$this->theDB->query("ALTER TABLE `$table` ADD UNIQUE ( `".$columnDetailsUpdated['name']."` )");
    			
    			$columnDetailsUpdated['index'] = "unique";
    		
    		} elseif( $data['columnIndex'] == 'index' ) {
    		
    			$this->theDB->query("ALTER TABLE `$table` ADD INDEX ( `".$columnDetailsUpdated['name']."` ) ");
    			
    			$columnDetailsUpdated['index'] = "index";
    		
    		} else {
    		
    			$columnDetailsUpdated['index'] = "";
    		
    		}
    		    	
    	}
    	
    	
    	//make sure a primary key INT column is always set to auto_increment
    	
    	if( $data['columnIndex'] == 'primary' && $data['columnType'] == 'int' ) {
    	
    		$this->theDB->query('ALTER TABLE `'.$table.'` MODIFY COLUMN `'.$columnDetailsUpdated['name'].'` INT auto_increment');
    	
    	}
    	
    	
    	//change the position of the column?
    	
    	$temp = $data['columnOffset'];
    	
    	$ttemp = explode("_", $temp);
    	
    	$newOffset = $ttemp[1];
    	    	
    	if( $columnDetails['offset'] != ($newOffset+1) ) {
    	    	    	    	
    		//get all fields
    		    		
    		$allFields = $this->getFieldsFor($table);
    		    		
    		if($columnDetailsUpdated['max_length'] != '') {
    		
    			if($data['columnDefault'] == 'null' || $data['columnDefault'] == 'NULL') {
    			
    				if( $newOffset == "-1" ) {
    				
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']."(".$columnDetailsUpdated['max_length'].") NULL DEFAULT NULL FIRST");
    				
    				} else {
    				
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']."(".$columnDetailsUpdated['max_length'].") NULL DEFAULT NULL AFTER ".$allFields[$newOffset]['field']);
    			
    				}
    			
    			} else {
    		
    				if( $newOffset == "-1" ) {
    					
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']."(".$columnDetailsUpdated['max_length'].") NOT NULL DEFAULT '".$data['columnDefault']."' FIRST");
    				
    				} else {
    		
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']."(".$columnDetailsUpdated['max_length'].") NOT NULL DEFAULT '".$data['columnDefault']."' AFTER ".$allFields[$newOffset]['field']);
    				
    				}
    			}
    		
    		} else {
    		
    			if($data['columnDefault'] == 'null' || $data['columnDefault'] == 'NULL') {
    			
    				if( $newOffset == "-1" ) {
    				
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']." NULL DEFAULT NULL FIRST");
    				
    				} else {
    			
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']." NULL DEFAULT NULL AFTER ".$allFields[$newOffset]['field']);
    				
    				}
    			
    			} else {
    			
    				if( $newOffset == "-1" ) {
    				
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']." NOT NULL DEFAULT '".$data['columnDefault']."' FIRST");
    				
    				} else {
    		
    					$this->theDB->query("ALTER TABLE `$table` CHANGE COLUMN `".$columnDetailsUpdated['name']."` `".$columnDetailsUpdated['name']."` ".$columnDetailsUpdated['type']." NOT NULL DEFAULT '".$data['columnDefault']."' AFTER ".$allFields[$newOffset]['field']);
    				
    				}
    		
    			}
    			
    		}
    		    		
    		$columnDetailsUpdated['offset'] = $newOffset;
    		    	    		    		    		    	
    	} else {
    	
    		$columnDetailsUpdated['offset'] = $columnDetails['offset'];
    	
    	}
    	
    	
    	
    	//set a foreign key?
    	
    	if( isset($data['connectTo']) && $data['connectTo'] != '' ) {
						
    		//if exists, destroy first
    		if( $this->hasFK($table, $column) ) {
    			    			
    			$this->destroyForeignKey($db, $table, $data['columnName']);
    			
    		}
    			
    		    		    		    		    		    		
    		//split up the value into table + column
    		$temp = explode(".", $data['connectTo']);
    				    			
    		$referenceTable = $temp[0];
    		$useColumn = $temp[1];
    				
    		//this will fix up messy values in the source column
    		$this->fixForForeignKey($table, $columnDetailsUpdated['name'], $referenceTable);
    				
    				
    		
    		$key = $this->getPrimaryKey($referenceTable)->name;
    		$fkey = "fk_".$columnDetailsUpdated['name']."_".$referenceTable."_".$key;
    		
    		$this->theDB->query("ALTER TABLE `$table` ADD CONSTRAINT $fkey FOREIGN KEY (`".$columnDetailsUpdated['name']."`) REFERENCES `".$referenceTable."`(`$key`) ON UPDATE CASCADE ON DELETE NO ACTION");
			
			//die( $this->theDB->last_query() );
    				    			    		
    		$temp = array();
    		$temp['foreign_key'] = $referenceTable.".".$key;
    		$temp['use_column'] = $useColumn;
    			
    		$columnDetailsUpdated['foreign_key'] = $temp;
    				
    		//add relation to database
    				
    		$this->load->model('relationmodel');
    				
    		//initialize db connection
    				
    		$this->relationmodel->initialize($db);
    				
    		$this->relationmodel->createNew($db, $table, $columnDetailsUpdated['name'], $referenceTable, $key, $useColumn);
    		
    	
    	} else {
    	
    		//remove foreign keys
    		
    		$this->destroyForeignKey($db, $table, $columnDetailsUpdated['name']);
    		    		
    		unset($columnDetailsUpdated['foreign_key']);
    	
    	}
    	
    	
    	//restrictions
    	
    	//delete old restrictions
    	$this->db->where('dbapp_columnrestrictions_database', $db);
    	$this->db->where('dbapp_columnrestrictions_table', $table);
    	$this->db->where('dbapp_columnrestrictions_column', $columnDetailsUpdated['name']);
    	$this->db->delete('dbapp_columnrestrictions'); 
    	
    	if( isset($data['restrictions']) && count($data['restrictions']) > 0 && isset($data['restrictions'][1]['restriction']) && $data['restrictions'][1]['restriction'] != '') {
    	    	
    		$restrictions = array();
    	
    		foreach( $data['restrictions'] as $reArray ) {
    		
    			$restriction = $reArray['restriction'];
    			
    			if( isset($reArray['value']) ) {
    				
    				if( $reArray['value'] == '' ) {
    				
    					$value = "10";
    				
    				} else {
    				
    					$value = $reArray['value'];
    				
    				}
    				
    				$restriction .= "[$value]";
    			
    			}
    			
    			array_push($restrictions, $restriction);
    		
    		}
    		
    		$restrictions = implode("|", $restrictions);
    		
    		//insert into database
    		$data = array(
    		   'dbapp_columnrestrictions_database' => $db,
    		   'dbapp_columnrestrictions_table' => $table,
    		   'dbapp_columnrestrictions_column' => $columnDetailsUpdated['name'],
    		   'dbapp_columnrestrictions_restrictions' => $restrictions
    		);
    		
    		$this->db->insert('dbapp_columnrestrictions', $data); 
    	
    	}
    	
    	
    	//return the updated column details
    	
    	return $columnDetailsUpdated;
    
    }
    
    
    /*
    	deletes an entire column from a given table in a given database
    */
    
    public function deleteColumn($db, $table, $column)
    {
    	
    	//drop possible FKs
    	$this->destroyForeignKey($db, $table, $column);
    
    	$this->theDB->query("ALTER TABLE `$table` DROP `$column`");
    	
    	
    	//column names are used to store notes and revisions as well, so we'll need to make some more updates to the db
    	
    	//first up: dbapp_cellrevisions
    	
    	$this->db->where('dbapp_cellrevisions_database', $db);
    	$this->db->where('dbapp_cellrevisions_table', $table);
    	$this->db->where('dbapp_cellrevisions_field', $column);
    	$this->db->delete('dbapp_cellrevisions'); 
    	
    	
    	//next, dbapp_columnnotes
    	
    	$this->db->where('dbapp_columnnotes_database', $db);
    	$this->db->where('dbapp_columnnotes_table', $table);
    	$this->db->where('dbapp_columnnotes_field', $column);
    	$this->db->delete('dbapp_columnnotes');
    	
    	
    	//next, dbapp_relations
    	
    	$this->db->where('dbapp_relations_database', $db);
    	$this->db->where('dbapp_relations_source_table', $table);
    	$this->db->where('dbapp_relations_source_field', $column);
    	$this->db->delete('dbapp_relations');
    	
    	
    	//next, dbapp_relations once more
    
    	$this->db->where('dbapp_relations_database', $db);
    	$this->db->where('dbapp_relations_reference_table', $table);
    	$this->db->where('dbapp_relations_reference_use', $column);
    	$this->db->delete('dbapp_relations');
    	
    	//next, dbapp_columnrestrictions
    	
    	$this->db->where('dbapp_columnrestrictions_database', $db);
    	$this->db->where('dbapp_columnrestrictions_table', $table);
    	$this->db->where('dbapp_columnrestrictions_column', $column);
    	$this->db->delete('dbapp_columnrestrictions');
    	
    	
    	//next, dbapp_columnselect
    	
    	$this->db->where('dbapp_columnselect_database', $db);
    	$this->db->where('dbapp_columnselect_table', $table);
    	$this->db->where('dbapp_columnselect_column', $column);
    	$this->db->delete('dbapp_columnselect');    	
    	
    
    }
    
    
    /*
    	creates a new column in the given db/table
    */
    
    public function newColumn($db, $table, $data)
    {
    
    	//determine the data type
    	
    	if( $data['columnType'] == 'int' ) {
    	
    		$dataType = "int(11)";
    		
    		if( $data['columnDefault'] != '' ) {
    		
    			$columnDefault = (int) $data['columnDefault'];
    		
    		}
    	
    	} elseif( $data['columnType'] == 'double' ) {
    		
			$dataType = "double";
			
    		if( $data['columnDefault'] != '' ) {
    		
    			$columnDefault = (double) $data['columnDefault'];
    		
    		}
			
    	} elseif( $data['columnType'] == 'varchar' ) {
    	
    		$dataType = "varchar(255)";
    		
    		if( $data['columnDefault'] != '' ) {
    		
    			$columnDefault = (string) $data['columnDefault'];
    		
    		}
    	
    	} elseif( $data['columnType'] == 'text' ) {
    	
    		$dataType = "text";
    	
    	} elseif( $data['columnType'] == 'blob' ) {
    	
    		$dataType = "blob";
    	
    	} elseif( $data['columnType'] == 'date' ) {
    	
    		$dataType = "date";
    	
    	} elseif( $data['columnType'] == 'select' ) {
    	
    		$dataType = "varchar(255)";
    		
    		//save the options in the database
    		
    		$optionArray = preg_split('/\n|\r/', $data['columnSelect'], -1, PREG_SPLIT_NO_EMPTY);
    		    		
    		$insertData = array(
    		   'dbapp_columnselect_database' => $db,
    		   'dbapp_columnselect_table' => $table,
    		   'dbapp_columnselect_column' => $data['columnName'],
    		   'dbapp_columnselect_values' => json_encode($optionArray)
    		);
    		
    		$this->db->insert('dbapp_columnselect', $insertData);
    	
    	}
    	
    	//if this column is setup as a foreign key, we'll need a proper default value, set to a primary_id value from the referenced table, this will override a manually set default
    	if( isset($data['connectTo']) && $data['connectTo'] != '' ) {
    	
    		$temp = explode(".", $data['connectTo']);
    		
    		$referenceTable = $temp[0];
    		    	
    		$columnDefault = $this->getKeyValue($referenceTable);
    	
    	}
    	
    	//where do we drop in the new column?
    	
    	if( $data['columnOffset'] != 'end' ) {
    	
    		$temp = $data['columnOffset'];
    	
    		$ttemp = explode("_", $temp);
    	
    		$newOffset = $ttemp[1];
    	
    		$allFields = $this->getFieldsFor($table);
    	
    		if( isset($columnDefault) ) {
    	
    			$this->theDB->query("ALTER TABLE `$table` ADD `".$data['columnName']."` $dataType NOT NULL DEFAULT '".$columnDefault."' after `".$allFields[$newOffset]['field']."`");    		
    	
    		} else {
    	
    			$this->theDB->query("ALTER TABLE `$table` ADD `".$data['columnName']."` $dataType NOT NULL after `".$allFields[$newOffset]['field']."`");
    	
    		}
    	
    	} else {
    		
    		if( isset($columnDefault) ) {
    		
    				$this->theDB->query("ALTER TABLE `$table` ADD `".$data['columnName']."` $dataType NOT NULL DEFAULT '".$columnDefault."'");    		
    		
    			} else {
    		
    				$this->theDB->query("ALTER TABLE `$table` ADD `".$data['columnName']."` $dataType NOT NULL");
    		
    			}
    	
    	}
    	
    	
    	//does the new column need an index? for now, we only allow indexes on int and varchar fields
    	
    	if( $data['columnType'] == 'int' || $data['columnType'] == 'varchar' || $data['columnType'] == 'date' ) {
    	
    		if( $data['columnIndex'] == 'primary' ) {
    	
    			$this->theDB->query("ALTER TABLE `$table` ADD PRIMARY KEY ( `".$data['columnName']."` )");
    	
    		} elseif( $data['columnIndex'] == 'unique' ) {
    	
    			$this->theDB->query("ALTER TABLE `$table` ADD UNIQUE ( `".$data['columnName']."` )");
    	
    		} elseif( $data['columnIndex'] == 'index' ) {
    	
    			$this->theDB->query("ALTER TABLE `$table` ADD INDEX ( `".$data['columnName']."` ) ");
    	
    		}
    	
    	}
    	
    	
    	//set a foreign key?
    	
    	if( isset($data['connectTo']) && $data['connectTo'] != '' ) {
    	
    		//split up the value into table + column
    		$temp = explode(".", $data['connectTo']);
    		
    		$referenceTable = $temp[0];
    		
    		$useColumn = $temp[1];
    	
    		$key = $this->getPrimaryKey($referenceTable)->name;
    		$fkey = "fk_".$data['columnName']."_".$referenceTable."_".$key;
    	
    		$this->theDB->query("ALTER TABLE `$table` ADD CONSTRAINT $fkey FOREIGN KEY (".$data['columnName'].") REFERENCES ".$referenceTable."($key) ON UPDATE CASCADE ON DELETE NO ACTION");
    		
    		
    		//add relation to database
    		
    		$this->load->model('relationmodel');
    		
    		//initialize db connection
    		
    		$this->relationmodel->initialize($db);
    		
    		$this->relationmodel->createNew($db, $table, $data['columnName'], $referenceTable, $key, $useColumn);
    	
    		    	
    	}
    	
    	
    	//restrictions
    	
    	if( isset($data['restrictions']) && count($data['restrictions']) > 0 && $data['restrictions'][1]['restriction'] != '') {
    	
    		$restrictions = array();
    	
    		foreach( $data['restrictions'] as $reArray ) {
    		
    			$restriction = $reArray['restriction'];
    			
    			if( isset($reArray['value']) ) {
    				
    				if( $reArray['value'] == '' ) {
    				
    					$value = "10";
    				
    				} else {
    				
    					$value = $reArray['value'];
    				
    				}
    				
    				$restriction .= "[$value]";
    			
    			}
    			
    			array_push($restrictions, $restriction);
    		
    		}
    		
    		$restrictions = implode("|", $restrictions);
    		
    		//insert into database
    		$data = array(
    		   'dbapp_columnrestrictions_database' => $db,
    		   'dbapp_columnrestrictions_table' => $table,
    		   'dbapp_columnrestrictions_column' => $data['columnName'],
    		   'dbapp_columnrestrictions_restrictions' => $restrictions
    		);
    		
    		$this->db->insert('dbapp_columnrestrictions', $data); 
    	
    	}
    	
    	
    	//add the new column to the session so it will show up in the dataview
    		    		
    	$this->session->unset_userdata($db.".".$table);
    		    	
    
    }
    
    
    /*
    	create new table
    */
    
    public function newTable($db, $data, $forceKey = true)
    {
    
    	//prepare the columns bit
    	
    	$colArray = array();
    	
    	foreach( $data['columns'] as $key=>$col ) {
    	
    		if( $forceKey && $key == 1 ) {
    			
    			//the first column will be set as the primary key for the new table
    			
    			//auto increment?
    			
    			if( isset($data['auto-increment']) && $data['auto-increment'] == 'yes' ) {
    			
    				$colString = "`".$col['columnName']."` int(11) NOT NULL AUTO_INCREMENT, primary key (`".$col['columnName']."`)";
    			
    			} else {
    			
    				$colString = "`".$col['columnName']."` int(11) NOT NULL, primary key (`".$col['columnName']."`)";
    			
    			}
    		
    		} else {
    	
    			$colString = "`".$col['columnName']."` ";
    	
    			//column type
    			if( $col['columnType'] == 'int' ) {
    		
    				$colString .= "int(11) NOT NULL";
    				
    				//column default
    				
    				if( $col['columnDefault'] != '' ) {
    				
    					$columnDefault = (int) $col['columnDefault'];
    				
    					$colString .= " DEFAULT '$columnDefault'";
    				
    				}
    				    		
    			} elseif( $col['columnType'] == 'varchar' ) {
    		
    				$colString .= "varchar(255) NOT NULL";
    				
    				//column default
    				
    				if( $col['columnDefault'] != '' ) {
    				
    					$columnDefault = (string) $col['columnDefault'];
    				
    					$colString .= " DEFAULT '$columnDefault'";
    				
    				}
    			
    			} elseif( $col['columnType'] == 'text' ) {
    		
    				$colString .= "text NOT NULL";
    		
    			} elseif( $col['columnType'] == 'blob' ) {
    		
    				$colString .= 'blob NOT NULL';
    		
    			} elseif( $col['columnType'] == 'date' ) {
    			
    				$colString .= 'date NOT NULL';
    			
    			} elseif( $col['columnType'] == 'select' ) {
    			
    				$colString .= "varchar(255) NOT NULL";
    				
    				$optionArray = preg_split('/\n|\r/', $col['columnSelect'], -1, PREG_SPLIT_NO_EMPTY);
    					    		
    				$insertData = array(
    					'dbapp_columnselect_database' => $db,
    					'dbapp_columnselect_table' => $data['tableName'],
    					'dbapp_columnselect_column' => $col['columnName'],
    					'dbapp_columnselect_values' => json_encode($optionArray)
    				);
    					
    				$this->db->insert('dbapp_columnselect', $insertData);    				
    			
    			}
    			
    		
    		}
    		
    		array_push($colArray, $colString);
    	
    	}
    	
    	$columns = implode(", ", $colArray);
    	
    	//create the table, set the proper engine type first
    	$this->theDB->query('SET storage_engine=INNODB');
    	
    	$this->theDB->query("CREATE TABLE `".$data['tableName']."` (".$columns.")");
    	
    	
    	//if the user is not an admin, we'll need to make sure he/she will have the correct rights to the new table
    	if( !$this->ion_auth->is_admin() ) {
    	
    		$tableName = $data['tableName'];
    		
    		//add table for this user to their db record
    		
    		$privateTables = json_decode($this->ion_auth->user()->row()->tables, true);
    		
    		if( $privateTables == null ) {
    			
    			$privateTables = array();
    		
    		}
    		
    		array_push($privateTables, $db.".".$tableName);
    		
    		$dataa = array(
    			'tables' => json_encode($privateTables)
    		);
    		
    		$this->db->where('id', $this->ion_auth->user()->row()->id);
    		$this->db->update('dbapp_users', $dataa); 
    		
    		
    		//check what else we need to do
    	
    		if( isset($data['share']) && $data['share'] == 'private' ) {
    		
	    		$this->db->query("GRANT ALL ON `".$db."`.`".$tableName."` TO '".$this->ion_auth->user()->row()->mysql_user."'@'".$this->db->hostname."'");
	    		
	    		$this->db->query("GRANT INSERT ON `".$db."`.* TO '".$this->ion_auth->user()->row()->mysql_user."'@'".$this->db->hostname."'");	    	

    		} elseif( isset($data['share']) && $data['share'] == 'group' ) {
    		
    			$tempp = $this->ion_auth->get_users_groups($this->ion_auth->user()->row()->id)->result();
    		
    			$group = $tempp[0];
    			
    			//get group permissions
    			
    			$tempp = $this->db->from('dbapp_groups')->where('id', $group->id)->get()->result();
    			
    			$permissions = $tempp[0]->permissions;
    			
    			$permissionsArray = json_decode($permissions, true);
    			
    			//add the new table permissions
    			
    			$temp = array();
    			$temp['select'] = 'yes';
    			$temp['delete'] = 'yes';
    			$temp['insert'] = 'yes';
    			$temp['update'] = 'yes';
    			$temp['alter'] = 'yes';
    			
    			$permissionsArray[$db][$tableName] = $temp;
    			
    			//save to db
    			    			
    			$data = array(
    				'permissions' => json_encode($permissionsArray)
    			);
    			
    			$this->db->where('id', $group->id);
    			$this->db->update('dbapp_groups', $data);
    			    			
    			//apply the new permissions to the MySQL user
    			$this->load->model('rolemodel');
    			    					
    			$users = $this->db->from('dbapp_users_groups')->join('dbapp_users', 'dbapp_users_groups.user_id = dbapp_users.id')->where('group_id', $group->id)->get()->result();
    			
    			//print_r($permissionsArray);
    			    					
    			foreach( $users as $user ) {
    			
    				$this->rolemodel->applyPermissions($permissionsArray, $user->mysql_user);
    				
    			}
    		
    		
    		} elseif( isset($data['share']) && $data['share'] == 'all' ) {
    		
    			//allow for all rols/groups
    			
    			$groups = $this->db->get('dbapp_groups')->result();
    			    			
    			foreach( $groups as $group ) {
    			
    				if( $group->id > 1 ) {
    				    				
    					$permissionsArray = json_decode($group->permissions, true);
    					
    					//add the new table permissions
    					
    					$temp = array();
    					$temp['select'] = 'yes';
    					$temp['delete'] = 'yes';
    					$temp['insert'] = 'yes';
    					$temp['update'] = 'yes';
    					$temp['alter'] = 'yes';
    					
    					$permissionsArray[$db][$tableName] = $temp;
    					
    					//save to db
    					    			
    					$data = array(
    						'permissions' => json_encode($permissionsArray)
    					);
    					
    					$this->db->where('id', $group->id);
    					$this->db->update('dbapp_groups', $data);
    					
    					//apply the new permissions to the MySQL user
    					$this->load->model('rolemodel');
    					    					
    					$users = $this->db->from('dbapp_users_groups')->join('dbapp_users', 'dbapp_users_groups.user_id = dbapp_users.id')->where('group_id', $group->id)->get()->result();
    					
    					//print_r($permissionsArray);
    					    					
    					foreach( $users as $user ) {
    					
    						$this->rolemodel->applyPermissions($permissionsArray, $user->mysql_user);
    						
    					}
    					
    				
    				}
    			
    			}
    			
    		
    		}
    	
    	}
    
    }
    
    
    /*
    	checks to see if a table exists
    */
    
    public function exists($table)
    {
    
    	$query = $this->theDB->query("SHOW TABLES LIKE '$table'");
    	    	
    	if( $query->num_rows() > 0 ) {
    	
    		return true;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	test to make sure all the column names are unique
    */
    
    public function uniqueColumns($data)
    {
    
    	foreach( $data as $key=>$col ) {
    	
    		$columnName = $col['columnName'];
    		
    		foreach( $data as $k=>$v ) {
    		    		
    			if( $columnName == $v['columnName'] && $key != $k ) {
    			
    				return false;
    			
    			}
    		
    		}
    	
    	}
    	    	
    	return true;
    
    }
    
    
    /*
    	deletes a table from a database
    */
    
    public function deleteTable($db, $table)
    {
    	
    	//destroy possible foreign keys 
    	
    	$fields = $this->getFieldsFor($table);
    	
    	foreach( $fields as $field ) {
    	
    		$this->destroyForeignKey($db, $table, $field['field']);
    	
    	}
    
    	$this->theDB->query("DROP TABLE `$table`");
    	
    	//delete from group permissions
    	
    	$groups = $this->db->from('dbapp_groups')->get()->result();
    	
    	foreach( $groups as $group ) {
    	
    		if( $group->id > 1 ) {//no need for admin
    	
    			$permissions = json_decode($group->permissions, true);
    			
    			if( isset($permissions[$db][$table]) ) {//this group has permissions set for this table
    		
    				unset($permissions[$db][$table]);
    		
    				$updatedPermissions = json_encode($permissions);
    		
    				//update db
    				$data = array(
    					'permissions' => $updatedPermissions
    				);
    			
    				$this->db->where('id', $group->id);
    				$this->db->update('dbapp_groups', $data);
    				
    				
    				//now, we'll need to update the MySQL permissions for each user in this group
    				
    				$users = $this->db->from('dbapp_users_groups')->join('dbapp_users', 'dbapp_users_groups.user_id = dbapp_users.id')->where('group_id', $group->id)->get();
    				
    				if( $users->num_rows() > 0 ) {
    				
    					foreach( $users->result() as $user ) {
    					
    						$this->rolemodel->applyPermissions(json_decode($updatedPermissions, true), $user->mysql_user);
    					        					    					
    					}
    				
    				}
    				
    			
    			}
    		
    		}
    	
    	}
    	
    	
    	//if this is a user private table, delete from tables column in users table
    	
    	if( $this->usermodel->ownsTable($db, $table) ) {
    	    	
    		$userTables = $this->ion_auth->user()->row()->tables;
    		
    		$tables = json_decode($userTables, true);
    		
    		$newTables = array();
    		
    		foreach( $tables as $t ) {
    			
    			if( $t != $db.".".$table ) {
    			
    				array_push($newTables, $t);
    			
    			}
    		
    		}
    		
    		//update db
    		$data = array(
    			'tables' => json_encode($newTables)
    		);
    		
    		$this->db->where('id', $this->ion_auth->user()->row()->id);
    		$this->db->update('dbapp_users', $data); 
    		
    		
    		//revoke for all table
    		$this->db->query("REVOKE ALL PRIVILEGES  ON `$db`.`$table` FROM '". $this->ion_auth->user()->row()->mysql_user."'@'".$this->db->hostname."'");
    	
    	}
    	
    	
    	//we'll need to make some updates to our dbapp tables as well
    	
    	//first up, dbapp_cellrevisions
    	
    	$this->db->where('dbapp_cellrevisions_database', $db);
    	$this->db->where('dbapp_cellrevisions_table', $table);
    	$this->db->delete('dbapp_cellrevisions'); 
    	
    	
    	//next, dbapp_columnnotes
    	
    	$this->db->where('dbapp_columnnotes_database', $db);
    	$this->db->where('dbapp_columnnotes_table', $table);
    	$this->db->delete('dbapp_columnnotes');
    	
    	
    	//next, dbapp_recordnotes
    	
    	$this->db->where('dbapp_recordnotes_database', $db);
    	$this->db->where('dbapp_recordnotes_table', $table);
    	$this->db->delete('dbapp_recordnotes');
    	
    	
    	//next, dbapp_relations
    	
    	$this->db->where('dbapp_relations_database', $db);
    	$this->db->where('dbapp_relations_source_table', $table);
    	$this->db->delete('dbapp_relations');
    	
    	
    	//dbapp_relations once more
    	
    	$this->db->where('dbapp_relations_database', $db);
    	$this->db->where('dbapp_relations_reference_table', $table);
    	$this->db->delete('dbapp_relations');
    	
    	
    	//next, dbapp_tablenotes
    	
    	$this->db->where('dbapp_tablenotes_database', $db);
    	$this->db->where('dbapp_tablenotes_table', $table);
    	$this->db->delete('dbapp_tablenotes');
    	
    	
    	//next, dbapp_columnrestrictions
    	
    	$this->db->where('dbapp_columnrestrictions_database', $db);
    	$this->db->where('dbapp_columnrestrictions_table', $table);
    	$this->db->delete('dbapp_columnrestrictions');
    	
    	
    	//next, dbapp_columnselect
    	
    	$this->db->where('dbapp_columnselect_database', $db);
    	$this->db->where('dbapp_columnselect_table', $table);
    	$this->db->delete('dbapp_columnselect');
    	    	
    }
    
    
    /*
    	returns the engine type for a table
    */
    
    public function getEngine($table)
    {
    
    	$query = $this->theDB->query("SHOW TABLE STATUS WHERE Name = '$table'");
    	
    	$tempp = $query->result();
    	
    	$row = $tempp[0];
    	
    	return $row->Engine;
    
    }
    
    
    
    /*
    	checks to see of the table is private for a given user (role)
    */
    
    public function isPrivate($db, $table) 
    {
    
    	$user = $this->ion_auth->user()->row();
    	
    	//get group info
    	
    	$query = $this->db->from('dbapp_users_groups')->where('user_id', $user->id)->join('dbapp_groups', 'dbapp_users_groups.group_id = dbapp_groups.id')->get();

		if( $query->num_rows() > 0 ) {
		
			$temp = $query->result();
			
			$permissions = json_decode($temp[0]->permissions, true);
			
			if( isset($permissions[$db][$table]['private']) ) {
			
				return true;
			
			} else {
			
				return false;
			
			}
		
		} else {
		
			return false;
		
		}
		    
    }
    
    
    
    /*
    	create a new table structure for an imported CSV file, given the column names (from the first row)
    */
    
    public function createTableforCSV($db, $tableName, $columns, $fileData, $useColumns, $dilimiter, $enclosure)
    {
    
    	$theColumns = array();
    	
    	$counter = 1;
    	
    	foreach( $columns as $column ) {
    		
    		//$theColumns[$counter] = "`".preg_replace("/[^a-z0-9_]+/i", "", $column)."` varchar(255)";
    		
    		$temp = array();
    		$temp['columnName'] = preg_replace("/[^a-z0-9_]+/i", "", $column);
    		$temp['columnType'] = "varchar";
    		$temp['columnDefault'] = "";
    		
    		$theColumns[$counter] = $temp;
    		
    		$counter++;
    		
    	}
    		
    	//columns string for the create table query (includes column definitions)
    	//$theColumns = "(".implode(", ", $theColumns).")";
    		
    	if( isset($_POST['share']) && $_POST['share'] != '' ) {
    	
    		$this->newTable($db, array('columns' => $theColumns, 'tableName' => $tableName, 'share' => $_POST['share']), false);
    	
    	} else {
    	
    		$this->newTable($db, array('columns' => $theColumns, 'tableName' => $tableName), false);
    	
    	}
    	    	
    	//$this->theDB->query("CREATE TABLE $tableName ".$theColumns);
    	
    	
    	//parse data
    
    	$this->load->library('csvreader');
    	$this->csvreader->separator = $dilimiter;
    	$this->csvreader->enclosure = $enclosure;
    	
    	$res = $this->csvreader->parse_file($fileData['full_path'], $columns);
    	
    	//print_r($res);
    	
    	$this->theDB->insert_batch($tableName, $res);
    	
    	
    	//pop first item off as it contains the column names
    	if( $useColumns ) {
    	
    		$this->theDB->query("DELETE FROM `$tableName` WHERE `".preg_replace("/[^a-z0-9_]+/i", "", $columns[0])."` = '".preg_replace("/[^a-z0-9_]+/i", "", $columns[0])."'");
    	
    	}
    	
    	
    	//we'd like a primary key set for this table, can we use the first column?
    	
    	$query = $this->theDB->query("SELECT count(`".preg_replace("/[^a-z0-9_]+/i", "", $columns[0])."`) as 'count1', count(distinct `".preg_replace("/[^a-z0-9_]+/i", "", $columns[0])."`) as 'count2' FROM `$tableName`");
    	    	
    	$res = $query->result();
    	
    	if( $res[0]->count1 == $res[0]->count2 ) {
    	
    		//the first column holds only unique values, we'll set it as a the primary key
    		
    		$this->theDB->query("ALTER TABLE `".$tableName."` ADD PRIMARY KEY(`".preg_replace("/[^a-z0-9_]+/i", "", $columns[0])."`)");
    	
    	} else {
    	
    		//first column does not hold unique values, so we'll add an additional column for the primary ID
    		
    		$this->theDB->query("ALTER TABLE `$tableName` ADD `".$tableName."_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ");
    	
    	}
    
    }
    
    
   	/*
   		imports CSV data into existing table
	*/
	public function importCSV($db, $tableName, $fileData, $dilimiter, $enclosure)
   	{
   	
   		$columns = $this->theDB->list_fields($tableName);
   		   		
   		$this->load->library('csvreader');
   		$this->csvreader->separator = $dilimiter;
   		$this->csvreader->enclosure = $enclosure;
   		
   		$res = $this->csvreader->parse_file($fileData['full_path'], $columns);
   		
   		//print_r($res);
   		
   		if( count($res) == 0 ) {
   			return false;
   		}
   		
   		$query = $this->theDB->insert_batch($tableName, $res);
   		
   		if( $this->theDB->_error_message() ) {
   			
   			return false;
   		
   		} else {
   		
   			//insert went well, update the record tracking table dbapp_users_records
   			
   			$user = $this->ion_auth->user()->row();
   			
   			$pkey_ = $this->getPrimaryKey($tableName);
   			
   			$pkey = $pkey_->name;
   			
   			$recArray = array();
   			
   			foreach( $res as $r ) {
   			
   				$temp = array();
   				$temp['dbapp_users_records_userid'] = $user->id;
   				$temp['dbapp_users_records_database'] = $db;
   				$temp['dbapp_users_records_table'] = $tableName;
   				$temp['dbapp_users_records_recordid'] = $r[$pkey];
   			
   				$recArray[] = $temp;
   			
   			}
   			
   			$query = $this->db->insert_batch('dbapp_users_records', $recArray);
   		
   			return true;
   		
   		}
   
   	}
    
}