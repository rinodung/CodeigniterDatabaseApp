<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RelationModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->model('tablemodel');
        $this->load->model('dbmodel');
        
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
    	creates a new relation
    */
    
    public function createNew($db, $sourceTable, $sourceColumn, $referencedTable, $referencedColumn, $referencedUse)
    {
    	
    	$data = array(
    		'dbapp_relations_database' => $db,
    		'dbapp_relations_source_table' => $sourceTable,
    	   	'dbapp_relations_source_field' => $sourceColumn,
    	   	'dbapp_relations_reference_table' => $referencedTable,
    	   	'dbapp_relations_reference_field' => $referencedColumn,
    	   	'dbapp_relations_reference_use' => $referencedUse
    	);
    	
    	$this->db->insert('dbapp_relations', $data);
    
    }
    
}