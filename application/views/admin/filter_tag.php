<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row top-15">
	<div class="col-md-8">
		<?php echo anchor('admin/post', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Add New', array('class' => 'btn btn-primary btn-sm')); ?>
	</div>
	<div class="col-md-4">
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
		<?php
			if($count > 1){
				$word_item = plural('item');
			}else{
				$word_item = singular('items');
			}
		?>
		<p class="text-sm">Tag: <?php echo anchor(uri_string(), $title); ?></p>
	</div>
	<div class="col-md-6 text-right">
		<span class="badge badge-danger"><?php echo $count; ?></span> <?php echo $word_item; ?>
	</div>
</div>
<div class="row top-15">
	<div class="col-md-12">
		<?php echo form_open(uri_string().'/trash-multi-post'); ?>
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped">
				<thead>
					<tr>
						<th>
						<?php 
						  	echo form_submit('postTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); 
						?>
						</th>
						<th>Title</th>
						<th>Category</th>
						<th>Tag</th>
						<th>Author</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if($post){
						foreach($post as $row): 
					?>
					<tr>
						<td style="width:20px;">
						<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect text-center">
							<input type="checkbox" name="post_trash[]" value="<?php echo $row->post_id; ?>" class="mdl-checkbox__input">
						</label>
						</td>
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
											 	'src' => 'assets/img/featured-img/set-featured-img.jpg',
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
							<div class="text-sm">
								<a href="<?php echo base_url('admin/post-edit/'.$row->post_random_id); ?>" class="text-muted text-sm po-link">Edit</a> |  
								<?php
									echo anchor(uri_string().'/trash/'.$row->post_random_id, 'Trash', array('class' => 'text-sm text-muted po-link'));
								?>
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
						<td class="list-tag text-muted">
							<?php 
								echo date('M d, Y', strtotime($row->post_published_created));
							 ?>
						</td>
					</tr>
					<?php endforeach;  }else{ ?>
					<tr>
						<td colspan="5">No item found</td>
					</tr>
					<?php } ?>
				</tbody>
				<thead>
					<th>
					<?php 
					  	echo form_submit('postTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); 
					?>
					</th>
					<th>Title</th>
					<th>Category</th>
					<th>Tag</th>
					<th>Author</th>
					<th>Created</th>
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