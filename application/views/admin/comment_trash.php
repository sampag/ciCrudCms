<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<?php echo br(1); ?>
{comment_header}
<?php echo br(1); ?>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled list-inline pull-right">
			<li>
				{count}
			</li>
		</ul>
		<ul class="list-unstyled list-inline select-all">
			<li>
				<label id ="checkall" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" >
					<input type="checkbox" class="mdl-checkbox__input">
					<span class="mdl-checkbox__label text-sm">Select all</span>
				</label>
			</li>
		</ul>
		
	</div>
</div><!-- row -->
	<?php echo form_open(uri_string().'/restore-multiple'); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th style="width:20px;">
								<?php echo form_submit('commentRestore', 'Restore', array('class' => 'btn btn-default btn-xs')); ?>
							</th>
							<th>Comment</th>
						</tr>
					</thead>
					<tbody>
						<?php if($trash_item){ ?>
						<?php foreach($trash_item as $comment): ?> 
						<tr>
							<td style="width:20px;">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check">
									<input type="checkbox" name="comment_restore[]" value="<?php echo $comment->comment_id; ?>" class="mdl-checkbox__input">
								</label>
							</td>
							<td>
								<div class="media">
						  <div class="media-left">
						    <?php
								$comment_avatar = array(
									'src' => 'assets/img/comment/comment-avatar.png',
									'class' => 'media-object comment-avatar',
								);

								echo img($comment_avatar);
							?>
						  </div>
						  <div class="media-body">
					    		<?php
									echo '<b class="text-muted">'.$comment->comment_name.'</b> commented on <span class="text-muted">'. anchor('admin/post-edit/'.$comment->post_random_id, $comment->post_title). '</span>';
								?>
						  	<ul class="list-unstyled list-inline text-sm">
					    		<li><a href="<?php echo base_url(uri_string().'/comment-restore/'.$comment->comment_id); ?>" class="text-muted">Restore</a></li>
					    		<li><a href="<?php echo base_url(uri_string().'/delete-permanently/'.$comment->comment_id); ?>" class="text-muted">Delete Permanently</a></li>
					    		<li><span class="text-muted"><?php echo timespan($comment->comment_created, time(), 1).' ago'; ?></span></li>
					    	</ul>
						  </div>
						</div>
							</td>
						</tr>
						<?php endforeach; ?>
						<?php }else{ ?>
						<tr>
							<td colspan="2">No item found!</td>
						</tr>
						<?php } ?>
					</tbody>
					<thead>
						<tr>
							<th>
								<?php echo form_submit('commentRestore', 'Restore', array('class' => 'btn btn-default btn-xs')); ?>
							</th>
							<th>Comment</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
	<div class="row">
	<div class="col-md-12">
		<nav aria-label="Page navigation" class="text-center pull-right">
		{pagination}
	</nav>
	</div>
	</div>
{javascript}
{footer}