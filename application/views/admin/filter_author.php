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
			<span class="text-sm">Author</span>
			<div class="btn-group btn-group-sm" role="group" aria-label="...">
				<a href="<?php echo base_url(uri_string()); ?>" class="btn btn-primary"><?php echo $title; ?> (<?php echo $count; ?>)</a>
			</div>
		</div>
	</div>
<br>
<div class="row">
	<div class="col-md-12">
		<?php echo form_open(uri_string().'/trash-multi-post'); ?>
		<div class="table-responsive">
			<table class="table table-hover table-striped table-bordered">
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
					<?php foreach($author_post as $row): ?>
						<tr>
						<td style="width:20px;">
						<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect text-center">
							<input type="checkbox" name="post_trash[]" value="<?php echo $row->post_id; ?>" class="mdl-checkbox__input">
						</label>
						</td>
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
						<td class="text-muted">
							<?php 
								echo date('M d, Y', strtotime($row->post_published_created));
							 ?>
						</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
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
{footer}