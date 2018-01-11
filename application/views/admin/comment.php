<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
	<div class="row">
		<div class="col-md-6">
			{comment}
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				{count}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover">
					<?php foreach($comments as $comment): ?>
					<tr>
						<td>
							<div class="row comment-con">
								<div class="col-md-5 pull-right comment-status">
									<ul class="list list-unstyled list-inline pull-right">
										<li>
											<?php
												echo anchor('admin/comment-delete/'.$comment->comment_id.'/', 'Trash');
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
												echo '<b class="text-primary">'.$comment->comment_name.'</b> commented on <span class="text-muted">'. anchor('admin/post-edit/'.$comment->post_random_id, $comment->post_title). '</span> </div>';
												
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
				    <?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
{javascript}
{footer}
