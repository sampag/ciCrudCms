<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<?php echo form_open(uri_string().'/restore-multiple'); ?>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>
						<div class="btn-group btn-group-xs">
							<input type="submit" name="restore" value="Restore" class="btn btn-default" title="Restore" >
						</div>
						</th>
						<th>Title</th>
						<th>Categories</th>
						<th>Tags</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					<?php if($item){?>
					<?php foreach($item as $row){ ?>
					<tr>
						<td style="width:70px;">
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect text-center">
								<input type="checkbox" name="post[]" value="<?php echo $row->post_random_id; ?>" class="mdl-checkbox__input">
							</label>
						</td>
						<td>
							<?php
								$title_limit =  character_limiter($row->post_title, 20);
							?>
							<span><?php echo $title_limit; ?></span>
							<div class="text-sm">
								<?php
									echo anchor(uri_string().'/restore/'.$row->post_random_id, 'Restore', array('class' => 'text-muted text-sm po-link'));
								?>
								|
								<?php
									echo anchor(uri_string().'/delete-permanently/'.$row->post_random_id, 'Delete Permanently', array('class' => 'text-muted po-link'));
								?>
							</div>
						</td>
						<td class="width-20">
							<?php 
								if($row->post_category_id == 0){
									echo anchor('admin/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class'=>'post-list'));

								}else{
									echo anchor('admin/post-category/'. $row->category_slug, $row->category_name, array('class'=>'post-list'));
								}
							?>
						</td>
						<td class="text-primary width-20">
							<?php
								$user_name =  $row->first_name.' '.$row->last_name;
								echo anchor('admin/post-author/'. $row->user_id, $user_name, array('class' => 'po-link'));
							?>
						</td>
						<td class="width-20 text-muted">
							<?php 
								echo date('M d, Y', strtotime($row->post_published_created));
							 ?>
						</td>
					</tr>
					<?php }}else{ ?>
					<tr>
						<td colspan="6">No item found</td>
					</tr>
					<?php } ?>
				</tbody>
				<thead>
					<tr>
						<th>
							<div class="btn-group btn-group-xs">
							<input type="submit" name="restore" value="Restore" class="btn btn-default" title="Restore" >
							</div>
						</th>
						<th>Title</th>
						<th>Categories</th>
						<th>Tags</th>
						<th>Created</th>
					</tr>
				</thead>
			</table>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<nav aria-label="Page navigation" class="text-center pull-right">
		{pagination}
	</nav>
	</div>
</div>

{javascript}
<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});
</script>
{footer}