<table class="table table-striped table-hover" id="columnTable">
	<thead>
		<tr>
			<th width="30px">
				<label class="checkbox no-label toggle-all fieldNameAllLabel" id="fieldNameAllLabel" for="checkbox-table-0">
					<input type="checkbox" class="fieldNameAll" value="" id="checkbox-table-0" data-toggle="checkbox" <?php if(count($this->session->userdata($theDB.".".$theTable)) == count($tableFields)):?>checked<?php endif;?>>
				</label>
			</th>
			<th width="150px"><?php echo $this->lang->line('table_columns_table_field_name')?></th>
			<th width="150px"><?php echo $this->lang->line('table_columns_table_column_type')?></th>
			<th><?php echo $this->lang->line('table_columns_table_index')?></th>
			<th width="175px"><?php if($this->usermodel->hasTablePermission("alter", $theDB, $theTable)):?><?php echo $this->lang->line('table_columns_table_actions')?><?php endif;?></th>
		</tr>
	</thead>
	<tbody>
		<?php $counter = 1;?>
		<?php foreach($tableFields as $field):?>
		<tr>
			<td>
				<?php if($counter >= 1):?><label class="checkbox no-label <?php if(in_array($field['field'], $this->session->userdata($theDB.".".$theTable))):?>checked<?php endif;?> fieldNameLabel" for="checkbox-table-<?php echo $counter;?>">
					<input type="checkbox" value="<?php echo $theTable?>.<?php echo $field['field']?>" id="checkbox-table-<?php echo $counter;?>" data-toggle="checkbox" class="fieldName" <?php if(in_array($field['field'], $this->session->userdata($theDB.".".$theTable))):?>checked<?php endif;?>>
				</label><?php endif;?>
			</td>
			<td>
				<span class="columnLabel" id="<?php echo $field['field'];?>">
					<?php echo $field['field'];?>
				</span>
			</td>
			<td>
				<?php if( $field['type'] == 'int' ):?>
					<?php echo $this->lang->line('table_columns_table_type_number')?>
				<?php elseif( $field['type'] == 'double' ):?>
					<?php echo $this->lang->line('table_columns_table_type_decimal')?>
				<?php elseif( $field['type'] == 'varchar' ):?>
					<?php echo $this->lang->line('table_columns_table_type_small_text')?>
				<?php elseif( $field['type'] == 'text' ):?>
					<?php echo $this->lang->line('table_columns_table_type_big_text')?>
				<?php elseif( $field['type'] == 'blob' ):?>
					<?php echo $this->lang->line('table_columns_table_type_file')?>
				<?php elseif( $field['type'] == 'date' ):?>
					<?php echo $this->lang->line('table_columns_table_type_date')?>
				<?php elseif( $field['type'] == 'select' ):?>
					<?php echo $this->lang->line('table_columns_table_type_select')?>
				<?php endif;?>
			</td>
			<td>
				<?php if( $field['index'] == 'primary' ):?><span class="label label-primary"><?php echo $this->lang->line('table_columns_table_primary_key')?></span><?php endif;?>
				<?php if( $field['index'] == 'unique' ):?><span class="label label-default"><?php echo $this->lang->line('table_columns_table_unique_index')?></span><?php endif;?>
				<?php if( $field['index'] == 'index' ):?><span class="label label-default"><?php echo $this->lang->line('table_columns_table_regular_index')?></span><?php endif;?>
			</td>
			<td>
				<?php if($this->usermodel->hasTablePermission("alter", $theDB, $theTable)):?>
				<a href="#editColumnModal" id="column#<?php echo $field['field'];?>" class="btn btn-xs btn-primary editColumn" data-toggle="modal"><span class="fui-new"></span> <?php echo $this->lang->line('table_columns_table_button_edit')?></a> <a href="<?php echo site_url('columns/delete/'.$theDB."/".$theTable."/".$field['field']);?>" type="button" class="btn btn-xs btn-danger deleteCloumn"><span class="fui-cross-inverted"></span> <?php echo $this->lang->line('table_columns_table_button_delete')?></a>
				<?php endif;?>
			</td>
		</tr>
		<?php $counter++;?>
		<?php endforeach;?>
	</tbody>
</table>