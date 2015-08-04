<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("shared/head");?>
</head>
<body>

	<?php $this->load->view("shared/nav");?>
	
    <div class="container main">
        
    	<div class="row">
    		
    		<div class="col-md-12" id="mainContent">
    		
    			<?php if($this->session->flashdata('error_message')):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('table_error_heading')?></h4>
    			  	<?php echo $this->session->flashdata('error_message');?>
    			</div>
    			<?php endif;?>
    			
    			<?php if($this->session->flashdata('success_message')):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4><?php echo $this->lang->line('table_success_heading')?></h4>
    			  	<?php echo $this->session->flashdata('success_message');?>
    			</div>
    			<?php endif;?>
    		
    			<ul class="nav nav-tabs nav-append-content">
    				
    				<li class="active"><a href="#tab1" class="tt" data-delay="1500" data-placement="bottom" title="Show data in the <?php echo $theTable;?> table"><span class="fui-list"></span> <?php echo $this->lang->line('table_tab_table_data')?></a></li>
    			    
    			    <?php if( isset($tableFields) ):?>
    			    <li><a href="#tab2" class="tt" data-delay="1500" data-placement="bottom" title="Show, hide and manage columns in the <?php echo $theTable;?> table"><span class="fui-list-columned"></span> <?php echo $this->lang->line('table_tab_table_columns')?></a></li>
    			    <?php endif;?>
    			    
    			    <?php if( isset($tableNotes) ):?>
    			    <li><a href="#tab3" class="tt" data-delay="1500" data-placement="bottom" title="View notes for the <?php echo $theTable;?> table"><span class="fui-document"></span> <?php echo $this->lang->line('table_tab_table_notes')?> <span class="label label-important" id="table_notesTotal"><?php echo count($tableNotes);?></span></a></li>
    			    <?php endif;?>
    			    
    			    <li><a href="#tab4"><span class="fui-gear"></span> <?php echo $this->lang->line('table_tab_more')?></a></li>
    			
    			</ul> <!-- /tabs -->
    			
    			<div class="tab-content">
    			
    				<div class="tab-pane fade in active" id="tab1">
    			    	
    			    	<?php if( isset($tableFields) && $hasPrimary ):?>
    			    	<div class="row">
    			    			
    			    		<div class="col-md-6">
    			    			
    			    			<?php if( $tableInsertAllowed == 'yes' ):?>
    			    			<a href="#newRecordModal" data-toggle="modal" class="btn btn-primary btn-sm btn-embossed btn-embossed"><span class="fui-plus"></span> <?php echo $this->lang->line('table_button_newrecord')?></a>
    			    			<a href="#importDataModal" data-toggle="modal" class="btn btn-default btn-sm btn-embossed btn-embossed"><span class="fui-upload"></span> <?php echo $this->lang->line('table_button_importdata')?></a>
    			    			<?php endif;?>
    			    			
    			    		</div>
    			    			
    			    		<div class="col-md-6">
    			    		
    			    			<div class="form-group select-margin-bottom-0">
    			    				<div class="input-group input-group-sm filterBar">
    			    					
    			    					<?php if( $this->session->userdata('searchItems') != '' && $this->session->userdata('searchItems_db') == $theDB && $this->session->userdata('searchItems_table') == $theTable ):?>
    			    					
    			    					<span class="input-group-btn">
    			    					    <button type="submit" class="btn disabled"><span class="fui-search"></span></button>
    			    					</span>
    			    					<input type="search" class="form-control disabled" placeholder="<?php echo $this->lang->line('table_search_using_advanced')?>" id="zeTableSearch" disabled>
    			    					<div class="input-group-btn">
    			    						<a href="<?php echo site_url("db/".$theDB."/".$theTable."/true")?>" class="btn btn-default" id=""><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('table_search_reset_search')?></a>
    			    						<button class="btn btn-default" type="button" id="toggleAdvancedSearch"><span class="fui-gear"></span></button>
    			    					</div>
    			    					
    			    					<?php else:?>
    			    					
    			    					<span class="input-group-btn">
    			    					    <button type="submit" class="btn"><span class="fui-search"></span></button>
    			    					</span>
    			    					<input type="search" class="form-control" placeholder="<?php echo $this->lang->line('table_search_placeholder')?>" id="zeTableSearch">
    			    					<div class="input-group-btn">
    			    						<button class="btn btn-default" type="button" id="toggleAdvancedSearch"><span class="fui-gear"></span> <?php echo $this->lang->line('table_search_more_options')?></button>
    			    					</div>
    			    					
    			    					<?php endif;?>
    			    				
    			    				    
    			    				</div>
    			    			</div><!-- /.form-group -->
    			    			
    			    			<div class="advancedSearchForm_wrapper" id="advancedSearchForm_wrapper">
    			    			    			    			
    			    				<form class="clearfix" role="form" id="advancedSearchForm" action="<?php echo site_url("db/".$theDB."/".$theTable);?>" method="post">
    			    				
    			    					<input type="hidden" name="db" value="<?php echo $theDB;?>">
    			    					<input type="hidden" name="table" value="<?php echo $theTable;?>">
    			    				
    			    					<div class="clearfix">
    			    						<h5 class="pull-left"><span class="fui-search"></span> <?php echo $this->lang->line('table_search_advanced_heading')?></h5>
    			    						<a href="#" class="pull-right small" id="hideAdvancedSearch"><span class="fui-cross"></span> <?php echo $this->lang->line('table_search_advanced_hide')?></a>
    			    					</div>
    			    					
    			    					<hr>
    			    					
    			    					<div class="panel-group margin-bottom-15" id="advancedSearch_accordion">
    			    					
    			    						<!-- templ -->
    			    						<div class="panel panel-default" style="display: none;" id="newSearchItem_templ">
    			    							<div class="panel-heading">
    			    						  		<h4 class="panel-title">
    			    						    		<a data-parent="#advancedSearch_accordion" href="#as_collapse0">
    			    						      			<b class="item"><?php echo $this->lang->line('table_search_search_item')?> 1</b> <span class="pull-right">(<?php echo $this->lang->line('table_search_toggle_visibility')?>)</span>
    			    						    		</a>
    			    						  		</h4>
    			    							</div>
    			    							<div id="as_collapse0" class="panel-collapse collapse in">
    			    						  		<div class="panel-body">
    			    						    		
    			    						    		<div class="form-group clearfix margin-bottom-0">
    			    						    			<div class="col-sm-6">
    			    						    				<div class="mbl margin-bottom-0">
    			    						    					<select name="columns[]" class="select-block selector" placeholder="Choose column">
    			    						    						<option value=""><?php echo $this->lang->line('table_search_choose_column')?></option>
    			    						    				  		<?php foreach( $tableFields as $field ):?>
    			    						    				  		<option value="<?php echo $field['field'];?>"><?php echo $field['field'];?></option>
    			    						    				  		<?php endforeach;?>
    			    						    				  	</select>
    			    						    				</div>
    			    						    			</div>
    			    						    			<div class="col-sm-6">
    			    						    				<div class="mbl margin-bottom-0">
    			    						    				  	<select name="operators[]" class="select-block selector" placeholder="Choose operator">
    			    						    				  		<option value=""><?php echo $this->lang->line('table_search_choose_operator')?></option>
    			    						    				    	<option value="="><?php echo $this->lang->line('table_search_equals')?></option>
    			    						    				    	<option value="!="><?php echo $this->lang->line('table_search_does_not_equal')?></option>
    			    						    				    	<option value="LIKE%%"><?php echo $this->lang->line('table_search_contains')?></option>
    			    						    				    	<option value="NOT LIKE%%"><?php echo $this->lang->line('table_search_does_not_contain')?></option>
    			    						    				    	<option value="<"><?php echo $this->lang->line('table_search_less_then')?></option>
    			    						    				    	<option value=">"><?php echo $this->lang->line('table_search_greater_then')?></option>
    			    						    				    	<option value="<="><?php echo $this->lang->line('table_search_equals_or_less_then')?></option>
    			    						    				    	<option value=">="><?php echo $this->lang->line('table_search_equals_or_greater')?></option>
    			    						    				  	</select>
    			    						    				</div>
    			    						    			</div>
    			    						    			
    			    						    		</div>
    			    						    		
    			    						    		<div class="form-group clearfix margin-bottom-15">
    			    						    			<div class="col-sm-12">
    			    						    				<input type="text" class="form-control" id="inputEmail3" placeholder="Value" name="values[]">
    			    						    			</div>
    			    						    		</div>
    			    						    		
    			    						    		<div class="form-group clearfix margin-bottom-0">
    			    						    			<div class="col-sm-12">
    			    						    				<a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('table_search_remove_item')?></a>
    			    						    			</div>
    			    						    		</div>
    			    						    		
    			    						  		</div>
    			    							</div>
    			    						</div>
    			    						<!-- /templ -->
    			    						
    			    						<?php if( $this->session->userdata('searchItems') ):?>
    			    						
    			    						<?php 
    			    							$counter = 1;
    			    						?>
    			    						
    			    						<?php foreach( $this->session->userdata('searchItems') as $searchItem ):?>
    			    						
    			    						<div class="panel panel-default">
    			    							<div class="panel-heading">
    			    						  		<h4 class="panel-title">
    			    						    		<a data-parent="#advancedSearch_accordion" href="#as_collapse<?php echo $counter;?>">
    			    						      			<b class="item"><?php echo $this->lang->line('table_search_search_item')?> <?php echo $counter;?></b> <span class="pull-right">(<?php echo $this->lang->line('table_search_toggle_visibility')?>)</span>
    			    						    		</a>
    			    						  		</h4>
    			    							</div>
    			    							<div id="as_collapse<?php echo $counter;?>" class="panel-collapse collapse in">
    			    						  		<div class="panel-body">
    			    						    		
    			    						    		<div class="form-group clearfix margin-bottom-0">
    			    						    			<div class="col-sm-6">
    			    						    				<div class="mbl margin-bottom-0">
    			    						    					<select name="columns[]" class="select-block selector" placeholder="Choose column">
    			    						    						<option value=""><?php echo $this->lang->line('table_search_choose_column')?></option>
    			    						    				  		<?php foreach( $tableFields as $field ):?>
    			    						    				  		<option value="<?php echo $field['field'];?>" <?php if( $searchItem['column'] == $field['field'] ):?>selected<?php endif;?>><?php echo $field['field'];?></option>
    			    						    				  		<?php endforeach;?>
    			    						    				  	</select>
    			    						    				</div>
    			    						    			</div>
    			    						    			<div class="col-sm-6">
    			    						    				<div class="mbl margin-bottom-0">
    			    						    				  	<select name="operators[]" class="select-block selector" placeholder="Choose operator">
    			    						    				  		<option value=""><?php echo $this->lang->line('table_search_choose_operator')?></option>
    			    						    				  		
    			    						    				  		<option value="=" <?php if( $searchItem['operator'] == '=' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_equals')?></option>
    			    						    				  		<option value="!=" <?php if( $searchItem['operator'] == '!=' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_does_not_equal')?></option>
    			    						    				  		<option value="LIKE%%" <?php if( $searchItem['operator'] == 'LIKE%%' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_contains')?></option>
    			    						    				  		<option value="NOT LIKE%%" <?php if( $searchItem['operator'] == 'NOT LIKE%%' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_does_not_contain')?></option>
    			    						    				  		<option value="<" <?php if( $searchItem['operator'] == '<' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_less_then')?></option>
    			    						    				  		<option value=">" <?php if( $searchItem['operator'] == '>' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_greater_then')?></option>
    			    						    				  		<option value="<=" <?php if( $searchItem['operator'] == '<=' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_equals_or_less_then')?></option>
    			    						    				  		<option value=">=" <?php if( $searchItem['operator'] == '>=' ):?>selected<?php endif;?>><?php echo $this->lang->line('table_search_equals_or_greater')?></option>
    			    						    				  	</select>
    			    						    				</div>
    			    						    			</div>
    			    						    			
    			    						    		</div>
    			    						    		
    			    						    		<div class="form-group clearfix margin-bottom-15">
    			    						    			<div class="col-sm-12">
    			    						    				<input type="text" class="form-control" id="inputEmail3" placeholder="Value" name="values[]" value="<?php echo $searchItem['value']?>">
    			    						    			</div>
    			    						    		</div>
    			    						    		
    			    						    		<div class="form-group clearfix margin-bottom-0">
    			    						    			<div class="col-sm-12">
    			    						    				<?php if( $counter > 1 ):?>
    			    						    				<a href="" class="pull-right text-danger small removeAsItem"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('table_search_remove_item')?></a>
    			    						    				<?php endif;?>
    			    						    			</div>
    			    						    		</div>
    			    						    		
    			    						  		</div>
    			    							</div>
    			    						</div><!-- /.panel -->
    			    						
    			    						<?php $counter++;?>
    			    							
    			    						<?php endforeach;?>
    			    						
    			    						<?php else:?>
    			    					
    			    						<div class="panel panel-default">
    			    					    	<div class="panel-heading">
    			    					      		<h4 class="panel-title">
    			    					        		<a data-parent="#advancedSearch_accordion" href="#as_collapseOne">
    			    					          			<b class="item"><?php echo $this->lang->line('table_search_search_item')?> 1</b> <span class="pull-right">(<?php echo $this->lang->line('table_search_toggle_visibility')?>)</span>
    			    					        		</a>
    			    					      		</h4>
    			    					    	</div>
    			    					    	<div id="as_collapseOne" class="panel-collapse collapse in">
    			    					      		<div class="panel-body">
    			    					        		
    			    					        		<div class="form-group clearfix margin-bottom-0">
    			    					        			<div class="col-sm-6">
    			    					        				<div class="mbl margin-bottom-0">
    			    					        					<select name="columns[]" class="select-block selector" placeholder="Choose column">
    			    					        						<option value=""><?php echo $this->lang->line('table_search_choose_column')?></option>
    			    					        				  		<?php foreach( $tableFields as $field ):?>
    			    					        				  		<option value="<?php echo $field['field'];?>"><?php echo $field['field'];?></option>
    			    					        				  		<?php endforeach;?>
    			    					        				  	</select>
    			    					        				</div>
    			    					        			</div>
    			    					        			<div class="col-sm-6">
    			    					        				<div class="mbl margin-bottom-0">
    			    					        				  	<select name="operators[]" class="select-block selector" placeholder="Choose operator">
    			    					        				  		<option value=""><?php echo $this->lang->line('table_search_choose_operator')?></option>
    			    					        				  		<option value="="><?php echo $this->lang->line('table_search_equals')?></option>
    			    					        				  		<option value="!="><?php echo $this->lang->line('table_search_does_not_equal')?></option>
    			    					        				  		<option value="LIKE%%"><?php echo $this->lang->line('table_search_contains')?></option>
    			    					        				  		<option value="NOT LIKE%%"><?php echo $this->lang->line('table_search_does_not_contain')?></option>
    			    					        				  		<option value="<"><?php echo $this->lang->line('table_search_less_then')?></option>
    			    					        				  		<option value=">"><?php echo $this->lang->line('table_search_greater_then')?></option>
    			    					        				  		<option value="<="><?php echo $this->lang->line('table_search_equals_or_less_then')?></option>
    			    					        				  		<option value=">="><?php echo $this->lang->line('table_search_equals_or_greater')?></option>
    			    					        				  	</select>
    			    					        				</div>
    			    					        			</div>
    			    					        			
    			    					        		</div>
    			    					        		
    			    					        		<div class="form-group clearfix margin-bottom-15">
    			    					        			<div class="col-sm-12">
    			    					        				<input type="text" class="form-control" id="inputEmail3" placeholder="Value" name="values[]">
    			    					        			</div>
    			    					        		</div>
    			    					        		
    			    					        		<div class="form-group clearfix margin-bottom-0">
    			    					        			<div class="col-sm-12">
    			    					        				
    			    					        			</div>
    			    					        		</div>
    			    					        		
    			    					      		</div>
    			    					    	</div>
    			    					  	</div><!-- /.panel -->
    			    					  	
    			    					  	<?php endif;?>
    			    					  	
    			    					</div>
    			    				
    			    			  		<div class="form-group clearfix">
    			    			      		<button type="submit" class="btn btn-primary btn-embossed"><?php echo $this->lang->line('table_search_apply_search_items')?></button>
    			    			      		<a href="<?php echo site_url("db/".$theDB."/".$theTable."/true")?>" class="btn btn-danger btn-embossed"><?php echo $this->lang->line('table_search_clear_search')?></a>
    			    			      		<a href="" class="addColumnLink pull-right" id="addSearchItem"><span class="fui-plus"></span> <?php echo $this->lang->line('table_search_add_search_item')?></a>
    			    			  		</div>
    			    				</form>
    			    			
    			    			</div><!-- /.advancedSearchForm_wrapper -->
    			    			
    			    		</div><!-- /.col-md-6 -->
    			    			
    			    	</div><!-- /.row -->
    			    	
    			    	<hr>
    			    	<?php endif;?>
    			    	
    			    	<?php if( isset($tableFields) && $hasPrimary ):?>
    			    	<div class="table-responsive" id="zeTable">
    			    		<table class="table table-bordered table-striped table-hover <?php if(isset($tableUpdateAllowed) && $tableUpdateAllowed == 'yes'):?>allowedTable<?php else:?>notAllowedTable<?php endif;?>" id="table">
    			    		    <thead>
    			    		    	<tr>
    			    		    		<th><?php echo $this->lang->line('table_column_actions')?></th>
    			    		    		<?php $colCounter = 0;?>
    			    		    		<?php foreach($tableFields as $field):?>
    			    		    			<?php if(in_array($field['field'], $this->session->userdata($theDB.".".$theTable))):?>
    			    		    			<th><?php echo $field['field'];?></th>
    			    		    			<?php $colCounter++;?>
    			    		    			<?php endif;?>
    			    		    		<?php endforeach;?>
    			    		    	</tr>
    			    		    </thead>
    			    		 	<tbody>
    			    		      
    			    		    </tbody>
    			    		</table>
    			   		</div><!-- /.table-responsive -->
    			   		<?php else:?>
    			   			
    			   			<?php if( isset($hasPrimary) && $hasPrimary == false ):?>
    			   			
    			   			<div class="alert alert-error">
    			   				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			   				<h4><?php echo $this->lang->line('table_error_noprimkey_heading')?></h4>
    			   				<p>
    			   					<?php echo $this->lang->line('table_error_noprimkey_message')?>
    			   				</p>
    			   			</div>
    			   			
    			   			<?php else:?>
    			   		
    			   			<div class="alert alert-error">
    			   		  		<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			   		  		<h4><?php echo $this->lang->line('table_error_notables_heading')?></h4>
    			   		  		<p>
    			   		  			<?php echo $this->lang->line('table_error_notables_message')?>
    			   		  		</p>
    			   			</div>
    			   			<?php endif;?>
    			   		
    			   		<?php endif;?>
    			    	
    				</div>
    			
    				<?php if( isset($tableFields) ):?>
    			    <div class="tab-pane fade" id="tab2">
    			    
    			    	<div class="alert alert-info">
    			    		<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			    		<h4><?php echo $this->lang->line('table_columns_message_heading')?></h4>
    			    		<p>
    			    			<?php echo $this->lang->line('table_columns_message')?>
    			    		</p>
    			    		<a href="" class="btn btn-inverse btn-embossed"><?php echo $this->lang->line('table_columns_reload_view')?></a> 
    			    		<?php if($this->usermodel->hasTablePermission("alter", $theDB, $theTable)):?><a href="#newColumnModal" class="btn btn-primary btn-embossed" data-toggle="modal"><?php echo $this->lang->line('table_columns_create_new_column')?></a><?php endif;?>
    			    	</div>
    			    	    			    	
    			    	<?php
    			    		$cData = array();
    			    		$cData['theDB'] = $theDB;
    			    		$cData['theTable'] = $theTable;
    			    		$cData['tableFields'] = $tableFields;
    			    	?>
    			    	
    			    	<?php $this->load->view("partials/column_table", $cData);?>
    			    	
    			    	<?php if( count($tableFields) > 10 ):?>
    			    	<div class="alert alert-info">
    			    		<a href="" class="btn btn-inverse btn-embossed"><?php echo $this->lang->line('table_columns_reload_view')?></a> <a href="#newColumnModal" class="btn btn-primary btn-embossed" data-toggle="modal"><?php echo $this->lang->line('table_columns_create_new_column')?></a>
    			    	</div>
    			    	<?php endif;?>
    			    	
    			  	</div>
    			  	<?php endif;?>
    			
    			    <div class="tab-pane fade" id="tab3">
    			        			    	
    			    	<div class="thetablenotes">
    			    	
    			    		<hr>
    			    		
    			    		<?php if( isset($tableNotes) ):?>
    			    		
    			    		<div id="tableNotes">
    			    			
    			    			<?php $this->load->view("partials/tablenotes", array('tableNotes'=>$tableNotes));?>
    			    			
    			    		</div>
    			    		    			    		
    			    		<h4><?php echo $this->lang->line('table_notes_heading')?></h4>
    			    			
    			    		<textarea id="table_newnote" class="redactor"><?php echo $this->lang->line('table_notes_newnote_placeholder')?></textarea>
    			    			
    			    		<p class="clearfix margin-top-20">
    			    			<button type="button" class="btn btn-primary btn-embossed pull-right" id="newTableNote_button"><?php echo $this->lang->line('table_notes_newnote_button')?></button>
    			    		</p>
    			    		
    			    		<?php endif;?>
    			    			    			    		
    			    	</div><!-- /.tablenotes -->
    			    	    			    	
    			    </div><!-- /.tab-pabe -->
    			    
    			    <div class="tab-pane fade" id="tab4">
    			    
    			    	<hr>
    			    	
    			    	<?php if( $tableDropAllowed == 'yes' ):?>
    			    	
    			    	<div class="alert alert-error">
    			    		<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			    	  	<h4><?php echo $this->lang->line('table_more_delete_heading')?></h4>
    			    	  	<p>
    			    	  		<?php echo $this->lang->line('table_more_delete_message')?>
    			    	  	</p>
    			    	  	<a href="<?php echo site_url('db/deleteTable/'.$theDB."/".$theTable);?>" class="btn btn-danger btn-wide" id="deleteTableLink"><?php echo $this->lang->line('table_more_delete_button')?></a>
    			    	</div><!-- /.alert -->
    			    	
    			    	<hr>
    			    	
    			    	<?php endif;?>
    			    	
    			    	<?php if( $tableDropAllowed == 'yes' ):?>
    			    
    			    	<div class="row">
    			    	
    			    		<div class="col-md-9">
    			    		
    			    			<form action="<?php echo site_url('db/updateTable/'.$theDB."/".$theTable);?>" method="post" class="form-horizontal">
    			    			
    			    				<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
    			    			
    			    				<div class="form-group">
    			    					<label for="tableName" class="col-sm-offset-1 col-sm-2 control-label"><?php echo $this->lang->line('table_more_table_name')?> <span class="red">*</span></label>
    			    					<div class="col-sm-8">
    			    				  		<input type="text" class="form-control" name="tableName" id="tableName" placeholder="<?php echo $this->lang->line('table_more_table_label')?>" value="<?php echo $theTable;?>">
    			    					</div>
    			    				</div>
    			    				
    			    				<div class="form-group">
    			    					<div class="col-sm-offset-3 col-sm-8">
    			    						<button type="submit" class="btn btn-primary btn-embossed"><?php echo $this->lang->line('table_more_table_update_button')?></button>
    			    					</div>
    			    				</div>
    			    			
    			    			</form>
    			    		
    			    		</div><!-- /.col-md-9 -->
    			    	
    			    	</div><!-- /.row -->
    			    	
    			    	<?php endif;?>
    			    
    			    </div><!-- /.tab-pane -->
    			        			        			    
    			</div> <!-- /tab-content -->
    			
    		</div><!-- /.col-md-9 -->
    	</div>
    </div>
    <!-- /.container -->
    
    <div class="bottomTabs">
    
    	<ul>
    		<li><b><?php echo $this->lang->line('table_bottom_tables')?> <span class="fui-document"></span></b></li>
    		<li>
    			<?php if( $this->usermodel->hasDBPermission("create", $theDB) ):?>
    			<a href="#newTableModal" data-toggle="modal" class="addTable"><span class="fui-plus"></span></a>
    			<?php endif;?>
    		</li>
    		<?php foreach($tables as $table):?>
    		<li <?php if($table['table'] == $theTable):?>class="active"<?php endif;?>>
    			<a href="<?php echo site_url('db/'.$theDB."/".$table['table']);?>"><?php echo $table['table'];?></a>
    		</li>
    		<?php endforeach;?>
    	</ul>	
    
    </div><!-- /.bottomTabs -->
    
    <?php if( isset($tableFields) ):?>
    <?php $this->load->view("table/includes/modal_cell");?>
    
    <?php $this->load->view("table/includes/modal_record");?>
    
    <?php $this->load->view("table/includes/modal_viewrecord");?>
    
    <?php $this->load->view("table/includes/modal_newrecord");?>
    
    <?php $this->load->view("table/includes/modal_newcolumn");?>
    
    <?php $this->load->view("table/includes/modal_editcolumn");?>
    <?php endif;?>
    
    <?php $this->load->view("table/includes/modal_newtable");?>
    
    <?php $this->load->view("table/includes/modal_importdata");?>

    <!-- Load JS here for greater good =============================-->
    <script src="<?php echo base_url();?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-select.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-switch.js"></script>
    <script src="<?php echo base_url();?>js/flatui-fileinput.js"></script>
    <script src="<?php echo base_url();?>js/flatui-checkbox.js"></script>
    <script src="<?php echo base_url();?>js/flatui-radio.js"></script>
    <script src="<?php echo base_url();?>js/jquery.tagsinput.js"></script>
    <script src="<?php echo base_url();?>js/jquery.placeholder.js"></script>
    <script src="<?php echo base_url();?>js/application.js"></script>
    <script src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>js/dataTables.colReorder.min.js"></script>
    <script src="<?php echo base_url();?>js/TableTools.min.js"></script>
    <script src="<?php echo base_url();?>js/ZeroClipboard.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-datatables.js"></script>
    <script src="<?php echo base_url();?>js/datatables.plugins.js"></script>
    <script src="<?php echo base_url();?>js/jquery.form.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.autosize.min.js"></script>
    <script src="<?php echo base_url();?>assets/redactor/redactor.js"></script>
    <script src="<?php echo base_url();?>assets/chosen/chosen.jquery.min.js"></script>
    <script src="<?php echo base_url();?>js/ajaxfileupload.js"></script>
    <?php if( isset($tableFields) ):?>
    <script>
    
    var allFields = new Array();
    
    <?php foreach($tableFields as $field):?>
    
    field = new Array();
    field['type'] = '<?php echo $field['type'];?>';
    field['max_length'] = <?php echo ($field['max_length'] != '')? $field['max_length']: 0;?>;
    
    allFields['<?php echo $field['field']?>'] = field;
    
    <?php endforeach;?>
    
    var _theTable = "<?php echo $theTable; ?>";
    var _theDB = "<?php echo $theDB;?>";
    var _tableUpdateAllowed = "<?php echo $tableUpdateAllowed;?>";
    
    var _fieldName;				//the field name of the clicked cell
    var _fieldValue;			//the field value
    var _rowIndex;				//the index value
    var _rowIndexName;			//the index name
    var _theDIV; 				//the clicked div wrapped around the td
   
   	<?php
   		
   		$tempURL = site_url();
   		
   		$tempURL = rtrim($tempURL, "/");
   		
   	?>
   	
   	var _BASE_URL = "<?php echo $tempURL;?>";
   
    var _BASE_URL_ = "<?php echo base_url();?>";
    
    var table = $('#table');
    
    var _colCounter = <?php if(isset($colCounter)) {echo $colCounter;} else {echo "0";}?>;//the number of visable columns
    
    <?php
    
    	$counter = 1;
    	
    	$temp = array();
    
    	foreach( $tableFields as $f ) {
    	
    		$temp[] = $counter;
    		
    		$counter++;
    	
    	}
			
		$mColumns = implode(", ", $temp);
		
		$mColumns = '['.$mColumns.']';
    
    ?>
    
    var _mColumns = <?php echo $mColumns?>;
    
    var fieldModal = $('#fieldModal');
    
    var _TOKEN = "<?php echo $this->session->userdata('session_id');?>";
    
    var _tablePrimaryKey = "<?php if($hasPrimary) {echo $primaryKey;} else {echo 0;}?>";
    
    var _theDeleteRevisionButton = '';
    
    var _columnToEdit = "";//contains the column name when the edit column modal is shown
            
    </script>
    <?php endif;?>
    <?php if( isset($tableFields) && $hasPrimary ):?>
    <script src="<?php echo base_url();?>js/dbapp/dbapp_table.js"></script>
    <script src="<?php echo base_url();?>js/dbapp/dbapp_table_cell.js"></script>
    <script src="<?php echo base_url();?>js/dbapp/dbapp_table_record.js"></script>
    <?php endif;?>
    <?php if( isset($tableFields) ):?>
    <script src="<?php echo base_url();?>js/dbapp/dbapp_table_columns.js"></script>
    <?php endif;?>
  	<script src="<?php echo base_url();?>js/dbapp/dbapp_table_new.js"></script>
  </body>
</html>
