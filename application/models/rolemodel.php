<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RoleModel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->library('ion_auth');
        
    }
    
    
    /*
    	createa new user role
    */
    
    public function newRole($data) 
    {
    
    	//prep name
    	$name = preg_replace("/[^a-zA-Z0-9]+/", "", $data['role']);
    	
    	if( !isset($data['permissions']) ) {
    	
    		$data['permissions'] = array();
    	
    	}
    	
    	//we'll need something recursive here, to add all tables referenced from tables within the permission array
    	
    	foreach( $data['permissions'] as $database=>$dbArray ) {
    	
    		$arr = $this->fkPermissions($database, $dbArray);
    		
    		$data['permissions'][$database] = $arr;
    		    	
    	}
    	
    	if( isset($roleData['default']) && $data['default'] == 1 ) {
    	
    		$default = 1;
    		
    		//reset all other roles to default = 0
    		
    		$data_ = array(
    			'default' => 0
    		);
    		
    		$this->db->where('default', '1');
    		$this->db->update('dbapp_groups', $data_); 
    	
    	} else {
    	
    		$default = 0;
    	
    	}
    	    	    	    
    	$data = array(
    		'name' => $name,
    	   	'description' => $data['role'],
    	   	'descr' => $data['roleDescr'],
    	   	'permissions' => json_encode($data['permissions']),
    	   	'default' => $default
    	);
    	
    	$this->db->insert('dbapp_groups', $data);
    	
    	//returns the user role name, user for redirection
    	return $name;
    
    }
    
    
    /*
    	returns a user role
    */
    
    public function getRole($role)
    {
    
    	$tempp = $this->db->from('dbapp_groups')->where('name', $role)->get()->result();
    
    	return $tempp[0];
    
    }
    
    
    /*
    	returns all user roles
    */
    
    public function getAll()
    {
    
    	return $this->db->from('dbapp_groups')->get()->result();
    
    }
    
    
    public function fkPermissions($db, $tableArray) {
    
    	foreach( $tableArray as $table=>$permArray ) {
    	
    		//does this table has FK references?
    		
    		if( $this->tablemodel->getReferencingTables($db, $table) ) {
    		
    			$referencingTables = $this->tablemodel->getReferencingTables($db, $table);
    			
    			//add these to the array
    			foreach( $referencingTables as $t ) {
    			
    				if( !isset($tableArray[$t]) ) {
    			
    					$tableArray[$t]['select'] = 'yes';
    				    				
    					$addition = true;
    				
    				}
    			
    			}    			
    			    		
    		}
    		    	
    	}
    	
    	if( isset($addition) ) {
    	
    		return $this->fkPermissions($db, $tableArray);
    	
    	} else {
    	
    		return $tableArray;
    	
    	}
    
    }
    
    
    /*
    	updates permissions for a given user role
    */
    
    public function updatePermissions($permissions, $roleID) 
    {
    
    	//only do this if the user is NOT Administrator
    	if ($this->ion_auth->is_admin($roleID)) {
    		return false;
    	}
    	
    	//we'll need something recursive here, to add all tables referenced from tables within the permission array
    	
    	foreach( $permissions as $database=>$dbArray ) {
    	
    		$arr = $this->fkPermissions($database, $dbArray);
    		
    		$permissions[$database] = $arr;
    		    	
    	}
    	
    	//print_r($permissions);
    	
    	//die();
    	    	    
    	$jsonfied = json_encode($permissions);
    	
    	$data = array(
    		'permissions' => $jsonfied,
    	);
    	
    	$this->db->where('id', $roleID);
    	$this->db->update('dbapp_groups', $data);
    	
    	
    	//we also need to make sure that the new MySQL permissions are applied to existing users
    	
    	//grab all users who have this role
    	
    	$users = $this->db->from('dbapp_users_groups')->where('group_id', $roleID)->join('dbapp_users', 'dbapp_users_groups.user_id = dbapp_users.id')->get()->result();
    	
    	
    	foreach($users as $user) {
    	
    		$this->applyPermissions($permissions, $user->mysql_user);
    		    		
    	}
    	
    	$tempp = $this->db->from('dbapp_groups')->where('id', $roleID)->get()->result(); 
    	
    	return $tempp[0]->name;
    
    }
    
    
    /*
    	update other details for a given user role
    */
    
    public function updateRole($roleData) 
    {
    	
    	//only do this if the user is NOT Administrator
    	if ($this->ion_auth->is_admin($roleData['roleID'])) {
    		return false;
    	}
    
    
    	if(isset($roleData['admin_users']) && $roleData['admin_users'] == 'yes') {
    	
    		$admin_users = '1';
    		
    	} else {
    	
    		$admin_users = '0';
    		
    	}
    	
    	if( isset($roleData['default']) && $roleData['default'] == 1 ) {
    	
    		$default = 1;
    		
    		//reset all other roles to default = 0
    		
    		$data_ = array(
    			'default' => 0
    		);
    		
    		$this->db->where('default', '1');
    		$this->db->update('dbapp_groups', $data_); 
    	
    	} else {
    	
    		$default = 0;
    	
    	}
    
    	$data = array(
    		'name' => preg_replace("/[^a-zA-Z0-9]+/", "", $roleData['roleName']),
    		'description' => $roleData['roleName'],
    		'descr' => $roleData['roleDescription'],
    		'admin_users' => $admin_users,
    		'default' => $default
    	);
    	
    	$this->db->where('id', $roleData['roleID']);
    	$this->db->update('dbapp_groups', $data);
    	
    	//echo $this->db->last_query();
    	
    	$tempp = $this->db->from('dbapp_groups')->where('id', $roleData['roleID'])->get()->result(); 
    	
    	return $tempp[0]->name;
    
    }
    
    
    /*
    	delete a user role
    */
    
    public function deleteRole($roleID)
    {
    
    	$this->db->where('id', $roleID)->delete('dbapp_groups');
    
    }
    
    
    /*
    	applies MySQL permissions to users in a certain group
    */
    
    public function applyPermissions($permissions, $user)
    {
    
    	//drop ALL grants first
    	$this->db->query("REVOKE ALL PRIVILEGES, GRANT OPTION FROM '$user'@'".$this->db->hostname."'");
    	    
    	foreach($permissions as $db=>$array) {
    	    		
    		foreach($array as $key=>$val) {
    		
    			if($key == "create") {
    			
    				$this->db->query("GRANT CREATE ON `".$db."`.* TO '".$user."'@'".$this->db->hostname."'");
    				
    				//echo "GRANT CREATE ON ".$db.".* TO '".$user."'@'localhost'"."<br>";
    			
    			}
    			
    			if($key == "drop") {
    			
    				$this->db->query("GRANT DROP ON `".$db."`.* TO '".$user."'@'".$this->db->hostname."'");
    				
    				//echo "GRANT DROP ON ".$db.".* TO '".$user."'@'localhost'"."<br>";
    				
    			}
    			
    			if(is_array($val)) {
    			
    				//give read access to the database
    				$this->db->query("GRANT SELECT ON `".$db."`.* TO '".$user."'@'".$this->db->hostname."'");
    			
    				//individual table permissions
    				
    				foreach($val as $perm=>$val) {
    				
    					if( strtoupper($perm) != 'PRIVATE' ) {
    				
    						$this->db->query("GRANT ".strtoupper($perm)." ON `".$db."`.`".$key."` TO '".$user."'@'".$this->db->hostname."'");
    				
    						//echo "GRANT ".strtoupper($perm)." ON ".$db.".".$key." TO '".$user."'@'".$this->db->hostname."'"."<br>";
    					
    					} elseif( strtoupper($perm) == 'PRIVATE' ) {
    					
    						//user is only allowed to access his or her own data in this table, and therefor needs select access to the dbapp_users_records table
    						
    						$this->db->query("GRANT select ON `".$this->db->database."`.dbapp_users_records TO '".$user."'@'".$this->db->hostname."'");
    					
    					}
    				
    				}
    			
    			}
    		
    		}
    	
    	}
    	//die();
    	//$this->db->query('FLUSH PRIVILEGES');
    
    }
    
    public function getDefault()
    {
    
    	$query = $this->db->from('dbapp_groups')->where('default', '1')->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		$temp = $query->result();
    		
    		return $temp[0];
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
}