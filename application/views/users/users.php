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
    			    <li class="nav-header"><?php echo $this->lang->line('users_databased_users')?> <span class="label label-primary"><?php echo count($users)?></span></li>
    			    <?php foreach($users as $user):?>
    			    <li <?php if(isset($theUser) && $theUser->user_id == $user->id):?>class="active"<?php endif;?>>
    			    	<a href="<?php echo site_url('users/'.$user->id);?>">
    			        	<span class="fui-user"></span> <?php echo $user->first_name;?> <?php echo $user->last_name;?>
    			      	</a>
    			    </li>
    			    <?php endforeach;?>
    			</ul>
    			
    			<?php if(count($users) <= 2):?>
    			<div class="alert alert-success">
    				<button data-dismiss="alert" class="close fui-cross" type="button"></button>
    			    	<?php echo $this->lang->line('users_empty_message')?>
    			</div>
    			<?php endif;?>
    			    			
    			<a href="#newUser" data-toggle="modal" class="btn btn-inverse btn-sm btn-embossed btn-block btn-embossed"><span class="fui-plus"></span> <?php echo $this->lang->line('users_button_newuser')?></a>
    			
    		</div><!-- /.col-md-3 -->
    		<div class="col-md-9" id="mainContent">
    		
    			<!-- form errors -->
    			<?php if(validation_errors() != ''):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('users_error_heading')?></h4>
    			  	<?php echo validation_errors(); ?>
    			</div>
    			<?php endif;?>
    		
    			<?php if($this->session->flashdata('error_message')):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('users_error_heading')?></h4>
    			  	<?php echo $this->session->flashdata('error_message');?>
    			</div>
    			<?php endif;?>
    			
    			<?php if($this->session->flashdata('success_message')):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('users_success_heading')?></h4>
    			  	<?php echo $this->session->flashdata('success_message');?>
    			</div>
    			<?php endif;?>
    		
    			<?php if(isset($theUser)):?>
    			
    			<ul class="nav nav-tabs nav-append-content">
    				<li class="active"><a href="#tab1"><span class="fui-user"></span> <?php echo $this->lang->line('users_tab_userprofile')?></a></li>
    				<li><a href="#tab2"><span class="fui-gear"></span> <?php echo $this->lang->line('users_tab_more')?></a></li>
    			</ul> <!-- /tabs -->
    			
    			<div class="tab-content">
    			
    				<div class="tab-pane fade in active" id="tab1">
    				
    					<h4><?php echo $this->lang->line('users_user_profile_heading')?></h4>
    				
    					<hr>
    			    	
    			    	<form class="form-horizontal" role="form" action="<?php echo site_url('users/updateLogin/'.$theUser->user_id);?>" method="post">
    			    		<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
    			    		<div class="form-group">
    			    	    	<label for="email" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('users_user_profile_email')?> <span class="red">*</span></label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $this->lang->line('users_user_profile_email_label')?>" value="<?php echo $theUser->email;?>">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	    	<label for="password" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('users_user_profile_password')?> <span class="red">*</span></label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="password" class="form-control" name="password" id="password" placeholder="<?php echo $this->lang->line('users_user_profile_password_label')?>">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	    	<div class="col-sm-offset-3 col-sm-8">
    			    	      		<button type="submit" class="btn btn-primary btn-embossed"><?php echo $this->lang->line('users_user_profile_button_update')?></button>
    			    	    	</div>
    			    	  	</div>
    			    	</form>
    			    	
    			    	<hr>
    			    	
    			    	<form class="form-horizontal" role="form" action="<?php echo site_url('users/update/'.$theUser->user_id);?>" method="post">
    			    		<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
    			    		<div class="form-group">
    			    	    	<label for="firstname" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('users_user_profile_firstname')?> <span class="red">*</span></label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="text" class="form-control" name="firstname" id="firstname" placeholder="<?php echo $this->lang->line('users_user_profile_firstname_label')?>" value="<?php echo $theUser->first_name;?>">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	  		<label for="lastname" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('users_user_profile_lastname')?> <span class="red">*</span></label>
    			    	  		<div class="col-sm-8">
    			    	  	  		<input type="text" class="form-control" name="lastname" id="lastname" placeholder="<?php echo $this->lang->line('users_user_profile_lastname_label')?>" value="<?php echo $theUser->last_name;?>">
    			    	  		</div>
    			    	  		</div>
    			    	  	<div class="form-group">
    			    	    	<label for="company" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('users_user_profile_company')?></label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="text" class="form-control" name="company" id="company" placeholder="<?php echo $this->lang->line('users_user_profile_company_label')?>" value="<?php echo $theUser->company;?>">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	  		<label for="phone" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('users_user_profile_phone')?></label>
    			    	  		<div class="col-sm-8">
    			    	  			<input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $this->lang->line('users_user_profile_phone_label')?>" value="<?php echo $theUser->phone;?>">
    			    	  		</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	  		<label for="phone" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('users_user_profile_user_role')?> <span class="red">*</span></label>
    			    	  		<div class="col-sm-8">
    			    	  			<select name="group" class="default select-block mbl">
    			    	  				<option value=""><?php echo $this->lang->line('users_user_profile_user_role_choose')?></option>
    			    	  				<?php foreach($roles as $role):?>
    			    	  		    	<option value="<?php echo $role->id;?>" <?php if($theUser->group_id == $role->id):?>selected<?php endif;?> ><?php echo $role->description;?></option>
    			    	  		    	<?php endforeach;?>
    			    	  			</select>
    			    	  		</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	    	<div class="col-sm-offset-3 col-sm-9">
    			    	      		<button type="submit" class="btn btn-primary btn-embossed"><?php echo $this->lang->line('users_user_profile_button_update')?></button>
    			    	    	</div>
    			    	  	</div>
    			    	</form>
    			    	
    				</div><!-- /#tab1 -->

    				<div class="tab-pane fade" id="tab2">
    					
    					<h4><?php echo $this->lang->line('users_user_more_actions_heading')?></h4>
    					
    					<hr>
    					
    					<div class="alert">
    						<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    						<h4><?php printf( $this->lang->line('users_user_more_actions_delete_heading'), $theUser->first_name, $theUser->last_name )?></h4>
    						<p>
    							<?php echo $this->lang->line('users_user_more_actions_delete_message')?>
    						</p>
    						<a href="<?php echo site_url('users/delete/'.$theUser->user_id);?>" class="btn btn-danger btn-embossed"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('users_user_more_actions_button_delete')?></a>
    					</div>
    					
    				</div><!-- /.#tab2 -->
    			    			    
    			</div> <!-- /tab-content -->
    			
    			<?php endif;?>
    			
    		</div><!-- /.col-md-9 -->
    	</div><!-- /.row -->
    </div>
    <!-- /.container -->
    
    <?php $this->load->view("users/includes/modal_newuser");?>

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
    <script src="<?php echo base_url();?>js/dbapp/dbapp_users.js"></script>
  </body>
</html>
