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
    		
    			<!-- form errors -->
    			<?php if(validation_errors() != ''):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('admindb_error_heading')?></h4>
    				<?php echo validation_errors(); ?>
    			</div>
    			<?php endif;?>
    			
    			<?php if($this->session->flashdata('error_message')):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('admindb_error_heading')?></h4>
    				 <?php echo $this->session->flashdata('error_message');?>
    			</div>
    			<?php endif;?>
    				
    			<?php if($this->session->flashdata('success_message')):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('admindb_success_heading')?></h4>
    				 <?php echo $this->session->flashdata('success_message');?>
    			</div>
    			<?php endif;?>
    		    			
    			<ul class="nav nav-tabs nav-append-content">
    				<li class="active"><a href="#AllDBTab"><span class="fui-user"></span> <?php echo $this->lang->line('admindb_tab_all_databases')?></a></li>
    				<li><a href="#CreateDBTab"><span class="fui-gear"></span> <?php echo $this->lang->line('admindb_tab_all_create_database')?></a></li>
    			</ul> <!-- /tabs -->
    			
    			<div class="tab-content">
    			
    				<div class="tab-pane fade in active" id="AllDBTab">
    				
    					<h4><?php echo $this->lang->line('admindb_heading1')?></h4>
    					
    					<hr>
    				
    					<div class="panel-group margin-bottom-15" id="dbAccordion">
    					
    						<?php if(isset($dbs_server)):?>
    					
    						<?php foreach($dbs_server as $db):?>
    						
    						<div class="panel panel-default">
    							<div class="panel-heading">
    						  		<h4 class="panel-title">
    						    		<a data-toggle="collapse" data-parent="#dbAccordion" href="#db_<?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $db['db']); ?>">
    						      			<span class="<?php if( $db['enabled'] == 'yes' ):?>fui-radio-checked<?php else:?>fui-radio-unchecked<?php endif;?> <?php if( $db['allowed'] == 'yes' ):?>text-primary<?php else:?>text-danger<?php endif;?>"></span>&nbsp;&nbsp;<?php echo $db['db'];?>
    						      			<span class="pull-right"><?php echo $this->lang->line('shared_click_to_expand')?></span>
    						    		</a>
    						  		</h4>
    							</div>
    							<div id="db_<?php echo preg_replace("/[^A-Za-z0-9 ]/", '', $db['db']); ?>" class="panel-collapse collapse">
    						  		<div class="panel-body">
    						    		
    						    		<?php if( $db['allowed'] == 'yes' ):?>
    						    		<div class="alert alert-info margin-bottom-0">
    						    			<h4><?php echo $this->lang->line('admindb_enabledisable1_heading')?></h4>
    						    		  	<?php echo $this->lang->line('admindb_enabledisable1_message')?>
    						    		  	<label class="checkbox" for="">
    						    		  	  <input type="checkbox" value="<?php echo $db['db']?>" id="" class="toggleDB" data-toggle="checkbox" <?php if( $db['enabled'] == 'yes' ):?>checked<?php endif;?>>
    						    		  	  <?php echo $this->lang->line('admindb_enable_label')?>
    						    		  	</label>
    						    		</div>
    						    		<?php else:?>
    						    		<div class="alert alert-error">
    						    			<h4><?php echo $this->lang->line('admindb_enabledisable2_heading')?></h4>
    						    		  	<?php echo $this->lang->line('admindb_enabledisable2_message')?>
    						    		</div>
    						    		<?php endif;?>
    						    		
    						    		<hr>
    						    		
    						    		<a href="<?php echo site_url('admin/deleteDB/'.$db['db']);?>" class="btn btn-danger btn-embossed deleteDB"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('admindb_deletedb_label')?></a>
    						    		
    						  		</div>
    							</div>
    						</div><!-- /.panel -->
    						
    						<?php endforeach;?>
    						
    						<?php endif;?>
    					  	
    					</div><!-- /#dbAccordion -->
    					
    					<p class="small text-right margin-bottom-10">
    						<span class="fui-radio-checked text-primary"></span> : <?php echo $this->lang->line('admindb_enabled_label')?> &nbsp;&nbsp; <span class="fui-radio-unchecked text-primary"></span> : <?php echo $this->lang->line('admindb_disabled_label')?> &nbsp;&nbsp; <span class="fui-radio-unchecked text-danger"></span> : <?php echo $this->lang->line('admindb_disabledand_label')?>
    					</p>
    			    	
    				</div><!-- /#tab1 -->
    				<div class="tab-pane fade" id="CreateDBTab">
    					
    					<h4><?php echo $this->lang->line('admindb_heading2')?></h4>
    					
    					<hr>
    					
    					<form class="form-horizontal" role="form" action="<?php echo site_url('admin/newDB');?>" method="post" id="newDBForm">
    						<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
    						<div class="form-group">
    					    	<label for="dbname" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('admindb_newdb_name')?> <span class="red">*</span></label>
    					    	<div class="col-sm-8">
    					      		<input type="text" class="form-control" name="dbname" id="dbname" placeholder="<?php echo $this->lang->line('admindb_newdb_label')?>" value="">
    					    	</div>
    					  	</div>
    					  	<div class="form-group">
    					  		<div class="col-sm-offset-1 col-sm-2"></div>
    					  		<div class="col-sm-8">
    					  			<label class="checkbox" for="enable" style="padding-top: 0px;">
    					  			  <input type="checkbox" value="yes" id="enable" name="enable" data-toggle="checkbox" checked>
    					  			  <?php echo $this->lang->line('admindb_newdb_enabled?')?>
    					  			</label>
    					  		</div>
    					  	</div>
    					  	<div class="form-group">
    					    	<div class="col-sm-offset-3 col-sm-8">
    					      		<button type="submit" class="btn btn-primary btn-embossed"><?php echo $this->lang->line('admindb_newdb_button')?></button>
    					    	</div>
    					  	</div>
    					</form>
    					
    				</div><!-- /.#tab2 -->
    			    			    
    			</div> <!-- /tab-content -->
    			    			
    		</div><!-- /.col-md-9 -->
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
        // IIFE - Immediately Invoked Function Expression
        (function($, window, document) {
        
        	// The $ is now locally scoped 
        
           	// Listen for the jQuery ready event on the document
           	$(function() {
        
           		// The DOM is ready!
        
           	});
           	
           	var _theDB;
           	var _checkBox;
           	
           	$('#dbAccordion').on("change", 'input.toggleDB', function(){
           	
           		_theDB = $(this).val();
           		_checkBox = $(this);
           	
           		if( $(this).is(':checked') ) {
           		
           			$.ajax({
           				type: "POST",
           				dataType: "json",
           				url: "<?php echo site_url('admin/enableDB');?>/"+_theDB
           			}).done(function(response){
           				
           				if(response.response_code == 2) {
           					
           					_checkBox.closest('.panel-body').find('.alert-error').each(function(){ $(this).remove() })
           							
           					_checkBox.closest('.panel-body').prepend($(response.message));
           						    						
           					return false;
           					
           				}
           				
           				//success message
           				_checkBox.closest('.panel-body').prepend($(response.message));
           				
           				window.setTimeout(function() { _checkBox.closest('.panel-body').find('.alert-success').fadeOut(1000, function(){$(this).remove()}); }, 3000);
           				
           				
           				//update panel link
           				_checkBox.closest('.panel').find('.panel-title a span:first').removeClass('fui-radio-unchecked').addClass('fui-radio-checked');
           				
           				
           				//update main nav
           				$('#topNav .dbs').prepend($('<li class="db" id="'+_theDB+'"><a href="<?php echo site_url('db/');?>/'+_theDB+'"><span class="fui-list"></span> '+_theDB+'</a></li>'));
           				
           				
           			})
           		
           		} else {
           		
           			$.ajax({
           				type: "POST",
           				dataType: "json",
           				url: "<?php echo site_url('admin/disableDB');?>/"+_theDB
           			}).done(function(response){
           				
           				if(response.response_code == 2) {
           					
           					_checkBox.closest('.panel-body').find('.alert-error').each(function(){ $(this).remove() })
           							
           					_checkBox.closest('.panel-body').prepend($(response.message));
           						    						
           					return false;
           					
           				}
           				
           				//success message
           				_checkBox.closest('.panel-body').prepend($(response.message));
           				
           				window.setTimeout(function() { _checkBox.closest('.panel-body').find('.alert-success').fadeOut(1000, function(){$(this).remove()}); }, 3000);
           				
           				
           				//update panel link
           				_checkBox.closest('.panel').find('.panel-title a span:first').addClass('fui-radio-unchecked').removeClass('fui-radio-checked');
           				
           				
           				//update the main navigation
           					
           				$('#topNav .dbs li#'+_theDB).remove();
           				
           			})
           		
           		}
           	
           	})
           	
           	
           	//new dabatabase form
           	$('form#newDBForm').submit(function(){
           	
           		if( $('input#dbname').val() == '' ) {
           		
           			alert('Please enter a name for the new database');
           			
           			return false;
           		
           		}
           		
           		return true;
           	
           	})
           	
           	
           	//delete database links
           	$('#dbAccordion').on('click', 'a.deleteDB', function(){
           	
           		if( confirm('Deleting this database will destroy all data within it and all meta data in <b>Databased</b> as well. This can not be undone! Are you sure about this?') ) {
           			
           			return true;
           		
           		} else {
           		
           			return false;
           		
           		}
           	
           	})
           	
        
        }(window.jQuery, window, document));
        // The global jQuery object is passed as a parameter
        </script>
  </body>
</html>
