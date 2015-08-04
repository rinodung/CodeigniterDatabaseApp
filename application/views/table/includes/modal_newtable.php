<!-- Modal -->
<div class="modal fade" id="newTableModal" tabindex="-1" role="dialog" aria-labelledby="newTableModal" aria-hidden="true">

	<div class="modal-dialog">
	
    	<div class="modal-content">
    	
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id=""><span class="fui-list-small-thumbnails"></span> <?php echo $this->lang->line('table_popup_newtable_heading')?></h4>
      		</div>
      		
      		<div class="modal-body">
      		
      			<ul class="nav nav-tabs nav-append-content">
      				<li class="active"><a href="#build"><?php echo $this->lang->line('table_popup_newtable_tab_buildtable')?></a></li>
     				<li><a href="#import"><?php echo $this->lang->line('table_popup_newtable_tab_importdata')?></a></li>
    			</ul> <!-- /tabs -->
      			
      			<div class="tab-content">
      			
     				<div class="tab-pane active" id="build">
     				
     					<form class="form-horizontal" role="form" id="newTableForm" method="post" action="<?php echo site_url('db/newTable/'.$theDB);?>">
     					
     						<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
     						
     						<div class="form-group">
     					    	<label for="tableName" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_newtable_table_name')?> <span class="red">*</span></label>
     					    	<div class="col-sm-9">
     					      		<input type="text" class="form-control" id="tableName" name="tableName" placeholder="<?php echo $this->lang->line('table_popup_newtable_table_name_label')?>">
     					    	</div>
     					  	</div>
     					  	
     					  	<div class="form-group">
     					    	<label for="inputPassword3" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_newtable_table_columns')?> <span class="red">*</span></label>
     					    	<div class="col-sm-9 select-margin-bottom-0">
     					      		
     					      		<div class="panel-group" id="columnAccordion">
     					      			
     					      			<!-- templ -->
     					      			<div class="panel panel-default" style="display: none;" id="newColumn_templ">
     					      				<div class="panel-heading">
     					      			  		<h4 class="panel-title">
     					      			    		<a data-toggle="collapse" data-parent="#columnAccordion" href="#collapse">
     					      			      			<b><?php echo $this->lang->line('table_popup_newtable_table_column')?> 1</b> <span class="pull-right">(<?php echo $this->lang->line('shared_click_to_expand')?>)</span>
     					      			    		</a>
     					      			  		</h4>
     					      				</div>
     					      				<div id="collapse" class="panel-collapse collapse">
     					      			  		<div class="panel-body">
     					      			    		
     					      			    		<div class="form-group">
     					      			    		  	<input type="text" class="form-control columName" name="" placeholder="<?php echo $this->lang->line('table_popup_newtable_table_column_name_label')?>">
     					      			    		</div>
     					      			    		<div class="form-group">
     					      			    		  	<select name="" class="default select-block mbl columnType">
     					      			    		  		<option value=""><?php echo $this->lang->line('table_popup_column_column_type_choose')?></option>
     					      			    		  		<option value="int"><?php echo $this->lang->line('table_popup_column_column_type_number')?></option>
     					      			    		  		<option value="varchar"><?php echo $this->lang->line('table_popup_column_column_type_small_text')?></option>
     					      			    		  		<option value="text"><?php echo $this->lang->line('table_popup_column_column_type_large_text')?></option>
     					      			    		  		<option value="date"><?php echo $this->lang->line('table_popup_column_column_type_date')?></option>
     					      			    		  		<option value="select"><?php echo $this->lang->line('table_popup_column_column_type_select')?></option>
     					      			    		  		<!--<option value="blob"><?php echo $this->lang->line('table_popup_column_column_type_blob')?></option>-->
     					      			    		  	</select>
     					      			    		</div>
     					      			    		<div class="form-group" style="display: none;">
     					      			    		    <textarea class="form-control columnSelect" rows="3" id="columnSelect" name="columnSelect" placeholder="<?php echo $this->lang->line('table_popup_column_options_label')?>"></textarea>
     					      			    		</div>
     					      			    		<div class="form-group">
     					      			    			<input type="text" class="form-control columnDefault" name="" placeholder="<?php echo $this->lang->line('table_popup_column_column_default_value_label')?>">
     					      			    		</div>
     					      			    		<div class="form-group">
     					      			    			<select name="" class="default select-block mbl columnIndex" placeholder="<?php echo $this->lang->line('table_popup_column_column_index_label')?>">
     					      			    				<option value=""><?php echo $this->lang->line('table_popup_column_column_index_no_index')?></option>
     					      			    				<option value="unique"><?php echo $this->lang->line('table_popup_column_column_index_unique')?></option>
     					      			    				<option value="index"><?php echo $this->lang->line('table_popup_column_column_index_index')?></option>
     					      			    			</select>
     					      			    		</div>
     					      			    		
     					      			    		<button type="button" class="btn btn-block btn-embossed btn-sm btn-danger delCol"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('table_popup_newtable_column_remove')?></button>
     					      			    		
     					      			  		</div><!-- /.panel-body -->
     					      				</div><!-- /.panel-collape -->
     					      			</div><!-- /.panel -->
     					      			<!-- /templ -->
     					      			
     					      			<div class="panel panel-default">
     					      		    	<div class="panel-heading">
     					      		      		<h4 class="panel-title">
     					      		        		<a data-toggle="collapse" data-parent="#columnAccordion" href="#collapse1">
     					      		          			<b><?php echo $this->lang->line('table_popup_newtable_column_column')?> 1</b> <span class="pull-right">(<?php echo $this->lang->line('shared_click_to_expand')?>)</span>
     					      		        		</a>
     					      		      		</h4>
     					      		    	</div>
     					      		    	<div id="collapse1" class="panel-collapse collapse in">
     					      		      		<div class="panel-body">
     					      		      		
     					      		      			<div class="alert alert-info">
     					      		      				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
     					      		      			  	<?php echo $this->lang->line('table_popup_newtable_column_primary_message')?>
     					      		      			</div>
     					      		        		
     					      		        		<div class="form-group">
     					      		        		  	<input type="text" class="form-control columName" id="columnName" name="columns[1][columnName]" placeholder="<?php echo $this->lang->line('table_popup_column_column_name_label')?>">
     					      		        		</div>
     					      		        		<label class="checkbox" for="auto-increment">
     					      		        			<input type="checkbox" value="yes" name="auto-increment" id="auto-increment" data-toggle="checkbox" checked>
     					      		        			<?php echo $this->lang->line('table_popup_newtable_column_autoincrement?')?>  	
     						      		      		</label>
     					      		        		      			      		        			
     					      		      		</div><!-- /.panel-body -->
     					      		    	</div><!-- /.panel-collape -->
     					      		  	</div><!-- /.panel -->
     					      		  	
     					      		</div><!-- /.panel-group -->
     					      		      			      		
     					      		<a href="#" class="addColumnLink" id="addColumnLink"><span class="fui-plus"></span> <?php echo $this->lang->line('table_popup_newtable_column_add_column')?></a>
     					      		
     					    	</div><!-- /.col-sm-9 -->
     					  	</div><!-- /.form-group -->
     					  	
     					  	<?php if( $this->usermodel->hasDBPermission("create", $theDB) && !$this->ion_auth->is_admin() ):?>
     					  	<div class="form-group">
     					  	
     					  		<label for="tableName" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_newtable_permissions')?> <span class="red">*</span></label>
     					  		<div class="col-sm-9">
     					  			<label class="radio no-top-padding">
     					  				<input type="radio" name="share" id="optionsRadios1" value="private" data-toggle="radio" checked>
     					  			  	<?php echo $this->lang->line('table_popup_newtable_keep_private')?>
     					  			</label>
     					  			<label class="radio no-top-padding">
     					  			  	<input type="radio" name="share" id="optionsRadios2" value="group" data-toggle="radio">
     					  			  	<?php 
     					  			  	
     					  			  		$tempp = $this->ion_auth->get_users_groups($this->ion_auth->user()->row()->id)->result();     					  			  		
     					  			  	?>
     					  			  	<?php printf( $this->lang->line('table_popup_newtable_share_with_group'), $tempp[0]->description )?>
     					  			</label>
     					  			<label class="radio no-top-padding">
     					  			  	<input type="radio" name="share" id="optionsRadios3" value="all" data-toggle="radio">
     					  			  	<?php echo $this->lang->line('table_popup_newtable_share_with_all')?>
     					  			</label>
     					  		</div>
     					  	
     					  	</div><!-- /.form-group -->
     					  	<?php endif;?>
     					  	
     					</form>
     					
     				</div><!-- /.tab-pane -->
      			
    				<div class="tab-pane" id="import">
    				
    					<div class="alert alert-info">
    						<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    					  	<p>
    					  		<?php echo $this->lang->line('table_popup_newtable_import_message')?>
    					  	</p>
    					</div>
    				
     					<form enctype="multipart/form-data" method="post" id="uploadForm" action="<?php echo site_url("db/uploadCsv")?>">
     					
     						<div class="form-group">
     							
     							<input type="text" name="tableName" class="form-control" id="tableName" placeholder="<?php echo $this->lang->line('table_popup_newtable_import_table_name_label')?>">
     						
     						</div><!-- /.form-group -->
     					
     						<div class="form-group">
     						
     							<div class="fileinput fileinput-new" data-provides="fileinput">
     								<div class="input-group">
     									<div class="form-control uneditable-input" data-trigger="fileinput">
     										<span class="fui-clip fileinput-exists"></span>
     										<span class="fileinput-filename"></span>
     									</div>
     									<span class="input-group-btn btn-file">					    	
     										<span class="btn btn-default fileinput-new" data-role="select-file"><?php echo $this->lang->line('table_popup_import_select_file')?></span>
     										<span class="btn btn-default fileinput-exists" data-role="change">
     											<span class="fui-gear"></span>&nbsp;&nbsp;<?php echo $this->lang->line('table_popup_import_change')?>
     										</span>
     										<input type="file" name="thefile" id="thefile">
     										<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
     											<span class="fui-trash"></span>&nbsp;&nbsp;<?php echo $this->lang->line('table_popup_import_remove')?>
     										</a>					    	
     									</span>					    
     								</div><!-- /.input-group -->
     							</div><!-- /.fileinput -->
     							
     						</div><!-- /.form-group -->
     						
     						<div class="form-group">
     						
     							<label class="checkbox" for="columns">
     								<input type="checkbox" name="columns" value="yes" id="columns" data-toggle="checkbox">
     							  	<?php echo $this->lang->line('table_popup_newtable_import_first_row')?>
     							</label>
     						
     						</div><!-- /.form-group -->
     						
     						<div class="panel-group margin-bottom-15" id="accordion">
     						
     							<div class="panel panel-default">
     						    	<div class="panel-heading">
     						      		<h4 class="panel-title">
     						        		<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
     						          			<span class="fui-gear"></span> <?php echo $this->lang->line('table_popup_import_advanced_options')?>
     						        		</a>
     						      		</h4>
     						    	</div>
     						    	<div id="collapseOne" class="panel-collapse collapse">
     						      		<div class="panel-body">
     						        		
     						        		<div class="form-group">
     						        		
     						        			<label><?php echo $this->lang->line('table_popup_import_columns_separated_by')?></label>
     						        			<input type="text" class="form-control" name="separateColumns" id="separateColumns" placeholder="," value="">
     						        		
     						        		</div><!-- /.form-group -->
     						        		
     						        		<div class="form-group">
     						        		
     						        			<label><?php echo $this->lang->line('table_popup_import_columns_enclosed_by')?></label>
     						        			<input type="text" class="form-control" name="encloseColumns" id="encloseColumns" placeholder='"' value=''>
     						        		
     						        		</div><!-- /.form-group -->
     						        		
     						        		<!--<div class="form-group">
     						        		
     						        			<label>Lines terminated with ("\n", "\r\n" or "\r"):</label>
     						        			<input type="text" class="form-control" name="newLine" id="newLine" placeholder="\n" value=''>
     						        		
     						        		</div>--><!-- /.form-group -->
     						        		
     						      		</div>
     						    	</div>
     						  	</div><!-- /.panel -->
     						  
     						</div><!-- /.panel-group -->
     						
     						<?php if( $this->usermodel->hasDBPermission("create", $theDB) && !$this->ion_auth->is_admin() ):?>
     						<div class="form-group clearfix">
     						
     							<label for="tableName" class="col-sm-3 control-label"><?php echo $this->lang->line('table_popup_newtable_permissions')?> <span class="red">*</span></label>
     							<div class="col-sm-9">
     								<label class="radio no-top-padding">
     									<input type="radio" name="share" id="optionsRadios1" value="private" data-toggle="radio" checked>
     								  	<?php echo $this->lang->line('table_popup_newtable_keep_private')?>
     								</label>
     								<label class="radio no-top-padding">
     								  	<input type="radio" name="share" id="optionsRadios2" value="group" data-toggle="radio">
     								  	<?php 
     								  	
     								  		$tempp = $this->ion_auth->get_users_groups($this->ion_auth->user()->row()->id)->result();
     								  	?>
     								  	<?php printf( $this->lang->line('table_popup_newtable_share_with_group'), $tempp[0]->description )?>
     								</label>
     								<label class="radio no-top-padding">
     								  	<input type="radio" name="share" id="optionsRadios3" value="all" data-toggle="radio">
     								  	<?php echo $this->lang->line('table_popup_newtable_share_with_all')?>
     								</label>
     							</div>
     						
     						</div><!-- /.form-group -->
     						<?php endif;?>
     					
     					</form>
     					
     				</div><!-- /.tab-pane -->
     				
    			</div> <!-- /tab-content -->
      		        		
      		</div><!-- /.modal-body -->
      		
      		<div class="modal-footer">
      			
      			<button type="button" class="btn btn-primary btn-embossed" id="newTableModal_addtable"><?php echo $this->lang->line('table_popup_newtable_button_addtable')?></button>
      			<button type="button" class="btn btn-primary btn-embossed" id="newTableModal_import"><?php echo $this->lang->line('table_popup_newtable_button_import')?></button>
        		<button type="button" class="btn btn-default btn-embossed" id="newTableModal_close" data-dismiss="modal"><?php echo $this->lang->line('table_popup_newtable_button_closewindow')?></button>
        		
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  	
</div><!-- /.modal -->
