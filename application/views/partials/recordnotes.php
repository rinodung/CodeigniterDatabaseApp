<?php foreach($notes as $note):?>
<div class="alert alert-info note clearfix">

	<div class="noteContent">
		<?php echo $note->dbapp_recordnotes_note;?>
	</div><!-- /.noteContent -->
	
	<p class=" text-left">
		
		
	 </p>
	 
	 <div class="row details">
	 	
	 	<div class="col-md-6">
	 		on <b class="noteDate"><?php echo date("d M Y", $note->dbapp_recordnotes_timestamp)?></b>, by <b class="noteBy"><?php echo $note->first_name?> <?php echo $note->last_name;?></b> &nbsp;&nbsp;
	 	</div>
	 	<div class="col-md-6 text-right">
	 		<?php if( $this->ion_auth->user()->row()->id == $note->dbapp_recordnotes_userid ):?>
	 		<button class="btn btn-inverse btn-xs btn-embossed noteEdit"><span class="fui-new"></span> Edit</button> 
	 		<button class="btn btn-danger btn-xs btn-embossed deleteRecordNote" id="columnNote_<?php echo $note->dbapp_recordnotes_id;?>"><span class="fui-cross-inverted"></span> Delete</button>
	 		<?php endif;?>
	 	</div>
	 
	 </div><!-- /.row -->
	 	
	 <div class="noteUpdate row text-right">
	 	<div class="col-md-6"></div>
	 	<div class="col-md-6">
		 	<button class="btn btn-primary btn-xs btn-embossed recordModal_savenote" id="columnNote_<?php echo $note->dbapp_recordnotes_id;?>">Save note</button>
	 		<button class="btn btn-default btn-xs btn-embossed recordModal_canceleditnote">Cancel</button>
	 	</div>
	 </div>
	
</div><!-- /.alert -->
<?php endforeach;?>