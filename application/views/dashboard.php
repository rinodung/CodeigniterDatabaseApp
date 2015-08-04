<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("shared/head");?>
</head>
<body>

	<?php $this->load->view("shared/nav");?>
	
    <div class="container main extra-top-padding">
    
    	<div class="row">
    	
    		<div class="col-md-8 col-md-offset-2" id="mainContent">
    		
    			<?php if($dbs):?>
    		
    			<h3 class="text-center"><?php echo $this->lang->line('dashboard_heading');?></h3>
    			
    			<hr>
    		
    			<div class="panel-group" id="dbAccordion">
    				
    				<?php foreach( $dbs as $db ):?>
    				<div class="panel panel-default">
    			    	<div class="panel-heading">
    			      		<h4 class="panel-title">
    			        		<a data-toggle="collapse" data-parent="#dbAccordion" href="#db_<?php echo $db['db']?>">
    			          			<?php echo $db['db'];?>
    			          			<span class="pull-right"><?php echo $this->lang->line('shared_click_to_expand')?></span>
    			        		</a>
    			      		</h4>
    			    	</div>
    			    	<div id="db_<?php echo $db['db']?>" class="panel-collapse collapse">
    			      		<div class="panel-body">
    			      			<p>
    			        			<?php echo $this->lang->line('dashboard_number_of_tables')?> <?php echo count($db['tables']);?>
    			      			</p>
    			      			<a href="<?php echo site_url('db/'.$db['db']);?>" class="btn btn-primary btn-embossed btn-block"><span class="fui-new"></span> <?php echo $this->lang->line('dashboard_work_on_this_database')?></a>
    			      		</div>
    			    	</div>
    			  	</div><!-- /.panel -->
    			  	<?php endforeach;?>
    			  	
    			  	<?php else:?>
    			  	
    			  		<?php if( $this->ion_auth->is_admin() ):?>
    			  		<div class="alert alert-error">
    			  			<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			  	  		<h4><?php echo $this->lang->line('dashboard_nodbs1_heading')?></h4>
    			  	  		<p>
    			  	  			<?php echo $this->lang->line('dashboard_nodbs1_message')?>
    			  	  		</p>
    			  	  		<a href="<?php echo site_url('admin/db');?>" class="btn btn-info btn-wide"><?php echo $this->lang->line('dashboard_nodbs1_button')?></a>
    			  		</div>
    			  		<?php else:?>
    			  		<div class="alert alert-error">
    			  			<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			  			<h4><?php echo $this->lang->line('dashboard_nodbs2_heading')?></h4>
    			  			<p>
    			  				<?php echo $this->lang->line('dashboard_nodbs2_message')?> <a href="mailto:<?php echo $this->config->item('support_email');?>"><?php echo $this->config->item('support_email');?></a>
    			  			</p>
    			  		</div>
    			  		<?php endif;?>
    			  	
    			  	<?php endif;?>
    			  	
    			</div><!-- /.panel-group -->
    			    			    			
    		</div><!-- /.col-md-9 -->
    		
    	</div><!-- /.row -->
    	
    </div>
    <!-- /.container -->
    
    <?php $this->load->view("users/includes/modal_newuser");?>

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
  </body>
</html>
