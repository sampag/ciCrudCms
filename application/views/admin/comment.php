<?php
defined('BASEPATH')OR exit('No direct script access allowed');

if($this->uri->segment(2) == 'comment'){
	$active_comment = 'btn-flat-primary';
}else{
	$active_comment = NULL;
}

?>
{header}
	<?php echo br(1); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group btn-group-sm" role="group">
			  <a href="<?php echo base_url('admin/comment'); ?>" class="btn btn-default <?php echo $active_comment; ?>"><i class="fa fa-fw fa-comment"></i> Comment</a>
			  <a href="#" class="btn btn-default"><i class="fa fa-fw fa-trash"></i>Trash</a>
			</div>
			<span class="pull-right">
				{count}
			</span>
		</div>
	</div>
	<?php echo br(1); ?>
	<ul class="list-unstyled list-inline select-all">
		<li>
			<label id ="checkall" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" >
				<input type="checkbox" class="mdl-checkbox__input">
				<span class="mdl-checkbox__label text-sm">Select all</span>
			</label>
		</li>
	</ul>
	<div class="table-responsive">
		<table class="table table-hover table-bordered table-striped">
			<thead>
				<tr>
					<th>
						<?php echo form_submit('postTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); ?>
					</th>
					<th>Comment</th>
					<th>Approved</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if($comments){ 
					foreach($comments as $comment): 
				?>
				<tr>
					<td style="width:20px;">
						<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check">
							<input type="checkbox" name="comment_trash[]" value="<?php echo $comment->comment_id; ?>" class="mdl-checkbox__input">
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
									echo '<b class="text-primary">'.$comment->comment_name.'</b> commented on <span class="text-muted">'. anchor('admin/post-edit/'.$comment->post_random_id, $comment->post_title). '</span>';
								?>
						  	<ul class="list-unstyled list-inline text-sm">
					    		<li><a href="<?php echo base_url(uri_string().'/comment-approved/'. $comment->comment_id.'/'); ?>">Approved</a></li>
					    		<li><a href="<?php echo base_url('admin/comment-delete/'.$comment->comment_id); ?>">Trash</a></li>
					    		<li><span class="text-muted"><?php echo timespan($comment->comment_created, time(), 1).' ago'; ?></span></li>
					    	</ul>
						  </div>
						</div>
					</td>
					<td class="text-center">
						<?php
							if($comment->comment_approved == TRUE){
								echo '<i class="fa fa-fw fa-check-circle text-flat-success"></i>';
							}else{
								echo "-";
							}
						?>
					</td>
				</tr>
				<?php
				     endforeach; 
				    } 
				 ?>
			</tbody>
			<thead>
				<tr>
					<th>
						<?php echo form_submit('postTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); ?>
					</th>
					<th>Comment</th>
					<th>Approved</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="row">
	<div class="col-md-12">
		<nav aria-label="Page navigation" class="text-center pull-right">
		{pagination}
	</nav>
	</div>
	</div><!-- row -->
{javascript}
{footer}
