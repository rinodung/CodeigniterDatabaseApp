<!-- Modal -->
<div class="modal fade" id="recordModal" tabindex="-1" role="dialog" aria-labelledby="recordModalLabel" aria-hidden="true">

	<div class="modal-dialog">
	
    	<div class="modal-content">
    	
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="fieldModalLabel"></h4>
      		</div>
      		
      		<div class="modal-body">
        		
        		<ul class="nav nav-tabs nav-append-content">
        			<li class="active"><a href="#recordModal_tab1"><?php echo $this->lang->line('table_popup_record_tab_recorddata')?></a></li>
        			<li><a href="#recordModal_tab2"><?php echo $this->lang->line('table_popup_record_tab_recordrevisions')?> <span class="label label-primary" id="recordModal_revisionsTotal">3</span></a></li>
        			<li><a href="#recordModal_tab3"><?php echo $this->lang->line('table_popup_record_tab_recordnotes')?> <span class="label label-important" id="recordModal_notesTotal">0</span></a></li>
       			</ul> <!-- /tabs -->
        		
        		<div class="tab-content" id="recordContent">
        		
        			<div class="tab-pane active" id="recordModal_tab1">
        			
        		    	
        			</div><!-- /#recordModal_tab1 -->
        		
        		    <div class="tab-pane" id="recordModal_tab2">
        		    
        		    	
       				</div><!-- /#recordRevisions -->
        		
        		    <div class="tab-pane" id="recordModal_tab3">
        		    	
        		    	<div id="recordNotes">
        		    	        		    		
        		    	</div><!-- /#recordNotes -->
        		    		
        		    	<form class="clearfix">
        		    	
        		    		<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
        		    			
        		    		<textarea id="recordModal_newnote" class="redactor"><?php echo $this->lang->line('table_notes_newnote_placeholder')?></textarea>
        		    			
        		    		<p class="clearfix margin-top-10">
        		    				
        		    		</p>
        		    		
        		    	</form>
        		    	
        		  	</div>
      			</div> <!-- /tab-content -->
        		
      		</div>
      		
      		<div class="modal-footer">
      			
      			<button type="button "class="btn btn-primary btn-embossed" id="recordModal_addnote"><?php echo $this->lang->line('table_popup_record_button_addnote')?></button>
      			<button type="submit" class="btn btn-primary btn-embossed" id="recordModal_save"><?php echo $this->lang->line('table_popup_record_button_update')?></button>
        		<button type="button" class="btn btn-default btn-embossed" id="recordModal_close" data-dismiss="modal"><?php echo $this->lang->line('table_popup_record_button_closewindow')?></button>
        		
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  	
</div><!-- /.modal -->