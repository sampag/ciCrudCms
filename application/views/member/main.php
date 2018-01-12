<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<br>
<div class="row">
	<div class="col-sm-3">
		<div class="tile-progress tile-light">
			<div class="tile-footer">
				<div class="media">
				<div class="media-left">
				<a href="<?php echo base_url('member/post-list'); ?>" class="dash-ico">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
				</a>
				</div>
				<div class="media-body">
				<h4 class="media-heading">
					<span class="timer" data-from="0" data-to="{post_count}" data-speed="1000" data-refresh-interval="50"></span> {post_meter}
				</h4>
				so far in our blog and our website
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="tile-progress tile-light">
			<div class="tile-footer">
				<div class="media">
				<div class="media-left">
				<a href="javascript:void(0)" class="dash-ico">
					<i class="fa fa-folder-open-o" aria-hidden="true"></i>
				</a>
				</div>
				<div class="media-body">
				<h4 class="media-heading">
					<span class="timer" data-from="0" data-to="{category_count}" data-speed="1000" data-refresh-interval="50"></span> {category_meter}
				</h4>
				so far in our blog and our website
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="tile-progress tile-light">
			<div class="tile-footer">
				<div class="media">
				<div class="media-left">
				<a href="javascript:void(0)" class="dash-ico">
					<i class="fa fa-tags" aria-hidden="true"></i>
				</a>
				</div>
				<div class="media-body">
				<h4 class="media-heading">
					<span class="timer" data-from="0" id="tagCount" data-to="{tag_count}" data-speed="1000" data-refresh-interval="50"></span> {tag_meter}
				</h4>
				so far in our blog and our website
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="tile-progress tile-light">
			<div class="tile-footer">
				<div class="media">
				<div class="media-left">
				<a href="<?php echo base_url('member/comment'); ?>" class="dash-ico">
					<i class="fa fa-comments" aria-hidden="true"></i>
				</a>
				</div>
				<div class="media-body">
				<h4 class="media-heading">
					<span class="timer" data-from="0" data-to="{comment_count}" data-speed="1000" data-refresh-interval="50"></span> {comment_meter}
				</h4>
				so far in our blog and our website
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<?php
		  echo anchor('member/post','<i class="fa fa-plus-circle" aria-hidden="true"></i> Add post', array('class' => 'pull-right btn btn-flat-success'));
		?>
		<h4>Recent Post</h4>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<td>Title</td>
						<td>Category</td>
						<td class="text-center">Comment</td>
						<td class="text-center">Published</td>
						<td>Created</td>
					</tr>
				</thead>
				<tbody>
					<?php if($recent_posts){ ?>
					<?php foreach($recent_posts as $recent_post): ?>
					<tr>
						<td>
							<?php
								$title_string =  character_limiter($recent_post->post_title, 40);
							?>
							<div class="po-markup">
								<?php 
									echo anchor('member/post-edit/'.$recent_post->post_random_id, $title_string, array('class' => 'po-link')); 
								?>
								<div class="po-content hidden">
									<div class="po-body">
									<?php
										if($recent_post->post_featured_img){
										 	 $featured_img = array(
											 	'src' => 'assets/img/featured-img/1500-x-1000/'.$recent_post->post_featured_img,
											 	'width' => '100%',
											 	'height' => 'auto',
											 	'class' => 'media-object'
											 );
											 echo img($featured_img); 
											 echo $recent_post->post_title;
										}else{
											 $featured_img = array(
											 	'src' => 'assets/img/featured-img/featured-img.jpg',
											 	'width' => '100%',
											 	'height' => 'auto',
											 	'class' => 'media-object'
											 );
											 echo img($featured_img); 
											 echo $recent_post->post_title;
										}
									 ?>
									</div>
								</div>
							</div>
						</td>
						<td class="list-tag">
							<?php 
								if($recent_post->post_category_id == '0'){
									echo anchor('member/post/'.$recent_post->post_uncategorized_slug, 'Uncategorized', array('class'=>'post-list'));

								}else{
									echo anchor('member/post-category/'. $recent_post->category_slug, $recent_post->category_name, array('class'=>'post-list'));
								}
							?>
						</td>
						<td class="text-center list-tag">
							<?php
								$id = $recent_post->post_id;
								echo $this->comment_model->count_post_comment($id);
							?>
						</td>
						<td class="text-center list-tag">
							<?php
								if($recent_post->post_published == TRUE ){

									echo '<i class="fa fa-eye" data-toggle="tooltip" data-placement="left" title="Published"></i>';
									
								}else{
									echo '<i class="fa fa-eye-slash"></i>';
								}
							?>
						</td>
						<td>
							<?php 
								echo time_ago($recent_post->post_created);
							?>
						</td>
					</tr>
					<?php endforeach; }  ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


{javascript}
<script src="<?php echo base_url('assets/libs/count-to/jquery.countTo.js'); ?>"></script>
<script type="text/javascript">
	$(function(){
		  $('.timer').countTo();

	      $('[data-toggle="tooltip"]').tooltip();

		  $('.po-markup > .po-link').popover({
		    trigger: 'hover',
		    html: true,  // must have if HTML is contained in popover

		    // get the title and conent
		    title: function() {
		      return $(this).parent().find('.po-title').html();
		    },
		    content: function() {
		      return $(this).parent().find('.po-body').html();
		    },

		    container: 'body',
		    placement: 'right'

		  });

	});
</script>
{footer}