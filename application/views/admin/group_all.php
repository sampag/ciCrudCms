<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-hovered table-striped">
				<thead>
					<tr>
						<td>Title</td>
						<td>Categories</td>
						<td>Tags</td>
						<td>Authors</td>
						<td>Created</td>
					</tr>
				</thead>
				<tbody>
					<?php if($item){?>
					<?php foreach($item as $row){ ?>
					<tr>
						<td class="width-20">
							<?php
								$title_limit =  character_limiter($row->post_title, 20);
							?>
							<a href="<?php echo base_url('admin/post-edit/'.$row->post_random_id); ?>" class="po-link"><?php echo $title_limit; ?>
							</a>
							<div class="text-sm">
								<a href="<?php echo base_url('admin/post-edit/'.$row->post_random_id); ?>" class="text-muted text-sm po-link">Edit</a> |  
								<?php
									echo anchor(uri_string().'/trash/'.$row->post_random_id, 'Trash', array('class' => 'text-sm text-muted po-link'));
								?>
							</div>
						</td>
						<td class="width-20">
							<?php 
								if($row->post_category_id == 0){
									echo anchor('admin/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class'=>'post-list'));

								}else{
									echo anchor('admin/post-category/'. $row->category_slug, $row->category_name, array('class'=>'post-list'));
								}
							?>
						</td>
						<td class="width-20">
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
						<td class="text-primary width-20">
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
					<?php }}else{ ?>
					<tr>
						<td colspan="6">No item found</td>
					</tr>
					<?php } ?>
				</tbody>
				<thead>
					<tr>
						<td>Title</td>
						<td>Categories</td>
						<td>Tags</td>
						<td>Authors</td>
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
{footer}