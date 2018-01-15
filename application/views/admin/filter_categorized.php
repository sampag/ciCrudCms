<?php
	defined('BASEPATH')OR exit('No direct script access allowed');

	foreach($post_filter as $row){
		$id = $row->post_category_id;
	} 

	$count_item = $this->category_model->count_categorized_item($id);

	if($count_item > 1){
		$count_result = '<span class="badge badge-danger text-sm">'.$count_item.'</span> Items ';
	}else{
		$count_result = '<span class="badge badge-danger text-sm">'.$count_item.'</span> Item ';
	}

	$post_list =  anchor('admin/post-list/all','<i class="fa fa-fw fa-sort-amount-desc"></i> Posts list', array('class' => 'btn btn-default'));

?>
{header}
	<div class="row">
		<div class="col-md-12">
			<ul class="list-unstyled list-inline pull-right">
				<li><?php echo $count_result; ?></li>
				<li><?php echo $post_list; ?></li>
			</ul>
			{cat_title}
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
						<?php foreach($post_filter as $row): ?>
						<tr>
							<td class="list-title">	
							<div class="po-markup">
								<?php 
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
							</td>
							<td class="list-category">
								<?php
									echo anchor('admin/post-category/'. $row->category_slug, $row->category_name, array('class' => 'po-link'));
								?>
							</td>
							<td class="list-tag">
								<?php
									// Tag
									$id = $row->post_id;
									$post_tag = $this->post_term_model->count_post_tag($id);

									if($post_tag){
										foreach($post_tag as $tag): 
										echo anchor('admin/post-tag/'. $tag->tag_slug, $tag->tag_name.' ', array('class'=>'post-list'));
										endforeach;
									}else{
										echo "-";
									}
								?>
							</td>
							<td class="text-primary list-tag">
								<?php
									// Author
									$user = $this->category_model->categorized_user_name($row->user_id);

									if($user){
										echo anchor('admin/post-author/'.$row->user_id, $user, array('class' => 'po-link'));
									}else{
										echo "-";
									}
								?>
							</td>
							<td class="text-muted list-tag">
								<?php
									echo time_ago($row->post_created);
								?>
							</td>
						</tr>
					    <?php endforeach;  ?>
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