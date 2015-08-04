<!-- Modal -->
<form class="form-horizontal" role="form" method="post" action="<?php echo site_url('columns/addColumn/'.$theDB."/".$theTable);?>" id="newColumnForm">
<div class="modal fade" id="newColumnModal" tabindex="-1" role="dialog" aria-labelledby="newColumnModal" aria-hidden="true">

	<div class="modal-dialog">
	
    	<div class="modal-content">
    	
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="fieldModalLabel"><span class="fui-list-numbered"></span> <?php echo $this->lang->line('table_popup_newcolumn_heading')?></h4>
      		</div>
      		
      		<div class="modal-body">
      		
      			<ul class="nav nav-tabs nav-append-content">
      				<li class="active"><a href="#newColumnModal_tab1"><?php echo $this->lang->line('table_popup_newcolumn_tab_column_details')?></a></li>
      				<li><a href="#newColumnModal_tab2"><?php echo $this->lang->line('table_popup_newcolumn_tab_column_restrictions')?></a></li>
      			</ul> <!-- /tabs -->
      			
      			<div class="tab-content">
      			
      				<div class="tab-pane fade in active" id="newColumnModal_tab1">
      			    	
      			    	<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
      			    		
      			    	<div class="form-group">
      			    	   	<label for="columnName" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_column_name')?> <span class="red">*</span></label>
      			    	    <div class="col-sm-9">
      			    	      	<input type="text" class="form-control" id="columnName" name="columnName" placeholder="<?php echo $this->lang->line('table_popup_column_column_name_label')?>">
      			    	    </div>
      			   		</div>
      			  		<div class="form-group">
      			    		<label for="columnType" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_column_type')?> <span class="red">*</span></label>
      			    	   	<div class="col-sm-9 select-margin-bottom-0">
      			    	      	<select name="columnType" class="default select-block mbl">
      			    	      		<option value=""><?php echo $this->lang->line('table_popup_column_column_type_choose')?></option>
      			    	      		<option value="int"><?php echo $this->lang->line('table_popup_column_column_type_number')?></option>
									<option value="double"><?php echo $this->lang->line('table_popup_column_column_type_decimal')?></option>
      			    	      		<option value="varchar"><?php echo $this->lang->line('table_popup_column_column_type_small_text')?></option>
      			    	      		<option value="text"><?php echo $this->lang->line('table_popup_column_column_type_large_text')?></option>
      			    	      		<option value="date"><?php echo $this->lang->line('table_popup_column_column_type_date')?></option>
      			    	      		<option value="select"><?php echo $this->lang->line('table_popup_column_column_type_select')?></option>
      			    	      		<!--<option value="blob"><?php echo $this->lang->line('table_popup_column_column_type_blob')?></option>-->
      			    	      	</select>
      			    	    </div>
      			  		</div>
      			  		<div class="form-group" style="display: none;">
      			  			<label for="columnSelect" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_options')?> <span class="red">*</span></label>
      			  		 	<div class="col-sm-9 select-margin-bottom-0">
      			  		    	<textarea class="form-control" rows="3" id="columnSelect" name="columnSelect" placeholder="<?php echo $this->lang->line('table_popup_column_options_label')?>"></textarea>
      			  		  </div>
      			  		</div>
      			    	<div class="form-group">
      			    	  	<label for="columnDefault" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_column_default_value')?></label>
      			    	  	<div class="col-sm-9">
      			    	  	  	<input type="text" class="form-control" id="columnDefault" name="columnDefault" placeholder="<?php echo $this->lang->line('table_popup_column_column_default_value_label')?>">
      			    	  	</div>
      			 		</div>
      			    	<div class="form-group">
      			    		<label for="columnIndex" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_column_index')?></label>
      			    	  	<div class="col-sm-9 select-margin-bottom-0">
      			    	  		<select name="columnIndex" class="default select-block mbl">
      			    	  			<option value=""><?php echo $this->lang->line('table_popup_column_column_index_no_index')?></option>
      			    	  			<?php if( !isset($hasPrimary) ):?>
      			    	  			<option value="primary"><?php echo $this->lang->line('table_popup_column_column_index_primary_key')?></option>
      			    	  			<?php endif;?>
      			    	  			<?php if( $nrOfFields == 0 ):?>
      			    	  			<option value="unique"><?php echo $this->lang->line('table_popup_column_column_index_unique')?></option>
      			    	  			<?php endif;?>
      			    	  			<option value="index"><?php echo $this->lang->line('table_popup_column_column_index_index')?></option>
      			    	  		</select>
      			    	  	</div>
      			  		</div>
      			    	<div class="form-group">
      			    		<label for="columnOffset" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_column_position')?> <span class="red">*</span></label>
      			    	  	<div class="col-sm-9 select-margin-bottom-0">
      			    	  		<select name="columnOffset" class="default select-block mbl">
      			    	  			<option value=""><?php echo $this->lang->line('table_popup_column_column_position_insert')?></option>
      			    	  			<option value="end"><?php echo $this->lang->line('table_popup_column_column_position_at_end')?></option>
      			    	  			<?php $counter = 0;?>
      			    	  				
      			    	  			<?php foreach($tableFields as $field):?>
      			    	  			<option value="offset_<?php echo $counter;?>"><?php echo $this->lang->line('table_popup_column_column_position_after')?> <?php echo $field['field'];?></option>
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
      			    	  		<?php echo $this->lang->line('table_popup_column_connection_warning2')?>
      			    	  	</p>
      			    	</div>
      			    	  	
      			    	<div class="form-group">
      			    	  	<label for="connectTo" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_column_connect_to')?> </label>
      			    	  	<div class="col-sm-9 select-margin-bottom-0">
      			    	  		<select name="connectTo" class="default select-block mbl">
      			    	  			<option value=""><?php echo $this->lang->line('table_popup_column_connect_to_none')?></option>
      			    	  				
      			    	  			<?php foreach( $tabless as $table_=>$rows ):?>
      			    	  				
      			    	  				<?php if( $table_ != $theTable ):?>
      			    	  				
      			    	  					<?php foreach( $rows as $row ):?>
      			    	  						
      			    	  						<option value="<?php echo $table_;?>.<?php echo $row['field'];?>"><?php echo $table_;?> => <?php echo $row['field'];?></option>
      			    	  					
      			    	  					<?php endforeach;?>
      			    	  					
      			    	  				<?php endif;?>
      			    	  				
      			    	  			<?php endforeach;?>
      			    	  				
      			    	  		</select>
      			    	  	</div>
      			   		</div>
      			    	  	
      			   		<?php endif;?>
      			    	       		    	            		    	
      				</div>
      			
      			    <div class="tab-pane fade" id="newColumnModal_tab2">
      			    
      			    	<div class="alert alert-info">
      			    		<button type="button" class="close fui-cross" data-dismiss="alert"></button>
      			    	  	<h4><?php echo $this->lang->line('table_popup_column_retrictions_message_heading')?></h4>
      			    	  	<p>
      			    	  		<?php echo $this->lang->line('table_popup_column_retrictions_message')?>
      			    	  	</p>
      			    	  	<a href="<?php echo site_url('doc/columnrestrictions');?>" class="btn btn-info btn-wide" target="_blank"><?php echo $this->lang->line('table_popup_column_retrictions_message_button')?> <span class="fui-export"></span></a>
      			    	</div>
      			    
      			    	<?php $this->load->view("partials/columnrestrictions");?>
      			    	      			 		
      				</div>
      			
      			</div> <!-- /tab-content -->
        		
      		</div><!-- /.modal-body -->
      		
      		<div class="modal-footer">
      			
      			<button type="button" class="btn btn-primary btn-embossed" id="newColumnModal_addcolumn"><?php echo $this->lang->line('table_popup_newcolumn_button_addcolumn')?></button>
        		<button type="button" class="btn btn-default btn-embossed" id="newColumnModal_close" data-dismiss="modal"><?php echo $this->lang->line('table_popup_newcolumn_button_closewindow')?></button>
        		
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  	
</div><!-- /.modal -->
</form>
