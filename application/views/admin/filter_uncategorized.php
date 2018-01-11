<?php
defined('BASEPATH')OR exit('No direct script access allowed');
	
	foreach($uncategorized_post as $row):
		$id = $row->post_category_id;
	endforeach;

	$count_item = $this->category_model->count_uncategorized_item($id);

	if($count_item > 1){
		$count_result = '<span class="badge badge-danger text-sm">'.$count_item.'</span> Items ';
		$post_count = "Post's";
	}else{
		$count_result = '<span class="badge badge-danger text-sm">'.$count_item.'</span> Item ';
		$post_count = 'Item';
	}

	$post_list =  anchor('admin/post-list','<i class="fa fa-fw fa-sort-amount-desc"></i> Posts list', array('class' => 'btn btn-default'));

?>
{header}
	<div class="row">
		<div class="col-md-12">
			<ul class="list-unstyled list-inline pull-right">
				<li><?php echo $count_result; ?></li>
				<li><?php echo $post_list; ?></li>				
			</ul>
			<?php echo heading('<span class="text-primary">Uncategorized</span> '.$post_count,5);?>
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
							<td>Author</td>
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
									echo anchor('admin/post-edit/'.$row->post_random_id, $title_string, array('class' => 'po-link')); 
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
									echo anchor('admin/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class' => 'po-link'));
								?>
							</td>
							<td class="list-tag">
								<?php
									$id = $row->post_id;
									$post_tag = $this->post_term_model->count_post_tag($id);

									if($post_tag){
										foreach($post_tag as $tag): 
										echo anchor('admin/post-tag/'.$tag->tag_slug, $tag->tag_name.' ', array('class'=>'post-list'));
										endforeach;
									}else{
										echo '-';
									}
								?>
							</td>
							<td class="text-primary">
								<?php
									$user = $row->first_name.' '.$row->last_name;
									echo anchor('admin/post-author/'.$row->user_id, $user);
								?>
							</td>
							<td class="text-muted">
								<?php
									echo time_ago($row->post_created);
								?>
							</td>
						</tr>
					    <?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
{javascript}
{footer}