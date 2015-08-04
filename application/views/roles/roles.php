<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("shared/head");?>
</head>
<body>

	<?php $this->load->view("shared/nav");?>
	
    <div class="container main extra-top-padding">
    
    	<div class="row">
    	
    		<div class="col-md-3 visible" id="sidebar">
    		
    			<ul class="nav nav-list margin-bottom-20">
    			    <li class="nav-header"><?php echo $this->lang->line('roles_databased_roles')?> <span class="label label-primary"><?php echo count($roles)?></span></li>
    			    <?php foreach($roles as $role):?>
    			    <li <?php if(isset($theRole) && $theRole->name == $role->name):?>class="active"<?php endif;?>>
    			    	<a href="<?php echo site_url('roles/'.$role->name);?>">
    			        	<span class="fui-myspace"></span> <?php echo $role->description;?>
    			      	</a>
    			    </li>
    			    <?php endforeach;?>
    			</ul>
    			
    			<?php if(count($roles) <= 4):?>
    			<div class="alert alert-success">
    				<button data-dismiss="alert" class="close fui-cross" type="button"></button>
    			    	<?php echo $this->lang->line('roles_empty_message')?>
    			</div>
    			<?php endif;?>
    			    			
    			<a href="#newRole" data-toggle="modal" class="btn btn-inverse btn-sm btn-embossed btn-block btn-embossed"><span class="fui-plus"></span> <?php echo $this->lang->line('roles_create_button')?></a>
    			
    		</div><!-- /.col-md-3 -->
    		<div class="col-md-9" id="mainContent">
    		
    			<?php if($this->session->flashdata('error_message')):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Ouch!</h4>
    			  	<?php echo $this->session->flashdata('error_message');?>
    			</div>
    			<?php endif;?>
    			
    			<?php if($this->session->flashdata('success_message')):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Joy!</h4>
    			  	<?php echo $this->session->flashdata('success_message');?>
    			</div>
    			<?php endif;?>
    		
    			<?php if(isset($theRole)):?>
    			<ul class="nav nav-tabs nav-append-content">
    				<li class="active"><a href="#permissionTab"><span class="fui-lock"></span> <?php echo $this->lang->line('roles_tab_database_permissions')?></a></li>
    			    <?php if($theRole->name != 'Administrator'):?>
    			    <li><a href="#moreTab"><span class="fui-gear"></span> <?php echo $this->lang->line('roles_tab_other')?></a></li>
    			    <?php endif;?>
    			</ul> <!-- /tabs -->
    			
    			<div class="tab-content">
    			
    				<div class="tab-pane active" id="permissionTab">
    				
    					<h4><?php echo $this->lang->line('roles_heading1')?></h4>
    					
    					<hr>
    					
    					<?php if($theRole->name == 'Administrator'):?>
    					<div class="alert">
    						<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    					  	<h4><?php echo $this->lang->line('roles_admin_message_heading')?></h4>
	    					<p>
	    						<?php echo $this->lang->line('roles_admin_message')?>
	    					</p>
    					</div>
    					<?php else:?>

    					<?php endif;?>
    					
    					
    					<?php
    					
    						$permissions = json_decode($theRole->permissions, true);
    						
    					
    					?>
    				
    					<form action="<?php echo site_url('roles/update');?>" method="post">
    					
    					<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
    					
    					<input type="hidden" name="roleID" value="<?php echo $theRole->id;?>">
    				
  						<div class="panel-group margin-bottom-15" id="role_dblist">
  								
  								<?php $counter = 0;?>
  									
  								<?php foreach($databases as $db):?>
  								
  								<div class="panel panel-default">
  								    <div class="panel-heading">
  								      	<h4 class="panel-title">
  								        	<a data-toggle="collapse" data-parent="#role_dblist" href="#db__<?php echo $counter;?>">
  								          		Database: <?php echo $db['db'];?> <span class="pull-right"><?php echo $this->lang->line('shared_click_to_expand')?></span>
  								        	</a>
  								      	</h4>
  								    </div>
  								    <div id="db__<?php echo $counter;?>" class="panel-collapse collapse">
  								      	<div class="panel-body">
  								      		
  								        	<div class="table-responsive">
  								        		<table class="table permissionTable">
  								        			<thead>
  								        		    	<tr>
  								        		      		<th style="width: 35px;">
  								        		      			<label class="checkbox no-label toggle-all" for="permAll">
  								        		      				<input type="checkbox" value="" id="permAll" data-toggle="checkbox" <?php if($theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		      			</label>
  								        		      		</th>
  								        		      		<th><?php echo $this->lang->line('roles_permission')?></th>
  								        		    	</tr>
  								        		    </thead>
  								        		    <tbody>
  								        		    	<tr>
  								        		      		<td>
  								        		      			<label class="checkbox no-label" for="<?php echo $db['db']?>_create">
  								        		      				<input type="checkbox" value="yes" id="<?php echo $db['db']?>_create" data-toggle="checkbox" name="permissions[<?php echo $db['db']?>][create]" <?php if(isset($permissions[$db['db']]['create']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		      			</label>
  								        		      		</td>
  								        		      		<td><?php echo $this->lang->line('roles_create_tables_within_this_database')?></td>
  								        		    	</tr>
  								        		    	<tr>
  								        		    		<td>
  								        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>_drop">
  								        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>_drop" data-toggle="checkbox" name="permissions[<?php echo $db['db']?>][drop]" <?php if(isset($permissions[$db['db']]['drop']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		    			</label>
  								        		    		</td>
  								        		    		<td><?php echo $this->lang->line('roles_delete_tables_within_this_database')?></td>
  								        		    	</tr>
  								        		    </tbody>
  								        		</table>
  								        	</div><!-- /.table-responsive -->
  								        		
  								        	<div class="panel-group" id="<?php echo $db['db']?>__tables">
  								        		
  								        		<?php if(isset($db['tables'])):?>
  								        			
  								        		<?php foreach($db['tables'] as $table):?>
  								        		<div class="panel panel-default">
  								        		    <div class="panel-heading">
  								        		      	<h4 class="panel-title">
  								        		        	<a data-toggle="collapse" data-parent="#<?php echo $db['db']?>__tables" href="#<?php echo $db['db']?>__<?php echo $table?>">
  								        		          		<?php echo $this->lang->line('roles_table')?>: <?php echo $table?>
  								        		        	</a>
  								        		      	</h4>
  								        		    </div>
  								        		   	<div id="<?php echo $db['db']?>__<?php echo $table?>" class="panel-collapse collapse">
  								        		      	<div class="panel-body">
  								        		        		
  								        		        	<div class="table-responsive">
  								        		        		<table class="table permissionTable">
  								        		        			<thead>
  								        		        		    	<tr>
  								        		        		      		<th style="width: 35px;">
  								        		        		      			<label class="checkbox no-label toggle-all" for="permAll">
  								        		        		      				<input type="checkbox" value="" id="permAll" data-toggle="checkbox" <?php if($theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		        		      			</label>
  								        		        		      		</th>
  								        		        		      		<th><?php echo $this->lang->line('roles_permission')?></th>
  								        		        		    	</tr>
  								        		        		    </thead>
  								        		        		    <tbody>
  								        		        		    	<tr>
  								        		        		    		<td>
  								        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_select">
  								        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_select" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][select]" data-toggle="checkbox" <?php if(isset($permissions[$db['db']][$table]['select']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		        		    			</label>
  								        		        		    		</td>
  								        		        		    		<td><?php echo $this->lang->line('roles_read_records_from_this_table')?></td>
  								        		        		    	</tr>
  								        		        		    	<tr>
  								        		        		    		<td>
  								        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_delete">
  								        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_delete" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][delete]" data-toggle="checkbox" <?php if(isset($permissions[$db['db']][$table]['delete']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		        		    			</label>
  								        		        		    		</td>
  								        		        		    		<td><?php echo $this->lang->line('roles_delete_records_from_this_table')?></td>
  								        		        		    	</tr>
  								        		        		    	<tr>
  								        		        		    		<td>
  								        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_insert">
  								        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_insert" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][insert]" data-toggle="checkbox" <?php if(isset($permissions[$db['db']][$table]['insert']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		        		    			</label>
  								        		        		    		</td>
  								        		        		    		<td><?php echo $this->lang->line('roles_insert_records_into_this_table')?></td>
  								        		        		    	</tr>
  								        		        		    	<tr>
  								        		        		    		<td>
  								        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_update">
  								        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_update" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][update]" data-toggle="checkbox" <?php if(isset($permissions[$db['db']][$table]['update']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		        		    			</label>
  								        		        		    		</td>
  								        		        		    		<td><?php echo $this->lang->line('roles_update_records_within_this_table')?></td>
  								        		        		    	</tr>
  								        		        		    	<tr>
  								        		        		    		<td>
  								        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_alter">
  								        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_alter" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][alter]" data-toggle="checkbox" <?php if(isset($permissions[$db['db']][$table]['alter']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
  								        		        		    			</label>
  								        		        		    		</td>
  								        		        		    		<td><?php echo $this->lang->line('roles_addeditremove_columns_within_this_table')?></td>
  								        		        		    	</tr>
  								        		        		    	<tr>
  								        		        		    		<td>
  								        		        		    			<label class="checkbox no-label" for="<?php echo $db['db']?>.<?php echo $table?>_private">
  								        		        		    				<input type="checkbox" value="yes" id="<?php echo $db['db']?>.<?php echo $table?>_alter" name="permissions[<?php echo $db['db']?>][<?php echo $table?>][private]" data-toggle="checkbox" <?php if(isset($permissions[$db['db']][$table]['private']) || $theRole->name == 'Administrator'):?>checked<?php endif;?>>
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
  						
  						<?php if($theRole->name != 'Administrator'):?>
  						<div class="form-group">
  							<button type="submit" class="btn btn-primary btn-embossed"><?php echo $this->lang->line('roles_button_save_permissions')?></button>
  						</div>
  						<?php endif;?>
  						
  						</form>
  						
   					</div><!-- /#permissionTab -->
    			
    				<?php if($theRole->name != 'Administrator'):?>
   					<div class="tab-pane" id="moreTab">
   					
   						<h4><?php echo $this->lang->line('roles_heading2')?></h4>
   						
   						<hr>
   						
   						<form class="form-horizontal" role="form" action="<?php echo site_url('roles/update');?>" method="post">
   							<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
   							<input type="hidden" name="roleID" value="<?php echo $theRole->id;?>">
   							<div class="form-group">
   						    	<label for="roleName" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('roles_role_name')?> <span class="red">*</span></label>
   						    	<div class="col-sm-8">
   						      		<input type="text" class="form-control" name="roleName" id="roleName" placeholder="<?php echo $this->lang->line('roles_role_name_label')?>" value="<?php echo $theRole->description;?>">
   						    	</div>
   						  	</div>
   						  	<div class="form-group">
   						  		<label for="roleDescription" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('roles_description')?> </label>
   						  		<div class="col-sm-8">
   						  			<textarea class="form-control" rows="4" name="roleDescription" id="roleDescription" placeholder="<?php echo $this->lang->line('roles_description_label')?>"><?php echo $theRole->descr;?></textarea>
   						  		</div>
   						  	</div>
   						  	<div class="form-group">
   						  		<div class="col-sm-offset-1 col-sm-2"></div>
   						  		<div class="col-sm-8">
   						  			<label class="checkbox" for="admin_users" style="padding-top: 0px;">
   						  			  <input type="checkbox" value="yes" id="admin_users" name="admin_users" data-toggle="checkbox" <?php if($theRole->admin_users == 1):?>checked<?php endif;?>>
   						  			  <?php echo $this->lang->line('roles_allow_user_administration?')?>
   						  			</label>
   						  		</div>
   						  	</div>
   						  	<div class="form-group">
   						  		<div class="col-sm-offset-1 col-sm-2"></div>
   						  		<div class="col-sm-8">
   						  			<label class="checkbox" for="default" style="padding-top: 0px;">
   						  			  <input type="checkbox" value="1" id="default" name="default" data-toggle="checkbox" <?php if($theRole->default == 1):?>checked<?php endif;?>>
   						  			  <?php echo $this->lang->line('roles_set_as_default_role?')?>
   						  			</label>
   						  		</div>
   						  	</div>
   						  	<div class="form-group">
   						    	<div class="col-sm-offset-3 col-sm-8">
   						      		<button type="submit" class="btn btn-primary btn-embossed"><?php echo $this->lang->line('roles_button_update_role')?></button>
   						    	</div>
   						  	</div>
   						</form>
   						
   						<hr>
   						
   						<br>
   						
   						<div class="alert">
   							<button type="button" class="close fui-cross" data-dismiss="alert"></button>
   							<h4><?php echo $this->lang->line('roles_delete_message_heading')?></h4>
   							<?php if( isset($defaultRole) && $theRole->id != $defaultRole->id ):?>
   								<p>
   									<?php echo $this->lang->line('roles_delete_message1')?>
   								</p>
   								<a href="<?php echo site_url('roles/delete/'.$theRole->id);?>" class="btn btn-danger btn-embossed"><?php echo $this->lang->line('roles_delete_message_confirm')?></a>
   							<?php else:?>
   								
   								<?php if( isset($defaultRole) && $theRole->id == $defaultRole->id ):?>
   								<p><?php echo $this->lang->line('roles_delete_message2')?></p>
   								<?php else:?>
   								<p>
   									<?php echo $this->lang->line('roles_delete_message3')?>
   								</p>
   								<?php endif;?>
   								
   							<?php endif;?>
   						</div>
   						
   					</div><!-- /#moreTab -->
   					<?php endif;?>
    			
  				</div> <!-- /tab-content -->
  				
  				<?php endif;?>
    			
    		</div><!-- /.col-md-9 -->
    	</div><!-- /.row -->
    </div>
    <!-- /.container -->
    
    <?php $this->load->view("roles/includes/modal_newrole");?>

    <!-- Load JS here for greater good =============================-->
    <script src="<?php echo base_url();?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-select.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-switch.js"></script>
    <script src="<?php echo base_url();?>js/flatui-checkbox.js"></script>
    <script src="<?php echo base_url();?>js/flatui-radio.js"></script>
    <script src="<?php echo base_url();?>js/jquery.tagsinput.js"></script>
    <script src="<?php echo base_url();?>js/jquery.placeholder.js"></script>
    <script src="<?php echo base_url();?>js/application.js"></script>
    <script src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>js/TableTools.min.js"></script>
    <script src="<?php echo base_url();?>js/ZeroClipboard.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-datatables.js"></script>
    <script src="<?php echo base_url();?>js/datatables.plugins.js"></script>
    <script src="<?php echo base_url();?>assets/redactor/redactor.js"></script>
    <script src="<?php echo base_url();?>js/dbapp/dbapp_roles.js"></script>
  </body>
</html>
