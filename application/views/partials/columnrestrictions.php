<div class="panel-group margin-bottom-15 columnRestrictions" id="columnRestrictions">

	<!-- templ -->
	<div class="panel panel-default template" style="display: none;" id="newRestrictionTempl">
		<div class="panel-heading">
	  		<h4 class="panel-title">
	    		<a data-toggle="collapse" data-parent="#columnRestrictions" href="#restriction1">
	      			<?php echo $this->lang->line('table_popup_column_retrictions_restriction')?> <b></b>
	    		</a>
	  		</h4>
		</div>
		<div id="" class="panel-collapse collapse in">
	  		<div class="panel-body">
	  		      			    		  		
	  			<div class="form-group">
	  				<label for="value" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_retrictions_restriction')?>: </label>
	  				<div class="col-sm-9 select-margin-bottom-0">
	    				<select class="default select-block mbl restriction">
	    					<option value=""><?php echo $this->lang->line('table_popup_column_retrictions_restriction_select')?></option>
	    					<option value="required"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_required')?></option>
	    					<option value="min_length" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_min_length')?></option>
	    					<option value="max_length" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_max_length')?></option>
	    					<option value="exact_length" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_exact_length')?></option>
	    					<option value="greater_than" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_greater_than')?></option>
	    					<option value="less_than" class="value"><?php $this->lang->line('table_popup_column_retrictions_restriction_less_than')?></option>
	    					<option value="alpha"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha')?></option>
	    					<option value="alpha_numeric"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha_numeric')?></option>
	    					<option value="alpha_dash"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha_dash')?></option>
	    					<option value="numeric"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_numeric')?></option>
	    					<option value="integer"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_integer')?></option>
	    					<option value="is_natural"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_is_natural')?></option>
	    					<option value="is_natural_no_zero"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_is_natural_no_zero')?></option>
	    					<option value="valid_email"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_email')?></option>
	    					<option value="valid_emails"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_emails')?></option>
	    					<option value="valid_ip"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_ip')?></option>
	    				</select>
	    			</div>
	    		</div>
	    		
	    		<div class="form-group">
	    			<label for="value" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_retrictions_value')?> </label>
	    			<div class="col-sm-9">
	    		  		<input type="number" id="value" value="" placeholder="Value" class="form-control value" disabled>
	    		  	</div>
	    		</div>
	    			
	    		<hr>
	    			
	    		<div class="form-group margin-bottom-0">
	    			<div class="col-sm-12">
	    				<a href="#" class="btn btn-embossed btn-sm btn-danger pull-right delRestriction"><?php echo $this->lang->line('table_popup_column_retrictions_button_remove')?></a>
	    			</div>
	    		</div><!-- /.form-group -->
	    		      			    		    		
	  		</div>
		</div>
	</div>
	<!-- /templ -->
	
	<?php if( !isset($columnRestrictions) || $columnRestrictions == false ):?>
	
	<!-- no restrictions yet -->
	
	<div class="panel panel-default">
    	<div class="panel-heading">
      		<h4 class="panel-title">
        		<a data-toggle="collapse" data-parent="#columnRestrictions" href="#restriction1">
          			<?php echo $this->lang->line('table_popup_column_retrictions_restriction')?> <b>1</b>
        		</a>
      		</h4>
    	</div>
    	<div id="" class="panel-collapse collapse in">
      		<div class="panel-body">
      			      			    	      			
      			<div class="form-group">
      				<label for="value" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_retrictions_restriction')?>: </label>
      				<div class="col-sm-9 select-margin-bottom-0">
        				<select name="restrictions[1][restriction]" class="default select-block mbl restriction">
        					<option value=""><?php echo $this->lang->line('table_popup_column_retrictions_restriction_select')?></option>
        					<option value="required"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_required')?></option>
        					<option value="min_length" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_min_length')?></option>
        					<option value="max_length" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_max_length')?></option>
        					<option value="exact_length" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_exact_length')?></option>
        					<option value="greater_than" class="value"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_greater_than')?></option>
        					<option value="less_than" class="value"><?php $this->lang->line('table_popup_column_retrictions_restriction_less_than')?></option>
        					<option value="alpha"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha')?></option>
        					<option value="alpha_numeric"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha_numeric')?></option>
        					<option value="alpha_dash"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha_dash')?></option>
        					<option value="numeric"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_numeric')?></option>
        					<option value="integer"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_integer')?></option>
        					<option value="is_natural"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_is_natural')?></option>
        					<option value="is_natural_no_zero"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_is_natural_no_zero')?></option>
        					<option value="valid_email"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_email')?></option>
        					<option value="valid_emails"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_emails')?></option>
        					<option value="valid_ip"><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_ip')?></option>
        				</select>
        			</div>
        		</div>
        		
        		<div class="form-group">
        			<label for="value" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_retrictions_value')?> </label>
        			<div class="col-sm-9">
        		  		<input type="number" name="restrictions[1][value]" id="value" value="" placeholder="Value" class="form-control value" disabled>
        		  	</div>
        		</div>
        			
        		<hr>
        		
        		<div class="form-group margin-bottom-0">
        			<div class="col-sm-12">
        				<a href="#" class="btn btn-embossed btn-sm btn-danger pull-right delRestriction"><?php echo $this->lang->line('table_popup_column_retrictions_button_remove')?></a>
        			</div>
        		</div><!-- /.form-group -->
        		      			    	        		
      		</div>
    	</div>
  	</div><!-- /.panel -->
  	
  	<?php else:?>
  	
  	<!-- show existing restrictions -->
  	
  		<?php $counter = 1;?>
  		
  		<?php foreach( $columnRestrictions as $restriction ):?>
  		
  		<div class="panel panel-default">
  			<div class="panel-heading">
  		  		<h4 class="panel-title">
  		    		<a data-toggle="collapse" data-parent="#columnRestrictions" href="#restriction1">
  		      			<?php echo $this->lang->line('table_popup_column_retrictions_restriction')?> <b><?php echo $counter?></b>
  		    		</a>
  		  		</h4>
  			</div>
  			<div id="" class="panel-collapse collapse in">
  		  		<div class="panel-body">
  		  		
  		  			<?php 
  		  			
  		  				$temp = explode("[", $restriction);
  		  				
  		  				$restriction = $temp[0];
  		  				
  		  				if( isset($temp[1]) ) {
  		  				  		  				
  		  					$value = substr($temp[1], 0, -1);
  		  				
  		  				}
  		  			
  		  			?>
  		  			      			    	      			
  		  			<div class="form-group">
  		  				<label for="value" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_retrictions_restriction')?>: </label>
  		  				<div class="col-sm-9 select-margin-bottom-0">
  		    				<select name="restrictions[<?php echo $counter?>][restriction]" class="default select-block mbl restriction">
  		    					<option value=""><?php echo $this->lang->line('table_popup_column_retrictions_restriction_select')?></option>
  		    					<option value="required" <?php if($restriction == 'required'):?>selected<?php endif;?> ><?php echo $this->lang->line('table_popup_column_retrictions_restriction_required')?></option>
  		    					<option value="min_length" class="value" <?php if($restriction == 'min_length'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_min_length')?></option>
  		    					<option value="max_length" class="value" <?php if($restriction == 'max_length'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_max_length')?></option>
  		    					<option value="exact_length" class="value" <?php if($restriction == 'exact_length'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_exact_length')?></option>
  		    					<option value="greater_than" class="value" <?php if($restriction == 'greater_than'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_greater_than')?></option>
  		    					<option value="less_than" class="value" <?php if($restriction == 'less_than'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_less_than')?></option>
  		    					<option value="alpha" <?php if($restriction == 'alpha'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha')?></option>
  		    					<option value="alpha_numeric" <?php if($restriction == 'alpha_numeric'):?>selected<?php endif;?> ><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha_numeric')?></option>
  		    					<option value="alpha_dash" <?php if($restriction == 'alpha_dash'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_alpha_dash')?></option>
  		    					<option value="numeric" <?php if($restriction == 'numeric'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_numeric')?></option>
  		    					<option value="integer" <?php if($restriction == 'integer'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_integer')?></option>
  		    					<option value="is_natural" <?php if($restriction == 'is_natural'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_is_natural')?></option>
  		    					<option value="is_natural_no_zero" <?php if($restriction == 'is_natural_no_zero'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_is_natural_no_zero')?></option>
  		    					<option value="valid_email" <?php if($restriction == 'valid_email'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_email')?></option>
  		    					<option value="valid_emails" <?php if($restriction == 'valid_emails'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_emails')?></option>
  		    					<option value="valid_ip" <?php if($restriction == 'valid_ip'):?>selected<?php endif;?>><?php echo $this->lang->line('table_popup_column_retrictions_restriction_valid_ip')?></option>
  		    				</select>
  		    			</div>
  		    		</div>
  		    		
  		    		<div class="form-group">
  		    			<label for="value" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_retrictions_value')?> </label>
  		    			<div class="col-sm-9">
  		    		  		<input type="number" name="restrictions[<?php echo $counter?>][value]" id="value" value="<?php if(isset($value)){echo $value;}?>" placeholder="Value" class="form-control value" <?php if( !isset($value) ):?>disabled<?php endif;?>>
  		    		  	</div>
  		    		</div>
  		    		
  		    		<?php 
  		    			if( isset($value) ) {
  		    			
  		    				unset($value);
  		    			
  		    			}
  		    		?>
  		    			
  		    		<hr>
  		    		
  		    		<div class="form-group margin-bottom-0">
  		    			<div class="col-sm-12">
  		    				<a href="#" class="btn btn-sm btn-embossed btn-danger pull-right delRestriction"><?php echo $this->lang->line('table_popup_column_retrictions_button_remove')?></a>
  		    			</div>
  		    		</div><!-- /.form-group -->
  		    		      			    	        		
  		  		</div>
  			</div>
  		</div><!-- /.panel -->
  		
  		<?php $counter++;?>
  		<?php endforeach;?>
  	
  	
  	<?php endif;?>
  	      			    	  	
</div><!-- /.panel-group / -->

<a href="#" class="addColumnLink margin-bottom-15 addRestrictionLink" id=""><span class="fui-plus"></span> <?php echo $this->lang->line('table_popup_column_retrictions_add_restriction')?></a>