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
	<?php echo form_open(uri_string().'/trash-multiple'); ?>
	<div class="row">
	<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-hover table-bordered table-striped">
			<thead>
				<tr>
					<th>
						<?php echo form_submit('commentTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); ?>
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
					    		<li>
					    			<?php if($comment->comment_approved == TRUE){ ?>
					    			<a href="<?php echo base_url(uri_string().'/comment-unapproved/'. $comment->comment_id.'/'); ?>">Unapproved</a>
					    			<?php }else{ ?>
					    			<a href="<?php echo base_url(uri_string().'/comment-approved/'. $comment->comment_id.'/'); ?>">Approved</a>
					    			<?php } ?>
					    		</li>
					    		<li><a href="<?php echo base_url(uri_string().'/comment-trash/'.$comment->comment_id); ?>">Trash</a></li>
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
						<?php echo form_submit('commentTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); ?>
					</th>
					<th>Comment</th>
					<th>Approved</th>
				</tr>
			</thead>
		</table>
	</div>
	</div>
	</div><!-- row -->
	<?php echo form_close(); ?>

	<div class="row">
		<div class="col-md-12">
			<nav aria-label="Page navigation" class="text-center pull-right">
				{pagination}
			</nav>
		</div>
	</div><!-- row -->
{javascript}
{footer}
