<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("shared/head");?>
</head>
<body>

	<?php $this->load->view("shared/nav");?>
	
    <div class="container main extra-top-padding">
    
    	<div class="row">
    	
    		<div class="col-md-12" id="mainContent">
    		
    			<!-- form errors -->
    			<?php if( count($files) == 0 ):?>
    			<div class="alert alert-info">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			  	<p>
    			  		<?php echo $this->lang->line('files_message_no_files');?>
    			  	</p>
    			</div>
    			<?php endif;?>
    			
    			<?php if($this->session->flashdata('error_message')):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('files_error_heading')?></h4>
    				<p>
    					<?php echo $this->session->flashdata('error_message');?>
    				</p>
    			</div>
    			<?php endif;?>
    				
    			<?php if($this->session->flashdata('success_message')):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('files_success_heading')?></h4>
    				<p>
    					<?php echo $this->session->flashdata('success_message');?>
    				</p>
    			</div>
    			<?php endif;?>
    			
    			<div class="info clearfix">
    			
    				<?php echo $this->lang->line('files_nr_of_files')?> <b><?php echo count($files);?></b>
    			    			
    			</div><!-- /.info -->
    			
    			<br>
    			
    			<form action="<?php echo site_url("admin/deleteFiles");?>" method="post">
    			
    			<div class="table-responsive">
    				<table class="table table-bordered" id="fileTable">
    			    	<thead>
    			      		<tr>
    			        		<th width="30"><label class="checkbox no-label toggle-all" for="checkbox-table-1"><input type="checkbox" value="" id="checkbox-table-1" data-toggle="checkbox"></label></th>
    			        		<th><?php echo $this->lang->line('files_table_heading_name')?></th>
    			        		<th width="140"><?php echo $this->lang->line('files_table_heading_date')?></th>
    			        		<th width="180"><?php echo $this->lang->line('files_table_heading_size')?></th>
    			        		<th width="120"><?php echo $this->lang->line('files_table_heading_actions')?></th>
    			      		</tr>
    			    	</thead>
    			    	<tbody>
    			    		<?php foreach( $files as $file ):?>
    			    		
    			      		<tr>
    			        		<td><label class="checkbox no-label" for="checkbox-table-<?php echo $file['name']?>"><input type="checkbox" name="ids[]" value="<?php echo $file['name']?>" id="checkbox-table-<?php echo $file['name']?>" data-toggle="checkbox"></label></td>
    			        		<td><b><a href="<?php echo base_url()."uploads/".$file['name'];?>" target="_blank"><?php echo $file['name']?></a></b></td>
    			        		<td><?php echo date("Y-m-d", $file['date']);?></td>
    			        		<td><?php echo $file['size']?> <?php echo $this->lang->line('files_table_bytes')?></td>
    			        		<td>
    			        			<div class="crud">
    			        				<a href="<?php echo site_url("admin/deleteFile/".$file['name']);?>" class="del"><span class="fui-cross-inverted text-danger del"></span></a>
    			        				&nbsp;
    			        				<a href="<?php echo base_url()."uploads/".$file['name'];?>" target="_blank"><span class="fui-export"></span></a>
    			        			</div>
    			        		</td>
    			      		</tr>
    			      		<?php endforeach;?>
    			    	</tbody>
    				</table>
    			</div><!-- /.table-responsive -->
    		    			    			 
   				<div class="actions clearfix">
   				
   					<button type="submit" class="btn btn-danger btn-embossed"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('files_button_delete')?></button>
   				
   				</div><!-- /.actions -->
   				
   				</form>
   				
   				<br>
    		    			    			    			    			
    		</div><!-- /.col-md-12 -->
    	</div><!-- /.row -->
    </div>
    <!-- /.container -->
    
    <?php //$this->load->view("users/includes/modal_newuser");?>

    <!-- Load JS here for greater good =============================-->
    <script src="<?php echo base_url();?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-select.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-switch.js"></script>
    <script src="<?php echo base_url();?>js/flatui-checkbox.js"></script>
    <script src="<?php echo base_url();?>js/flatui-radio.js"></script>
    <script src="<?php echo base_url();?>js/jquery.tagsinput.js"></script>
    <script src="<?php echo base_url();?>js/jquery.placeholder.js"></script>
    <script src="<?php echo base_url();?>js/application.js"></script>
    <script src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>js/TableTools.min.js"></script>
    <script src="<?php echo base_url();?>js/ZeroClipboard.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-datatables.js"></script>
    <script src="<?php echo base_url();?>js/datatables.plugins.js"></script>
    <script src="<?php echo base_url();?>assets/redactor/redactor.js"></script>
    <script src="<?php echo base_url();?>js/dbapp/dbapp_users.js"></script>
    <script>
    $(function(){
    	    
    	$("#fileTable").on("click", ".crud a.del", function(e){
    	    		
    		if( confirm('Removing a file or image can lead to broken links in your data. Are you sure you want to continue?') ) {
    		
    			return true;
    		
    		} else {
    		
    			return false;
    		
    		}
    	
    	})
    
    })
    </script>
  </body>
</html>
