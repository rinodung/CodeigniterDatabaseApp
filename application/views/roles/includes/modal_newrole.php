<!-- modal -->
<form class="form" role="form" method="post" action="<?php echo site_url('roles/create');?>" id="newRoleForm">
<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
<div class="modal fade" id="newRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title"><span class="fui-myspace"></span> <?php echo $this->lang->line('roles_popup_heading')?></h4>
      		</div>
      		<div class="modal-body">
      		
        		<div class="form-group">
        			<input type="text" class="form-control" name="role" id="role" placeholder="<?php echo $this->lang->line('roles_popup_role_name')?>">
        		</div>
        		
        		<div class="form-group">
        			<textarea class="form-control" name="roleDescr" id="roleDescr" placeholder="<?php echo $this->lang->line('roles_popup_description')?>" rows="3"></textarea>
        		</div>
        		
        		<div class="form-group">
        			<label class="checkbox" for="_admin_users" style="padding-top: 0px;">
        			  <input type="checkbox" value="yes" id="_admin_users" name="admin_users" data-toggle="checkbox">
        			  <?php echo $this->lang->line('roles_popup_allow_user_administration')?>
        			</label>
        		</div>
        		
        		<div class="form-group">
        			<label class="checkbox" for="default" style="padding-top: 0px;">
        			  <input type="checkbox" value="1" id="default" name="default" data-toggle="checkbox">
        			  <?php echo $this->lang->line('roles_popup_set_as_default')?>
        			</label>
        		</div>
        		
        		<hr>
        		<div class="form-group">
        		  	
        			<h6><?php echo $this->lang->line('roles_popup_heading2')?></h6>
        		  			
        		  		<div class="panel-group margin-bottom-15" id="newRole_dblist">
        		  			
        		  			<?php $counter = 0;?>
        		  				
        		  			<?php foreach($databases as $db):?>
        		  			
        		  			<div class="panel panel-default">
        		  			    <div class="panel-heading">
        		  			      	<h4 class="panel-title">
        		  			        	<a data-toggle="collapse" data-parent="#newRole_dblist" href="#db_<?php echo $counter;?>">
        		  			          		Database: <?php echo $db['db'];?>
        		  			        	</a>
        		  			      	</h4>
        		  			    </div>
        		  			    <div id="db_<?php echo $counter;?>" class="panel-collapse collapse <?php if($counter == 0):?><?php endif;?>">
        		  			      	<div class="panel-body">
        		  			      		
        		  			        	<div class="table-responsive">
        		  			        		<table class="table permissionTable">
        		  			        			<thead>
        		  			        		    	<tr>
        		  			        		      		<th style="width: 35px;">
        		  			        		      			<label class="checkbox no-label toggle-all" for="permAll">
        		  			        		      				<input type="checkbox" value="" id="permAll" data-toggle="checkbox">
        		  			        		      			</label>
        		  			        		      		</th>
        		  			        		      		<th><?php echo $this->lang->line('roles_permission')?></th>
        		  			        		    	</tr>
        		  			        		    </thead>
        		  			        		    <tbody>
        		  			        		    	<tr>
        		  			        		      		<td>
        		  			        		      			<label class="checkbox no-label" for="<?php echo $db['db']?>_create">
        		  			        		      				<input type="checkbox" value="yes" id="<?php echo $db['db']?>_create" data-toggle="checkbox" name="permissions[<?php echo $db['db']?>][create]">
        		  			        		      			</label>
        		  			        		      		</td>
        		  			        		      		<td><?php echo $this->lang->line('roles_create_tables_within_this_database')?></td>
        		  			        		    	</tr>
        		  			        		    	<tr>
        		  			        		    		<td>
        		  			        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>_drop">
        		  			        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>_drop" data-toggle="checkbox" name="permissions[<?php echo $db['db']?>][drop]">
        		  			        		    			</label>
        		  			        		    		</td>
        		  			        		    		<td><?php echo $this->lang->line('roles_delete_tables_within_this_database')?></td>
        		  			        		    	</tr>
        		  			        		    </tbody>
        		  			        		</table>
        		  			        	</div><!-- /.table-responsive -->
        		  			        		
        		  			        	<div class="panel-group" id="<?php echo $db['db']?>_tables">
        		  			        		
        		  			        		<?php if(isset($db['tables'])):?>
        		  			        			
        		  			        		<?php foreach($db['tables'] as $table):?>
        		  			        		<div class="panel panel-default">
        		  			        		    <div class="panel-heading">
        		  			        		      	<h4 class="panel-title">
        		  			        		        	<a data-toggle="collapse" data-parent="#<?php echo $db['db']?>_tables" href="#table_<?php echo $table?>">
        		  			        		          		<?php echo $this->lang->line('roles_table')?>: <?php echo $table?>
        		  			        		        	</a>
        		  			        		      	</h4>
        		  			        		    </div>
        		  			        		   	<div id="table_<?php echo $table?>" class="panel-collapse collapse">
        		  			        		      	<div class="panel-body">
        		  			        		        		
        		  			        		        	<div class="table-responsive">
        		  			        		        		<table class="table permissionTable">
        		  			        		        			<thead>
        		  			        		        		    	<tr>
        		  			        		        		      		<th style="width: 35px;">
        		  			        		        		      			<label class="checkbox no-label toggle-all" for="permAll">
        		  			        		        		      				<input type="checkbox" value="" id="permAll" data-toggle="checkbox">
        		  			        		        		      			</label>
        		  			        		        		      		</th>
        		  			        		        		      		<th><?php echo $this->lang->line('roles_permission')?></th>
        		  			        		        		    	</tr>
        		  			        		        		    </thead>
        		  			        		        		    <tbody>
        		  			        		        		    	<tr>
        		  			        		        		    		<td>
        		  			        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_select">
        		  			        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_select" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][select]" data-toggle="checkbox">
        		  			        		        		    			</label>
        		  			        		        		    		</td>
        		  			        		        		    		<td><?php echo $this->lang->line('roles_read_records_from_this_table')?></td>
        		  			        		        		    	</tr>
        		  			        		        		    	<tr>
        		  			        		        		    		<td>
        		  			        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_delete">
        		  			        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_delete" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][delete]" data-toggle="checkbox">
        		  			        		        		    			</label>
        		  			        		        		    		</td>
        		  			        		        		    		<td><?php echo $this->lang->line('roles_delete_records_from_this_table')?></td>
        		  			        		        		    	</tr>
        		  			        		        		    	<tr>
        		  			        		        		    		<td>
        		  			        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_insert">
        		  			        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_insert" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][insert]" data-toggle="checkbox">
        		  			        		        		    			</label>
        		  			        		        		    		</td>
        		  			        		        		    		<td><?php echo $this->lang->line('roles_insert_records_into_this_table')?></td>
        		  			        		        		    	</tr>
        		  			        		        		    	<tr>
        		  			        		        		    		<td>
        		  			        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_update">
        		  			        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_update" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][update]" data-toggle="checkbox">
        		  			        		        		    			</label>
        		  			        		        		    		</td>
        		  			        		        		    		<td><?php echo $this->lang->line('roles_update_records_within_this_table')?></td>
        		  			        		        		    	</tr>
        		  			        		        		    	<tr>
        		  			        		        		    		<td>
        		  			        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_alter">
        		  			        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_alter" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][alter]" data-toggle="checkbox">
        		  			        		        		    			</label>
        		  			        		        		    		</td>
        		  			        		        		    		<td><?php echo $this->lang->line('roles_addeditremove_columns_within_this_table')?></td>
        		  			        		        		    	</tr>
        		  			        		        		    	<tr>
        		  			        		        		    		<td>
        		  			        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_private">
        		  			        		        		    				<input type="checkbox" value="yes" id="" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][private]" data-toggle="checkbox">
        		  			        		        		    			</label>
        		  			        		        		    		</td>
        		  			        		        		    		<td><?php echo $this->lang->line('roles_users_can_access_only_their_own_records')?></td>
        		  			        		        		    	</tr>
        		  			        		        		    </tbody>
        		  			        		       			</table>
        		  			        		        	</div><!-- /.table-responsive -->
        		  			        		        		
        		  			        		      	</div>
        		  			        			</div>
        		  			        		</div>
        		  			        		<?php endforeach;?>
        		  			        		  	
        		  			        		<?php endif;?>
        		  			        		  	
        		  			        	</div><!-- /.panel-group -->
        		  			        		
        		  			      	</div>
        		  			    </div>
        		  			</div><!-- /.panel -->
        		  			  	
        		 			<?php $counter++;?>
        		  			  	
        		  			<?php endforeach;?>
        		  			  	            		  			 	
        				</div><!-- /.panel-group -->
        		  	
        		  	</div><!-- /.form-group -->
        		
        		
      		</div><!-- /.modal-body -->
      		<div class="modal-footer">
        		<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('roles_popup_button_savenewrole')?></a>
        		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('roles_popup_button_cancel')?></button>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>