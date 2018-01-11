<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<div class="pull-right">
			<?php 
				$plus_icon = '<i class="fa fa-fw fa-plus-circle"></i> ';
				echo anchor('auth/create_group',$plus_icon. lang('index_create_group_link'), array('class' => 'btn btn-default btn-md'));
			?>
		</div>
		<div>
			<?php 
			$create_new_users_button =  anchor('auth/create_user',$plus_icon. lang('index_create_user_link'), array('class' => 'btn btn-flat-primary btn-md'));
			echo $create_new_users_button; 
			?>
		</div>
		<div id="infoMessage"><?php echo $message;?></div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled list-inline pull-right">
			<li>
				<span class="badge badge-danger"><?php echo $this->db->count_all('users'); ?></span> 
				<?php
					if($this->db->count_all('users') > 1){
						echo "Items";
					}else{
						echo "Item";
					}
				?>
			</li>
		</ul>
		<?php echo auto_typography(lang('index_subheading')); ?>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" cellpadding=0 cellspacing=10>
				<tr>
					<th><?php echo lang('index_fname_th');?></th>
					<th><?php echo lang('index_lname_th');?></th>
					<th><?php echo lang('index_email_th');?></th>
					<th><?php echo lang('index_groups_th');?></th>
					<th><?php echo lang('index_status_th');?></th>
					<th><?php echo lang('index_action_th');?></th>
				</tr>
				<?php foreach ($users as $user):?>
					<tr>
			            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
			            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
			            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
						<td>
							<?php foreach ($user->groups as $group):?>
								<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?>
			                <?php endforeach?>
						</td>
						<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
						<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
