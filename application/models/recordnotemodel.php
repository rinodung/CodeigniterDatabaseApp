<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RecordnoteModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('ion_auth');
        
    }
    
   	/*
   		add a new record note
   	*/
   	
   	public function newRecordNote($db, $table, $indexName, $recordID, $note)
   	{
   	
   		$user = $this->ion_auth->user()->row();
   		
   		$data = array(
   		   'dbapp_recordnotes_userid' => $user->id,
   		   'dbapp_recordnotes_database' => $db,
   		   'dbapp_recordnotes_table' => $table,
   		   'dbapp_recordnotes_indexname' => $indexName,
   		   'dbapp_recordnotes_indexvalue' => $recordID,
   		   'dbapp_recordnotes_note' => $note,
   		   'dbapp_recordnotes_timestamp' => time()
   		);
   		
   		$this->db->insert('dbapp_recordnotes', $data); 
   	
   	}
   	
   	
   	/*
   		loads notes for a table column
   	*/
   	
   	public function getRecordNotes($db, $table, $indexName, $recordID) 
   	{
   		
   		$notes = $this->db->from('dbapp_recordnotes')->join('dbapp_users', 'dbapp_recordnotes.dbapp_recordnotes_userid = dbapp_users.id')->where('dbapp_recordnotes_indexname', $indexName)->where('dbapp_recordnotes_indexvalue', $recordID)->where('dbapp_recordnotes_database', $db)->where('dbapp_recordnotes_table', $table)->get()->result();
   		
   		return $notes;
   		    	    
   	}
   	
   	
   	/*
   		update a single record note
   	*/
   	
   	public function updateNote($noteID, $note)
   	{
   	
   		$data = array(
   			'dbapp_recordnotes_note' => $note,
   		);
   		
   		$this->db->where('dbapp_recordnotes_id', $noteID);
   		$this->db->update('dbapp_recordnotes', $data); 
   	
   	}
   	
   	
   	/*
   		deletes a record note
   	*/
   	
   	public function deleteRecordNote($noteID)
   	{
   		
   		$this->db->where('dbapp_recordnotes_id', $noteID);
   		$this->db->delete('dbapp_recordnotes'); 
   	
   	}
   	
   	
   	/*
   		checks to see if the given note belongs to the current user
   	*/
   	
   	public function isMine($noteID)
   	{
   	
   		$user = $this->ion_auth->user()->row();
   		
   		//grab the note
   		
   		$tempp = $this->db->from('dbapp_recordnotes')->where('dbapp_recordnotes_id', $noteID)->get()->result();
   		
   		$noteOwnerID = $tempp[0]->dbapp_recordnotes_userid;
   		
   		if( $noteOwnerID == $user->id || $this->ion_auth->is_admin() ) {
   		
   			return true;
   		
   		} else {
   		
   			return false;
   		
   		}
   	
   	}
    
}