<!-- Modal -->
<div class="modal fade" id="fieldModal" tabindex="-1" role="dialog" aria-labelledby="fieldModalLabel" aria-hidden="true">

	<div class="modal-dialog">
	
    	<div class="modal-content">
    	
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="fieldModalLabel"><span></span></h4>
      		</div>
      		
      		<div class="modal-body">
        		
        		<ul class="nav nav-tabs nav-append-content">
        			<li class="active"><a href="#fieldModalLabel_tab1"><?php echo $this->lang->line('table_popup_cell_tab_cell_data')?></a></li>
        			<li><a href="#fieldModalLabel_tab2"><?php echo $this->lang->line('table_popup_cell_tab_cell_revisions')?> <span class="label label-primary" id="fieldModal_revisionsTotal">0</span></a></li>
        			<li><a href="#fieldModalLabel_tab3"><?php echo $this->lang->line('table_popup_cell_tab_column_notes')?> <span class="label label-important" id="fieldModal_notesTotal">0</span></a></li>
       			</ul> <!-- /tabs -->
        		
        		<div class="tab-content">
        		
        			<div class="tab-pane fade in active" id="fieldModalLabel_tab1">
        		    	
        		    	<div id="cellWrapper" class="margin-bottom-15">
        		    	
        		    	</div><!-- /#cellWrapper -->
        		    	       		    	            		    	
        			</div>
        		
        		    <div class="tab-pane fade" id="fieldModalLabel_tab2">
        		    
        		    	
        		 		
       				</div>
        		
        		    <div class="tab-pane fade" id="fieldModalLabel_tab3">
        		    	
        		    	<div id="columnNotes"></div><!-- /.cellnotes -->
        		    		
        		    	<form class="clearfix" id="fieldModal_newnoteform">
        		    	
        		    		<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
        		    	
        		    		<h4><?php echo $this->lang->line('table_popup_cell_notes_heading')?></h4>
        		    			
        		    		<textarea id="fieldModal_newnote" class="redactor"><?php echo $this->lang->line('table_popup_cell_notes_newnote_placeholder')?></textarea>
        		    			
        		    	</form>
        		    	
        		  	</div>
      			</div> <!-- /tab-content -->
        		
      		</div>
      		
      		<div class="modal-footer">
      			
      			<button type="button" class="btn btn-primary btn-embossed" id="fieldModal_addnote"><?php echo $this->lang->line('table_popup_cell_button_add_new_note')?></button>
      			<button type="button" class="btn btn-primary btn-embossed" id="fieldModal_save"><?php echo $this->lang->line('table_popup_cell_button_update_data')?></button>
        		<button type="button" class="btn btn-default btn-embossed" id="fieldModal_close" data-dismiss="modal"><?php echo $this->lang->line('table_popup_cell_button_close_window')?></button>
        		
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  	
</div><!-- /.modal -->