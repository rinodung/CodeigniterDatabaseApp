<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TablenoteModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('ion_auth');
        
    }
    
    
    /*
    	returns all notes for a table
    */
    
    public function getTableNotes($db, $table)
    {
    
    	return $this->db->from('dbapp_tablenotes')->join('dbapp_users', 'dbapp_tablenotes.dbapp_tablenotes_userid = dbapp_users.id')->where('dbapp_tablenotes_database', $db)->where('dbapp_tablenotes_table', $table)->get()->result();
    
    }
    
    
    /*
    	creates a new table notes
    */
    
    public function newTableNote($db, $table, $note)
    {
    
    	$user = $this->ion_auth->user()->row();
    
    	$data = array(
    		'dbapp_tablenotes_userid' => $user->id,
    	   	'dbapp_tablenotes_database' => $db,
    	   	'dbapp_tablenotes_table' => $table,
    	   	'dbapp_tablenotes_note' => $note,
    	   	'dbapp_tablenotes_timestamp' => time()
    	);
    	
    	$this->db->insert('dbapp_tablenotes', $data); 
    
    }
    
    
    /*
    	checks to see if the given note belongs to the current user
    */
    
    public function isMine($noteID)
    {
    
    	$user = $this->ion_auth->user()->row();
    	
    	//grab the note
    	
    	$tempp = $this->db->from('dbapp_tablenotes')->where('dbapp_tablenotes_id', $noteID)->get()->result();
    	
    	$noteOwnerID = $tempp[0]->dbapp_tablenotes_userid;
    	
    	if( $noteOwnerID == $user->id || $this->ion_auth->is_admin() ) {
    	
    		return true;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	deletes a table note
    */
    
    public function deleteTableNote($noteID)
    {
    
    	$this->db->where('dbapp_tablenotes_id', $noteID);
    	$this->db->delete('dbapp_tablenotes');
    
    }
    
    
    /*
    	updates a table note
    */
    
    public function updateNote($noteID, $note)
    {
    
    	$data = array(
    		'dbapp_tablenotes_note' => $note,
    	);
    	
    	$this->db->where('dbapp_tablenotes_id', $noteID);
    	$this->db->update('dbapp_tablenotes', $data); 
    
    }
    
}