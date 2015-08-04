<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ColumnnoteModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('ion_auth');
        
    }
    
    
    /*
    	loads notes for a table column
    */
    
    public function getColumnNotes($db, $table, $field) 
   	{
    	
    	$notes = $this->db->from('dbapp_columnnotes')->join('dbapp_users', 'dbapp_columnnotes.dbapp_columnnotes_userid = dbapp_users.id')->where('dbapp_columnnotes_field', $field)->where('dbapp_columnnotes_database', $db)->where('dbapp_columnnotes_table', $table)->get()->result();
    	
    	return $notes;
    	    	    
    }
    
    
    /*
    	add a new column note
    */
    
    public function newColumnNote($db, $table, $field, $note)
    {
    
    	$user = $this->ion_auth->user()->row();
    	
    	$data = array(
    	   'dbapp_columnnotes_userid' => $user->id,
    	   'dbapp_columnnotes_database' => $db,
    	   'dbapp_columnnotes_table' => $table,
    	   'dbapp_columnnotes_field' => $field,
    	   'dbapp_columnnotes_note' => $note,
    	   'dbapp_columnnotes_timestamp' => time()
    	);
    	
    	$this->db->insert('dbapp_columnnotes', $data); 
    
    }
    
    
    /*
    	deletes a single column note
    */
    
    public function deleteColumnNote($noteID)
    {
    
    	$this->db->where('dbapp_columnnotes_id', $noteID);
    	$this->db->delete('dbapp_columnnotes'); 
    
    }
    
    
    /*
    	updates a column note
    */
    
    public function updateNote($noteID, $note)
    {
    
    	$data = array(
    		'dbapp_columnnotes_note' => $note,
    	);
    	
    	$this->db->where('dbapp_columnnotes_id', $noteID);
    	$this->db->update('dbapp_columnnotes', $data); 
    
    }
    
    
    /*
    	checks to see if the given note belongs to the current user
    */
    
    public function isMine($noteID)
    {
    
    	$user = $this->ion_auth->user()->row();
    	
    	//grab the note
    	
    	$tempp = $this->db->from('dbapp_columnnotes')->where('dbapp_columnnotes_id', $noteID)->get()->result();
    	
    	$noteOwnerID = $tempp[0]->dbapp_columnnotes_userid;
    	
    	if( $noteOwnerID == $user->id || $this->ion_auth->is_admin() ) {
    	
    		return true;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
}