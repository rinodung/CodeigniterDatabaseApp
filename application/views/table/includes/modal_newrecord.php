<!-- Modal -->
<div class="modal fade" id="newRecordModal" tabindex="-1" role="dialog" aria-labelledby="recordModalLabel" aria-hidden="true">

	<div class="modal-dialog">
	
    	<div class="modal-content">
    	
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id=""><span class="fui-new"></span> <?php echo $this->lang->line('table_popup_newrecord_heading')?></h4>
      		</div>
      		
      		<div class="modal-body">
      		
      			<div id="newRecordFormWrapper">
      				<?php $this->load->view("partials/newrecordform", array('tableFields'=>$tableFields));?>
      			</div><!-- /#newRecordFormWrapper -->
        		
      		</div><!-- /.modal-body -->
      		
      		<div class="modal-footer">
      			
      			<button type="submit" class="btn btn-primary btn-embossed" id="newRecordModal_save"><?php echo $this->lang->line('table_popup_newrecord_button_createrecord')?></button>
        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><?php echo $this->lang->line('table_popup_newrecord_button_cancel')?></button>
        		
      		</div>
      		
    	</div><!-- /.modal-content -->
    	
  	</div><!-- /.modal-dialog -->
  	
</div><!-- /.modal -->