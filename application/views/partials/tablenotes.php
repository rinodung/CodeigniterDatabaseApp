<?php foreach($tableNotes as $tableNote):?>
<div class="alert alert-info note clearfix" id="">

	<div class="noteContent">
		<?php echo $tableNote->dbapp_tablenotes_note;?>
	</div><!-- /.noteContent -->
	
	<div class="row details">
		
		<div class="col-md-6">
			on <b class="noteDate"><?php echo date("d M Y", $tableNote->dbapp_tablenotes_timestamp)?></b>, by <b class="noteBy"><?php echo $tableNote->first_name?> <?php echo $tableNote->last_name;?></b> &nbsp;&nbsp;
		</div>
		<div class="col-md-6 text-right">
			<?php if( $this->ion_auth->user()->row()->id == $tableNote->dbapp_tablenotes_userid || $this->ion_auth->is_admin() ):?>
			<button class="btn btn-inverse btn-xs btn-embossed noteEdit"><span class="fui-new"></span> <?php echo $this->lang->line('table_notes_button_edit')?></button> 
			<button class="btn btn-danger btn-xs btn-embossed deleteTableNote" id="tableNote_<?php echo $tableNote->dbapp_tablenotes_id;?>"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('table_notes_button_delete')?></button>
			<?php endif;?>
		</div>
	
	</div><!-- /.row -->
		
	<div class="noteUpdate row text-right">
		<div class="col-md-6"></div>
		<div class="col-md-6">
		 	<button class="btn btn-primary btn-xs btn-embossed table_savenote" id="tableNote_<?php echo $tableNote->dbapp_tablenotes_id;?>"><?php echo $this->lang->line('table_notes_button_savenote')?></button>
			<button class="btn btn-default btn-xs btn-embossed table_canceleditnote"><?php echo $this->lang->line('table_notes_button_cancel')?></button>
		</div>
	</div>
	
</div><!-- /.alert -->
<?php endforeach;?>