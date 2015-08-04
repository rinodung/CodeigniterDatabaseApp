<?php if( $cell['type'] == 'date' ):?>
<div class="input-group">
	<span class="input-group-btn">
  		<button class="btn" type="button"><span class="fui-calendar"></span></button>
  	</span>
  	<input type="text" name="val" class="form-control" value="<?php echo $cell['value']?>" id="datepicker-99" style="position: relative; z-index: 2000;">
</div>
<?php elseif( isset($cell['referenced_data']) ):?>

	<?php if( isset($cell['additional_data']['index']) ):?>
	<div class="alert alert-error">
		<button type="button" class="close fui-cross" data-dismiss="alert"></button>
	  	<p>
	  		<?php 
	  			printf( $this->lang->line('table_popup_cell_message_connected'), $cell['reference_table'], $cell['use_column'] )?>
	  	</p>
	</div>
	<?php endif;?>

	<select name="val">
		<?php foreach( $cell['referenced_data'] as $row ):?>
		<option value="<?php echo $row[$cell['reference_table_key']]?>" <?php if( $row[$cell['reference_table_key']] == $cell['value'] ):?>selected<?php endif;?>><?php echo $row[$cell['use_column']]?></option>
		<?php endforeach;?>
	</select>
	
<?php elseif( isset($cell['additional_data']['select']) ):?>

	<?php
		$optionArray = json_decode($cell['additional_data']['select'], true);
	?>

	<select name="val">
		<?php foreach( $optionArray as $option ):?>
		<option <?php if( $cell['value'] == $option ):?>selected<?php endif;?> value="<?php echo $option;?>"><?php echo $option;?></option>
		<?php endforeach;?>
	</select>

<?php else:?>

	<?php if( isset($cell['additional_data']['index']) && $cell['additional_data']['index'] != 'none' ):?>
	<div class="alert alert-error">
		<button type="button" class="close fui-cross" data-dismiss="alert"></button>
	  	<p>
	  		<?php printf( $this->lang->line('table_popup_cell_message_index'), $cell['additional_data']['index'] );?>
	  	</p>
	  	<?php if(isset($cell['additional_data']['auto_increment'])):?>
	  	<p>
	  		<?php echo $this->lang->line('table_popup_cell_message_autoincrement')?>
	  	</p>
	  	<?php endif;?>
	</div>
	<?php endif;?>
	
	<textarea <?php if(isset($cell['additional_data']['auto_increment'])):?>disabled<?php endif;?> id="redactorArea" class="form-control margin-bottom-15"><?php echo $cell['value']?></textarea>
	<?php if(!isset($cell['additional_data']['auto_increment'])):?>
	<label class="checkbox" for="html_<?php echo $cell['column'];?>">
	<input type="checkbox" value="" id="html#<?php echo $cell['column'];?>text" data-toggle="checkbox" onchange="redactorfy('#redactorArea')">
		<?php echo $this->lang->line('shared_html_editor_please')?>
	</label>
	<?php endif;?>

<?php endif;?>