<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RevisionModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('ion_auth');
        
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
    	saves a new revision
    */
    
    public function saveRevision($db, $table, $field, $indexName, $indexValue, $newVal, $timestamp, $priority = 0) 
    {
    
    	//grab the current value for the revision storage
    	
    	$tempp = $this->theDB->from($table)->select($field)->where($indexName, $indexValue)->get()->result_array();
    	
    	$oldVal = $tempp[0][$field];
    	
    	if( $oldVal == NULL ) {
    	
    		$oldVal = '';
    	
    	}
    	    	
    	//die($newVal." ".$oldVal);
    	
    	//did the value actually change? If not, no action is needed
    	if($newVal != $oldVal || $priority  == 1) {
    	
    		//$this->theDB->close();
    	
    		$this->load->database();
    
    		$data = array(
    	   		'dbapp_cellrevisions_database' => $db,
    	   		'dbapp_cellrevisions_table' => $table,
    	   		'dbapp_cellrevisions_field' => $field,
    	   		'dbapp_cellrevisions_indexname' => $indexName,
    	   		'dbapp_cellrevisions_indexvalue' => $indexValue,
    	   		'dbapp_cellrevisions_value' => $oldVal,
    	   		'dbapp_cellrevisions_timestamp' => $timestamp
    		);
    	
    		$this->db->insert('dbapp_cellrevisions', $data);
    	
    	}
    	    
    }
    
    
    /*
    	deletes a revision
    */
    
    public function removeRevision($revisionID) 
    {
    
    	$this->db->where('dbapp_cellrevisions_id', $revisionID)->delete('dbapp_cellrevisions');
    	
    }
    
    
    /*
    	deletes a selection of revisions for a certain record
    */
    
    public function removeRecordRevisions($db, $table, $indexName, $recordID, $timestamp)
    {
    
    	$this->db->where('dbapp_cellrevisions_database', $db);
    	$this->db->where('dbapp_cellrevisions_table', $table);
    	$this->db->where('dbapp_cellrevisions_indexname', $indexName);
    	$this->db->where('dbapp_cellrevisions_indexvalue', $recordID);
    	$this->db->where('dbapp_cellrevisions_timestamp', $timestamp);
    	
    	$this->db->delete('dbapp_cellrevisions');
    	
    	return $this->db->affected_rows();
    
    }
    
    
    /*
    	restores a single revision
    */
    
    public function restoreRevision($db, $revisionID, $timestamp = 0) 
    {
        
    	//get the revision data
    	
    	$tempp = $this->db->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_id', $revisionID)->get()->result();
    	
    	$revision = $tempp[0];
    	
    	if($timestamp == 0) {
    		$timestamp = time();
    	}
    	
    	if($revision->dbapp_cellrevisions_value != '') {
    	    	
    	//save the old value as a revision
    	$this->saveRevision($db, $revision->dbapp_cellrevisions_table, $revision->dbapp_cellrevisions_field, $revision->dbapp_cellrevisions_indexname, $revision->dbapp_cellrevisions_indexvalue, $revision->dbapp_cellrevisions_value, $timestamp);
    	
    	$data = array(
    		$revision->dbapp_cellrevisions_field => $revision->dbapp_cellrevisions_value
    	);
    	
    	$this->theDB->where($revision->dbapp_cellrevisions_indexname, $revision->dbapp_cellrevisions_indexvalue);
    	$this->theDB->update($revision->dbapp_cellrevisions_table, $data); 
    	
    	$this->theDB->close();
    	
    	}
    	
    	return $revision->dbapp_cellrevisions_value;
    
    }
    
    
    /*
    	returns a single revision
    */
    
    public function getRevision($revisionID) 
    {
    
    	$tempp = $this->db->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_id', $revisionID)->get()->result();
    
    	$revision = $tempp[0];
    	
    	return $revision;
    
    }
    
    
    /* 
    	returns all revisions for a certain cell
    */
    
    public function getRevisions($db, $table, $field, $indexName, $recordID)
    {
    
    	$revisions = $this->db->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_database', $db)->where('dbapp_cellrevisions_table', $table)->where('dbapp_cellrevisions_indexname', $indexName)->where('dbapp_cellrevisions_field', $field)->where('dbapp_cellrevisions_indexvalue', $recordID)->get()->result();
    	
    	return $revisions;
    
    }
    
    
    /*
    	returns a selection of revisions for a certain record, organized by timestamp
    */
    
    public function loadRecordRevisions($db, $table, $indexName, $recordID)
    {
    	
    	//start by grabbing the unique timestamps for this record
    	$query = $this->db->select('dbapp_cellrevisions_timestamp')->distinct()->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_database', $db)->where('dbapp_cellrevisions_table', $table)->where('dbapp_cellrevisions_indexname', $indexName)->where('dbapp_cellrevisions_indexvalue', $recordID)->get()->result();
    	
    	$return = array();
    	
    	foreach($query as $stamp) {
    		
    		$timestamp = $stamp->dbapp_cellrevisions_timestamp;
    		
    		//grab all revisions for this record with this timestamp
    		
    		$revisions = $this->db->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_database', $db)->where('dbapp_cellrevisions_table', $table)->where('dbapp_cellrevisions_indexname', $indexName)->where('dbapp_cellrevisions_indexvalue', $recordID)->where('dbapp_cellrevisions_timestamp', $timestamp)->get()->result();
    		
    		
    		$return[$timestamp] = $revisions;    		
    	
    	}
    	
    	return $return;
    
    }
    
    
    /*
    	given a single revisionID, this function returns all revisions for the involved record
    */
    
    public function loadRecordRevisionsFromRevision($revisionID)
    {
    
    	$tempp = $this->db->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_id', $revisionID)->get()->result();
    	
    	$revision = $tempp[0];
    	
    	return $this->loadRecordRevisions($revision->dbapp_cellrevisions_database, $revision->dbapp_cellrevisions_table, $revision->dbapp_cellrevisions_indexname, $revision->dbapp_cellrevisions_indexvalue);
    
    }
    
    
    /*
    	returns a set of revisions for a certain record, all part of a single previous update
    */
    
    public function loadRecordRevision($db, $table, $indexName, $recordID, $timestamp)
    {
    
    	$revisions = $this->db->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_database', $db)->where('dbapp_cellrevisions_table', $table)->where('dbapp_cellrevisions_indexname', $indexName)->where('dbapp_cellrevisions_indexvalue', $recordID)->where('dbapp_cellrevisions_timestamp', $timestamp)->get()->result();
    	
    	return $revisions;
    
    }
    
    
    /*
    	given a revisionID, returns record details (db, table, field etc)
    */
    
    public function getRecordFrom($revisionID)
    {
    
    	$return = array();
    	
    	$tempp = $this->db->from('dbapp_cellrevisions')->where('dbapp_cellrevisions_id', $revisionID)->get()->result();
    
    	$details = $tempp[0];
    	
    	$return['db'] = $details->dbapp_cellrevisions_database;
    	$return['table'] = $details->dbapp_cellrevisions_table;
    	$return['field'] = $details->dbapp_cellrevisions_field;
    	$return['indexName'] = $details->dbapp_cellrevisions_indexname;
    	$return['recordID'] = $details->dbapp_cellrevisions_indexvalue;
    	
    	return $return;
    
    }    
    
}