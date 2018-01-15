<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<td>Title</td>
						<td>Categories</td>
						<td>Tags</td>
						<td>Created</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php if($item){?>
					<?php foreach($item as $row){ ?>
					<tr>
						<td class="list-category">
							<?php
								$title_limit =  character_limiter($row->post_title, 40);
								if($row->user_id == $user_id){
									echo anchor('member/post-edit/'.$row->post_random_id, $title_limit, array('class' => 'po-link'));
								}else{
									echo '<span>'.$title_limit.'</span>';
								}
							?>
						</td>
						<td class="list-category">
							<?php 
								if($row->post_category_id == '0'){
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
						<td>
							<?php 
								echo time_ago($row->post_created);
							 ?>
						</td>
						<td class="text-center">
							<?php
								if($row->user_id == $user_id){
									echo anchor(uri_string().'/delete/'.$row->post_id.'/'.$row->post_featured_img, '<i class="fa fa-fw fa-trash"></i>', array('class'=>'po-link', 'title' => 'Delete'));
								}else{
									echo '-';
								}
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
						<td>Created</td>
						<td class="text-center">Action</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div><!-- row -->
<div class="row">
	<div class="col-md-12">
		<nav aria-label="Page navigation" class="text-center pull-right">
		{pagination}
	</nav>
	</div>
</div>

{javascript}
{footer}