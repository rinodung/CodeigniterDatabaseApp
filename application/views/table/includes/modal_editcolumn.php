<!-- Modal -->
<form class="form-horizontal" role="form" id="columnEditForm" method="post" action="<?php echo site_url('columns/update/'.$theDB."/".$theTable);?>">
<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
<div class="modal fade" id="editColumnModal" tabindex="-1" role="dialog" aria-labelledby="columnModal" aria-hidden="true">

	<div class="modal-dialog">
	
    	<div class="modal-content">
    	
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id=""><span class="fui-list-numbered"></span> <?php echo $this->lang->line('table_popup_column_edit_column');?> <span id="theColumnName"></span></h4>
      		</div>
      		
      		<div class="modal-body">
      		
      			
      			
      			<ul class="nav nav-tabs nav-append-content">
      			 	<li class="active"><a href="#column__tab1"><?php echo $this->lang->line('table_popup_column_tab_column_details')?></a></li>
      			 	<li><a href="#column__tab3"><?php echo $this->lang->line('table_popup_column_tab_retrictions')?></a></li>
    				<li><a href="#column__tab2"><?php echo $this->lang->line('table_popup_column_tab_notes')?> <span class="label label-important" id="columnModal_notesTotal">0</span></a></li>
     			</ul> <!-- /tabs -->
      			
      			<div class="tab-content">
      			
     				<div class="tab-pane active" id="column__tab1">
      			    	
      			    	<div id="columnEditWrapper"></div>
      			    	
     				</div>
     				
     				<div class="tab-pane" id="column__tab3">
     				
     					<div class="alert alert-info">
     						<button type="button" class="close fui-cross" data-dismiss="alert"></button>
     					  	<h4><?php echo $this->lang->line('table_popup_column_retrictions_message_heading')?></h4>
     					  	<p>
     					  		<?php echo $this->lang->line('table_popup_column_retrictions_message')?>
     					  	</p>
     					  	<a href="<?php echo site_url('doc/columnrestrictions');?>" class="btn btn-info btn-wide" target="_blank"><?php echo $this->lang->line('table_popup_column_retrictions_message_button')?> <span class="fui-export"></span></a>
     					</div>
     				 	
     				 	<div id="columnRestrictionsWrapper"></div>
     				 	
     				</div>
      			
      				<div class="tab-pane" id="column__tab2">
      			    	
      			    	<div id="columnEditNotes"></div>
      			    	
      			    	<div class="clearfix" id="columnModal_newnoteform">
      			    		
      			    		<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
      			    	
      			    		<h4><?php echo $this->lang->line('table_popup_column_notes_headingnew')?></h4>
      			    			
      			    		<textarea id="columnModal_newnote" class="redactor"><?php echo $this->lang->line('table_notes_newnote_placeholder')?></textarea>
      			    			
      			    	</div>
      			    	
      				</div>
      			
     			</div> <!-- /tab-content -->
      			
      		</div><!-- /.modal-body -->
      		
      		<div class="modal-footer">
      			
      			<button type="button" class="btn btn-primary btn-embossed" id="columnModal_addnote"><?php echo $this->lang->line('table_popup_column_notes_button_addnewnote')?></button>
      			<button type="button" class="btn btn-primary btn-embossed" id="columnModal_savecolumn"><?php echo $this->lang->line('table_popup_column_notes_button_updatecolumn')?></button>
        		<button type="button" class="btn btn-default btn-embossed" id="columnModal_close" data-dismiss="modal"><?php echo $this->lang->line('table_popup_column_notes_button_closewindow')?></button>
        		
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  	
</div><!-- /.modal -->
</form>
