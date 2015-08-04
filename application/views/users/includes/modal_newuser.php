<!-- modal -->
<form class="form" role="form" method="post" action="<?php echo site_url('users/create');?>" id="newUserForm">
<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title"><span class="fui-user"></span> <?php echo $this->lang->line('users_user_popup_heading')?></h4>
      		</div>
      		<div class="modal-body">
      		
        		<div class="form-group">
        			<input type="text" class="form-control" name="firstname" id="firstname" placeholder="<?php echo $this->lang->line('users_user_popup_first_name_label')?>">
        		</div>
        		<div class="form-group">
        			<input type="text" class="form-control" name="lastname" id="lastname" placeholder="<?php echo $this->lang->line('users_user_popup_last_name_label')?>">
        		</div>
        		<div class="form-group">
        			<input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $this->lang->line('users_user_popup_email_label')?>">
        		</div>
        		<div class="form-group">
        			<input type="password" class="form-control" name="password" id="password" placeholder="<?php echo $this->lang->line('users_user_popup_password_label')?>">
        		</div>
        		<div class="form-group">
        			<input type="text" class="form-control" name="company" id="company" placeholder="<?php echo $this->lang->line('users_user_popup_company_label')?>">
       			</div>
       			<div class="form-group">
       				<input type="text" class="form-control" name="phone" id="phone" placeholder="<?php echo $this->lang->line('users_user_popup_phone_label')?>">
       			</div>
        		<div class="form-group">
        			<select name="group" id="group" class="default select-block mbl">
        				<option value=""><?php echo $this->lang->line('users_user_popup_choose_role')?></option>
        			    <?php foreach($roles as $role):?>
        			    <option value="<?php echo $role->id;?>"><?php echo $role->description;?></option>
        			    <?php endforeach;?>
        			</select>
       			</div>
       			        		
      		</div><!-- /.modal-body -->
      		<div class="modal-footer">
        		<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('users_user_popup_button_createuser')?></a>
        		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('users_user_popup_button_cancel')?></button>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>