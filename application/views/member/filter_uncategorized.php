<?php
defined('BASEPATH')OR exit('No direct script access allowed');

if($count > 1){
	$word_item = plural('Item');
	$word_post = plural('Post');
}else{
	$word_item = singular('Items');
	$word_post = singular('Post');
}
?>
{header}
<div class="row top-15">
	<div class="col-md-6">
		<?php echo anchor('member/post', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Add New', array('class' => 'btn btn-primary btn-sm')); ?>
	</div>
	<div class="col-md-6">
		<?php echo form_open('search-posts', array('class' => 'form-inline pull-right')); ?>
		<div class="input-group">
			<input type="text" name="search_post_title" class="form-control input-sm" placeholder="Search post...">
			<span class="input-group-btn">
				<button type="subbit" class="btn btn-primary btn-sm" type="button">Search</button>
			</span>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
	<div class="row top-15">
		<div class="col-md-6">
			<p class="text-sm"><?php echo anchor(uri_string(), 'Uncategorized'); ?> <?php echo $word_post; ?></p>
		</div>
		<div class="col-md-6 text-right">
			<span class="badge badge-danger"><?php echo $count; ?></span> <?php echo $word_item; ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered ">
					<thead>
						<tr>
							<td>Title</td>
							<td>Category</td>
							<td>Tag</td>
							<td>Created</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach($uncategorized_post as $row): ?>
						<tr>
							<td class="list-title">	
							<div class="po-markup">
								<?php 
									$title_string =  character_limiter($row->post_title, 40);
									echo anchor('member/post-edit/'.$row->post_random_id, $title_string, array('class' => 'po-link')); 
								?>
								<div class="po-content hidden">
									<div class="po-body">
									<?php
										if($row->post_featured_img){
										 	 $featured_img = array(
											 	'src' => 'uploads/'.$row->post_featured_img,
											 	'width' => '100%',
											 	'height' => 'auto',
											 	'class' => 'media-object'
											 );
											 echo img($featured_img); 
											 echo $row->post_title;
										}else{
											 $featured_img = array(
											 	'src' => 'assets/img/featured-img/featured-img.jpg',
											 	'width' => '100%',
											 	'height' => 'auto',
											 	'class' => 'media-object'
											 );
											 echo img($featured_img); 
											 echo $row->post_title;
										}
									 ?>
									</div>
								</div>
							</div>
							</td>
							<td>
								<?php
									echo anchor('member/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class' => 'po-link'));
								?>
							</td>
							<td class="list-tag">
								<?php
									$id = $row->post_id;
									$post_tag = $this->post_term_model->count_post_tag($id);

									if($post_tag){
										foreach($post_tag as $tag): 
										echo anchor('member/post-tag/'.$tag->tag_slug, $tag->tag_name.' ', array('class'=>'post-list'));
										endforeach;
									}else{
										echo '-';
									}
								?>
							</td>
							<td class="text-muted">
								<?php
									echo date('m/d/Y', strtotime($row->post_published_created));
								?>
							</td>
						</tr>
					    <?php endforeach; ?>
					</tbody>
					<thead>
						<tr>
							<td>Title</td>
							<td>Category</td>
							<td>Tag</td>
							<td>Created</td>
						</tr>
					</thead>
				</table>
			</div>
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
<script>
$(function(){
	    $('.po-markup > .po-link').popover({
		    trigger: 'hover',
		    html: true,  

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