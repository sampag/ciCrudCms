<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled list-inline pull-right">
			<li>{found}</li>
			<li>
				<?php echo anchor('admin/post-list', '<i class="fa fa-fw fa-sort-amount-desc"></i> Post list', array('class' => 'btn btn-default')); ?>
			</li>
		</ul>
		{post_by}
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
					</tr>
				</thead>
				<tbody>
					<?php foreach($author_post as $row): ?>
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
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
{javascript}
{footer}