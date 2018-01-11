<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row">
	<?php 
		// if they have comment
		if($comments){ 
		?>
		<div class="table-reponsive">
		<table class="table table-hover">
		<?php
		foreach($comments as $comment):
	?>
		<tr>
		<td>
			<div class="row comment-con">
				<div class="col-md-5 pull-right comment-status">
					<ul class="list list-unstyled list-inline pull-right">
						<li>
							<?php
								echo anchor('member/comment-delete/'.$comment->comment_id.'/', 'Trash');
							?>
						</li>
						<li>
							<?php
								echo anchor('#', 'Edit');
							?>
						</li>
						<li>
							<a href="<?php echo base_url('admin/comment-approved/'. $comment->comment_id.'/'); ?>" class="btn btn-default btn-sm ">
								<?php
									if($comment->comment_approved == FALSE){
										echo 'Approved';
									}else{
										echo '<i class="fa fa-fw fa-check-circle"></i> Approved';
									}
								?>
							</a>
						</li>
					</ul>
				</div>
				<div class="col-md-7">
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
							<div class="text-sm">
							<?php
								echo '<b class="text-primary">'.$comment->comment_name.'</b>  <span class="text-muted">commented on '. anchor('member/post-edit/'.$comment->post_random_id, $comment->post_title). '</span> </div>';
								
								echo '<span>'.$comment->comment_content.'</span>';
								echo '<div class="text-sm text-muted">'. timespan($comment->comment_created, time(), 1).' ago';
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<?php
		endforeach;
		?>
		</table>
		</div><!-- table-responsive -->
		<?php
		// otherwise if doesn't have
		}else{
	?>
	<?php echo br(10); ?>
	<div class="col-md-12 text-center">
		<img src="<?php echo base_url('assets/img/comment/comment.png'); ?>" class=" text-center" width="100">
		<p class="text-muted text-sm">No comment found</p>
	</div>
	<?php } ?>
</div>
{javascript}
{footer}