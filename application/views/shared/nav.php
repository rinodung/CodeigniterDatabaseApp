<nav class="navbar navbar-inverse navbar-embossed navbar-fixed-top" role="navigation" id="topNav">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
			<span class="sr-only">Toggle navigation</span>
		</button>
		<a class="navbar-brand" href="<?php echo site_url();?>"><img alt="" src="<?php echo base_url();?>images/icons/box.svg" style="width: 30px;"></a>
	</div>
	<div class="collapse navbar-collapse" id="navbar-collapse-01">
		<ul class="nav navbar-nav">
			
			<li class="<?php if($page == 'data'){echo "active";}?> <?php if(isset($dbs)){echo "dropdown";}?>">
				<a href="#" class="<?php if(isset($dbs)){echo "dropdown-toggle";}?>" <?php if(isset($dbs)){echo "data-toggle='dropdown'";}?>><span class="fui-list"></span> <?php if(isset($theDB)){echo $theDB;} else{echo $this->lang->line('menu_databases');}?> <?php if(isset($dbs)):?><b class="caret"></b><?php endif;?></a>
				<span class="dropdown-arrow"></span>
				<ul class="dropdown-menu dbs">
					<?php foreach($dbs as $db):?>
					<li class="db" id="<?php echo $db['db'];?>"><a href="<?php echo site_url('db/'.$db['db']);?>"><span class="fui-list"></span> <?php echo $db['db'];?></a></li>
					<?php endforeach;?>
					<?php if( $this->ion_auth->is_admin() ):?>
					<li class="divider"></li>
					<li><a href="<?php echo site_url('admin/db');?>"><span class="fui-gear"></span> <?php echo $this->lang->line('menu_manage_databases')?></a></li>
					<?php endif;?>
				</ul>
			</li>
			<?php if( $this->usermodel->adminUsers() ):?>
				<li <?php if($page == 'users'):?>class="active"<?php endif;?>><a href="<?php echo site_url('users');?>"><span class="fui-user"></span> <?php echo $this->lang->line('menu_users');?></a></li>
			<?php endif;?>
			<?php if( $this->usermodel->adminUsers() ):?>
				<li <?php if($page == 'roles'):?>class="active"<?php endif;?>><a href="<?php echo site_url('roles');?>"><span class="fui-myspace"></span> <?php echo $this->lang->line('menu_roles_permissions')?></a></li>
			<?php endif;?>
			<?php if( $this->ion_auth->is_admin() ):?>
			<li <?php if($page == 'files'):?>class="active"<?php endif;?>><a href="<?php echo site_url('admin/files');?>"><span class="fui-document"></span> Files</a></li>
			<?php endif;?>
		</ul>
      	<ul class="nav navbar-nav navbar-right">
      		<li class="dropdown">
      	    	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('menu_hi')?>, <?php echo $this->ion_auth->user()->row()->first_name;?> <b class="caret"></b></a>
      	    	<span class="dropdown-arrow"></span>
      	    	<ul class="dropdown-menu">
      	      		<li><a href="<?php echo site_url('account');?>"><?php echo $this->lang->line('menu_my_account')?></a></li>
      	      		<li class="divider"></li>
      	      		<li><a href="<?php echo site_url('logout');?>"><?php echo $this->lang->line('menu_logout')?></a></li>
      	    	</ul>
      	  	</li>
      	  	<li>
      	  		<a href="<?php echo site_url('logout');?>"><span class="visible-sm visible-xs"><?php echo $this->lang->line('menu_logout')?><span class="fui-exit"></span></span><span class="visible-md visible-lg"><span class="fui-exit"></span></span></a>
      	  	</li>
      	</ul>
	</div><!-- /.navbar-collapse -->
</nav><!-- /navbar -->