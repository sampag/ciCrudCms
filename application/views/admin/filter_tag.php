<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<br>
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group btn-group-sm pull-right" role="group" aria-label="...">
				<a href="<?php echo base_url('admin/post-list/all'); ?>" class="btn btn-default"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Posts</a>
			</div>
			<span class="text-sm">Tag</span>
			<div class="btn-group btn-group-sm" role="group" aria-label="...">
				<a href="<?php echo base_url(uri_string()); ?>" class="btn btn-primary"><?php echo $title; ?> (<?php echo $count_tag; ?>)</a>
			</div>
		</div>
	</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped">
				<thead>
					<tr>
						<td>Title</td>
						<td>Category</td>
						<td>Tag</td>
						<td>Author</td>
						<td>Created</td>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($post){
						foreach($post as $row): 
					?>
					<tr>
						<td class="list-title">	
							<div class="po-markup">
								<?php 
									// Title
									$title_string =  character_limiter($row->post_title, 40);
									echo anchor('admin/post-edit/'.$row->post_random_id, $title_string, array('class' => 'po-link')); 
								?>
								<div class="po-content hidden">
									<div class="po-body">
									<?php
										if($row->post_featured_img){
										 	 $featured_img = array(
											 	'src' => 'assets/img/featured-img/1500-x-1000/'.$row->post_featured_img,
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
							// Category
							if($row->post_category_id == 0){
								echo anchor('admin/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class' => 'po-link'));
							}else{
								$category = $this->tag_model->get_post_category($row->post_category_id);

								foreach($category as $category_row):
									$category =  anchor('admin/post-category/'. $category_row->category_slug , $category_row->category_name, array('class' => 'po-link'));
								endforeach;
								echo $category;	
							}
						?>
						</td>
						<td class="list-tag">
							<?php
								// Tag
								$id = $row->post_id;
								$post_tag = $this->post_term_model->count_post_tag($id);

								foreach($post_tag as $tag): 
								echo anchor('admin/post-tag/'. $tag->tag_slug, $tag->tag_name.' ', array('class'=>'post-list'));
								endforeach;
							?>
						</td>
						<td class="list-tag">
							<?php
								// Author
								$author = $this->tag_model->get_author($row->user_id);
								$author_name =  $author->first_name. ' '.$author->last_name;
								$author_id = $author->id;
								echo anchor('admin/post-author/'.$author_id, $author_name, array('class' => 'po-link'));
							?>
						</td>
						<td class="list-tag"><?php echo time_ago($row->post_created); ?></td>
					</tr>
					<?php endforeach;  }else{ ?>
					<tr>
						<td colspan="5">No item found</td>
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