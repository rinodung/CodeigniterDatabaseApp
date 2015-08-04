<?php foreach($notes as $note):?>
<div class="alert alert-info note clearfix">

	<div class="noteContent">
		<?php echo $note->dbapp_columnnotes_note;?>
	</div><!-- /.noteContent -->
	
	<p class=" text-left">
		
		
	 </p>
	 
	 <div class="row details">
	 	
	 	<div class="col-md-6">
	 		<?php echo $this->lang->line('table_popup_cell_notes_on')?> <b class="noteDate"><?php echo date("d M Y", $note->dbapp_columnnotes_timestamp)?></b>, <?php echo $this->lang->line('table_popup_cell_notes_by')?> <b class="noteBy"><?php echo $note->first_name?> <?php echo $note->last_name;?></b> &nbsp;&nbsp;
	 	</div>
	 	<div class="col-md-6 text-right">
	 		<?php if( $this->ion_auth->user()->row()->id == $note->dbapp_columnnotes_userid || $this->ion_auth->is_admin() ):?>
	 		<button class="btn btn-inverse btn-xs btn-embossed noteEdit"><span class="fui-new"></span> <?php echo $this->lang->line('table_popup_cell_notes_button_edit')?></button> 
	 		<button class="btn btn-danger btn-xs btn-embossed deleteColumnNote" id="columnNote_<?php echo $note->dbapp_columnnotes_id;?>"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('table_popup_cell_notes_button_delete')?></button>
	 		<?php endif;?>
	 	</div>
	 
	 </div><!-- /.row -->
	 	
	 <div class="noteUpdate row text-right">
	 	<div class="col-md-6"></div>
	 	<div class="col-md-6">
		 	<button class="btn btn-primary btn-xs btn-embossed fieldModal_savenote" id="columnNote_<?php echo $note->dbapp_columnnotes_id;?>"><?php echo $this->lang->line('table_popup_cell_notes_button_savenote')?></button>
	 		<button class="btn btn-default btn-xs btn-embossed fieldModal_canceleditnote"><?php echo $this->lang->line('table_popup_cell_notes_button_cancel')?></button>
	 	</div>
	 </div>
	
</div><!-- /.alert -->
<?php endforeach;?>