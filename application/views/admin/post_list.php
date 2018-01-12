<?php
defined('BASEPATH')OR exit('No direct script access allowed');
$add_new = anchor('admin/post', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Add new', array('class' => 'btn btn-flat-primary'));
?>
{header}
<br>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled list-inline pull-right">
			<li>{post_count}</li>
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
		<?php echo $add_new; ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered text-sm">
				<thead>
					<tr>
						<td>Title</td>
						<td>Category</td>
						<td>Tag</td>
						<td>Author</td>
						<td>Created</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php
						if($pagination_result){
					?>
					<?php foreach($pagination_result as $row ): ?>
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
										 	'src' => 'assets/img/featured-img/1500-x-1000/'.$row->post_featured_img,
										 	'width' => '100%',
										 	'height' => 'auto',
										 	'class' => 'media-object'
										 );
										 echo img($featured_img); 
										 echo '<p class="text-sm po-titles">'.$row->post_title.'</p>';
									}else{
										 $featured_img = array(
										 	'src' => 'assets/img/featured-img/set-featured-img.jpg',
										 	'width' => '100%',
										 	'height' => 'auto',
										 	'class' => 'media-object'
										 );
										 echo img($featured_img); 
										 echo '<p class="text-sm po-titles">'.$row->post_title.'</p>';
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
															
								if($post_tag){
									foreach($post_tag as $tag):
									echo anchor('admin/post-tag/'.$tag->tag_slug, character_limiter($tag->tag_name, 10).' ', array('class'=>'post-list'));
									endforeach;
								}else{
									echo "-";
								}

							?>
						</td>
						<td class="text-primary">
							<?php
								$user_name =  $row->first_name.' '.$row->last_name;
								echo anchor('admin/post-author/'. $row->user_id, $user_name, array('class' => 'po-link'));
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
					<?php endforeach; }  ?>
					 <?php
					 	if($pagination_result == 0){
					 		echo '<tr>';
					 		echo '<td colspan="6">';
					 		echo 'No item found';
					 		echo '</td>';
					 		echo '</tr>';
					 	}
					 ?>
				</tbody>
				<thead>
					<tr>
						<td>Title</td>
						<td>Category</td>
						<td>Tag</td>
						<td>Author</td>
						<td>Created</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
			</table>
		</div>

		<!-- Option modal -->
			<div id="optionModal" class="modal fade" tabindex="-1" role="dialog" >
			  <div class="modal-dialog modal-md" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Options</h4>
			      </div>
			      <div class="modal-body">
			        	
			      </div>
			    </div>
			  </div>
			</div>


	</div><!-- col-md-12 -->
</div><!-- row -->
<div class="col-md-12">
	<nav aria-label="Page navigation" class="text-center pull-right">
		{pagination_links}
	</nav>
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