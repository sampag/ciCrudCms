<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled list-inline pull-right">
			<li>
				<?php echo form_open('search-posts', array('class' => 'form-inline')); ?>
					<div class="form-group">
						<?php echo form_input('search_post_title', '',array('class' => 'form-control', 'placeholder' => 'Search post...')); ?>
					</div>
					<div class="form-group">
						<?php echo form_submit('search_post', 'Search', array('class' => 'btn btn-flat-primary')); ?>
					</div>
				<?php echo form_close(); ?>
			</li>
		</ul>
		<ul class="list-unstyled list-inline">
			<li>{match}</li>
		</ul>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<td>Title</td>
						<td>Category</td>
						<td>Tag</td>
						<td>Created</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($posts){ 
						foreach($posts as $row):
					?>
					<tr>
						<td class="list-title">
							<div class="po-markup">
							<?php 
								$title_limit =  character_limiter($row->post_title, 40);
								echo anchor('admin/post-edit/'.$row->post_random_id, $title_limit, array('class' => 'po-link')); 
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
						<td class="list-category">
							<?php 
								if($row->post_category_id == 0){
									echo anchor('admin/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class'=>'post-list'));

								}else{
									echo anchor('admin/post-category/'. $row->category_slug, $row->category_name, array('class'=>'post-list'));
								}
							?>
						</td>
						<td class="list-tag">
							<?php
								$id = $row->post_id;
								$post_tag = $this->post_term_model->count_post_tag($id);
								
								foreach($post_tag as $tag):
									echo anchor('admin/post-tag/'.$tag->tag_slug, $tag->tag_name.' ', array('class'=>'post-list'));
								endforeach;
						
							?>
						</td>
						<td>
							<?php 
								echo time_ago($row->post_created);
							 ?>
						</td>
						<td class="text-center">
							<?php echo anchor('admin/post-delete/'.$row->post_id.'/'.$row->post_featured_img, '<i class="fa fa-fw fa-trash"></i>', array('class'=>'po-link', 'title' => 'Delete')); ?>
						</td>
					</tr>
					<?php 
							endforeach; 
						}else{
					?>
						<tr>
							<td colspan="5" class="text-center">No item found.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
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