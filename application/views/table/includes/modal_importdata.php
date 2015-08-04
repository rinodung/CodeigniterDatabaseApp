<!-- Modal -->
<div class="modal fade" id="importDataModal" tabindex="-1" role="dialog" aria-labelledby="importDataModal" aria-hidden="true">

	<div class="modal-dialog">
	
    	<div class="modal-content">
    	
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id=""><span class="fui-list-small-thumbnails"></span> <?php echo $this->lang->line('table_popup_import_heading')?></h4>
      		</div>
      		
      		<div class="modal-body">
      		
      			<div class="alert alert-info">
      				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
      			  	<p>
      			  		<?php echo $this->lang->line('table_popup_import_message1')?>
      			  	</p>
      			  	<br>
      			  	<ol>
      			  		<?php echo $this->lang->line('table_popup_import_message2');?>
      			  	</ol>
      			</div>
      		
      			<form enctype="multipart/form-data" method="post" id="import_uploadForm" action="<?php echo site_url("db/importCsv")?>">
      			
      				<input type="hidden" name="tableName" value="<?php echo $theTable;?>">
      			
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
      				
      				<div class="panel-group margin-bottom-15" id="import_accordion">
      				
      					<div class="panel panel-default">
      				    	<div class="panel-heading">
      				      		<h4 class="panel-title">
      				        		<a data-toggle="collapse" data-parent="#import_accordion" href="#import_collapseOne">
      				          			<span class="fui-gear"></span> <?php echo $this->lang->line('table_popup_import_advanced_options')?>
      				        		</a>
      				      		</h4>
      				    	</div>
      				    	<div id="import_collapseOne" class="panel-collapse collapse">
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
      			
      			</form>
      			      		        		
      		</div><!-- /.modal-body -->
      		
      		<div class="modal-footer">
      			
      			<button type="button" class="btn btn-primary btn-embossed" id="importDataModal_import"><?php echo $this->lang->line('table_popup_import_button_importdata')?></button>
        		<button type="button" class="btn btn-default btn-embossed" id="importDataModal_close" data-dismiss="modal"><?php echo $this->lang->line('table_popup_import_button_closewindow')?></button>
        		
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  	
</div><!-- /.modal -->
