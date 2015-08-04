

	<input type="hidden" name="columnName_old" value="<?php if( isset($columnDetails) ) { echo $columnDetails['name']; }?>">
	
	<div class="form-group">
    	<label for="columnName" class="col-sm-4 control-label"><?php echo $this->lang->line('table_popup_column_column_name')?> <span class="red">*</span></label>
    	<div class="col-sm-8">
      		<input type="text" class="form-control" id="columnName" name="columnName" placeholder="<?php echo $this->lang->line('table_popup_column_column_name_label')?>" value="<?php if( isset($columnDetails) ) { echo $columnDetails['name']; }?>">
    	</div>
  	</div>
  	<div class="form-group">
    	<label for="columnType" class="col-sm-4 control-label"><?php echo $this->lang->line('table_popup_column_column_type')?> <span class="red">*</span></label>
    	<div class="col-sm-8 select-margin-bottom-0">
      		<select name="columnType" class="default select-block mbl">
      			<option value=""><?php echo $this->lang->line('table_popup_column_column_type_choose')?></option>
      		    <option value="int" <?php if( $columnDetails['type'] == 'int' || $columnDetails['type'] == 'tinyint' || $columnDetails['type'] == 'smallint' || $columnDetails['type'] == 'mediumint' || $columnDetails['type'] == 'bigint' || $columnDetails['type'] == 'float' || $columnDetails['type'] == 'decimal' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_column_type_number')?></option>
				<option value="double" <?php if( $columnDetails['type'] == 'double' ):?>selected<?php endif;?> ><?php echo $this->lang->line('table_popup_column_column_type_decimal')?></option>
      		    <option value="varchar" <?php if( $columnDetails['type'] == 'varchar' && !isset($columnDetails['select']) ):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_column_type_small_text')?></option>
      		    <?php if( $columnDetails['index'] == 'none' || $columnDetails['index'] == '' ):?>
      		    <option value="text" <?php if( $columnDetails['type'] == 'text' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_column_type_large_text')?></option>
      		    <option value="date" <?php if( $columnDetails['type'] == 'date' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_column_type_date')?></option>
      		    <option value="select" <?php if( $columnDetails['type'] == 'varchar' && isset($columnDetails['select']) ):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_column_type_select')?></option>
      		    <option value="blob" <?php if( $columnDetails['type'] == 'blob' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_column_type_blob')?></option>
      		    <?php endif;?>
      		</select>
    	</div>
  	</div>
  	<div class="form-group" <?php if( !isset($columnDetails['select']) ):?>style="display: none;"<?php endif;?> >
  		<label for="columnSelect" class="col-sm-4 control-label"><?php echo $this->lang->line('table_popup_column_options')?> <span class="red">*</span></label>
  	 	<div class="col-sm-8 select-margin-bottom-0">
  	 		<?php
  	 			
  	 			if( isset($columnDetails['select']) ) {
  	 				
  	 				$optionArray = json_decode($columnDetails['select'], true);
  	 				$imploded = implode("\n", $optionArray);
  	 			
  	 			} else {
  	 			
  	 				$imploded = '';
  	 			
  	 			}
  	 			
  	 		?>
  	    	<textarea class="form-control" rows="3" id="columnSelect" name="columnSelect" placeholder="<?php echo $this->lang->line('table_popup_column_options_label')?>"><?php echo $imploded;?></textarea>
  	  </div>
  	</div>
  	<div class="form-group">
  		<label for="columnDefault" class="col-sm-4 control-label"><?php echo $this->lang->line('table_popup_column_column_default_value')?></label>
  		<div class="col-sm-8">
  	  		<input type="text" class="form-control" id="columnDefault" name="columnDefault" placeholder="<?php echo $this->lang->line('table_popup_column_column_default_value_label')?>" value="<?php if( isset($columnDetails) ) { echo $columnDetails['default']; }?>">
  		</div>
  	</div>
  	<?php if( $columnDetails['type'] != 'text' && $columnDetails['type'] != 'blob' ):?>
  	<div class="form-group">
  		<label for="columnIndex" class="col-sm-4 control-label"><?php echo $this->lang->line('table_popup_column_column_index')?></label>
  		<div class="col-sm-8 select-margin-bottom-0">
  			<select name="columnIndex" class="default select-block mbl">
  				<option value=""><?php echo $this->lang->line('table_popup_column_column_index_no_index')?></option>
  				<?php if( $columnDetails['index'] == 'primary' || !isset($hasPrimary) ):?>
  			    <option value="primary" <?php if( $columnDetails['index'] == 'primary' ):?>selected<?php endif;?> ><?php echo $this->lang->line('table_popup_column_column_index_primary_key')?></option>
  			    <?php endif;?>
  			    <option value="unique" <?php if( $columnDetails['index'] == 'unique' ):?>selected<?php endif;?> ><?php echo $this->lang->line('table_popup_column_column_index_unique')?></option>
  			    <option value="index" <?php if( $columnDetails['index'] == 'index' ):?>selected<?php endif;?> ><?php echo $this->lang->line('table_popup_column_column_index_index')?></option>
  			</select>
  		</div>
  	</div>
  	<?php endif;?>
  	<div class="form-group">
  		<label for="columnOffset" class="col-sm-4 control-label"><?php echo $this->lang->line('table_popup_column_column_position')?> <span class="red">*</span></label>
  		<div class="col-sm-8 select-margin-bottom-0">
  			<select name="columnOffset" class="default select-block mbl">
  				<option value=""><?php echo $this->lang->line('table_popup_column_column_position_insert')?></option>
  			    <option value="offset_-1" <?php if( $columnDetails['offset'] == "0" ):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_column_position_at_front')?></option>
  			    <?php $counter = 0;?>
  			    
  			    <?php foreach($tableFields as $field):?>
  			    
  			    	<?php if($field['field'] != $columnDetails['name']):?>
  			    	<option value="offset_<?php echo $counter;?>" <?php if( (($counter+1) == $columnDetails['offset']) || ($counter == 0 && $columnDetails['offset'] == 0) ):?>selected<?php endif;?> ><?php echo $this->lang->line('table_popup_column_column_position_after')?> <?php echo $field['field'];?></option>
  			    	<?php endif;?>
  			    	
  			    	<?php $counter++;?>
  			    	
  			    <?php endforeach?>
  			</select>
  		</div>
  	</div>
  	
  	<?php if( $table_engine == 'InnoDB' ):?>
  	
  	<hr>
  	
  	<div class="alert alert-error">
  		<button type="button" class="close fui-cross" data-dismiss="alert"></button>
  		<h4><span class="fui-alert"></span> <?php echo $this->lang->line('table_popup_column_connection_warning_heading')?></h4>
  	  	<p>
  	  		<?php echo $this->lang->line('table_popup_column_connection_warning1')?>
  	  	</p>
  	  	<p>
  	  		<?php echo $this->lang->line('table_popup_column_connection_warning2');?>
  	  	</p>
  	</div>
  	
  	<div class="form-group">
  		<label for="connectTo" class="col-sm-4 control-label"><?php echo $this->lang->line('table_popup_column_connect_to')?> </label>
  		<div class="col-sm-8 select-margin-bottom-0">
  			<?php //print_r($tables);
  				//echo $columnDetails['foreign_key']['foreign_key'];
  			?>
  			<select name="connectTo" class="default select-block mbl">
  				<option value=""><?php echo $this->lang->line('table_popup_column_connect_to_none')?></option>
  				
  				<?php foreach( $tables as $table_=>$rows ):?>
  				
  					<?php if( $table_ != $table ):?>
  				
  						<?php foreach( $rows as $row ):?>
  						
  							<?php
  								if( isset($columnDetails['foreign_key']) ) {
  								
  									$temp = explode(".", $columnDetails['foreign_key']['foreign_key']);
  									
  									if( $temp[0] == $table_ && $columnDetails['foreign_key']['use_column'] == $row['field'] ) {
  									
  										$selected = 'yes';
  									
  									} else {
  									
  										$selected = 'no';
  									
  									}
  								
  								} else {
  								
  									$selected = 'no';
  								
  								}
  							?>
  					
  							<option value="<?php echo $table_;?>.<?php echo $row['field'];?>" <?php if( $selected == 'yes' ):?>selected<?php endif;?> ><?php echo $table_;?> => <?php echo $row['field'];?></option>
  					
  						<?php endforeach;?>
  					
  					<?php endif;?>
  				
  				<?php endforeach;?>
  				
  			</select>
  		</div>
  	</div>
  	
  	<?php endif;?>
  	