<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
{group_header}
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
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
					<?php if($mine){?>
					<?php foreach($mine as $row){ ?>
					<tr>
						<td class="list-title">
							<a href="<?php echo base_url('admin/post-edit/'.$row->post_random_id); ?>" class="po-link"><?php echo $row->post_title; ?>
							</a>
						</td>
						<td class="list-category">
							<?php echo anchor('admin/post-category/'.$row->category_slug, $row->category_name, array('class' => 'po-link')); ?>
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
							<?php echo anchor('admin/post-delete/'.$row->post_id.'/'.$row->post_featured_img, '<i class="fa fa-fw fa-trash"></i>', array('class'=>'po-link', 'title' => 'Delete')); ?>
						</td>
					</tr>
					<?php }}else{ ?>
					<p>No item found</p>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
{javascript}
{footer}