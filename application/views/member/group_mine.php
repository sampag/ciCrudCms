<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled list-inline select-all">
			<li>
				<label id ="checkall" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" >
					<input type="checkbox" class="mdl-checkbox__input">
					<span class="mdl-checkbox__label text-sm">Select all</span>
				</label>
			</li>
		</ul>
		<?php echo form_open(uri_string().'/trash-multi-post'); ?>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>
						<?php 
						  	echo form_submit('postTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); 
						?>
						</th>
						<th>Title</th>
						<th>Categories</th>
						<th>Tags</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					<?php if($item){?>
					<?php foreach($item as $row){ ?>
					<tr>
						<td style="width:20px;">
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check">
								<input type="checkbox" name="post_trash[]" value="<?php echo $row->post_random_id; ?>" class="mdl-checkbox__input">
							</label>
						</td>
						<td>
							<?php
								$title_limit =  character_limiter($row->post_title, 40);
							?>
							<a href="<?php echo base_url('member/post-edit/'.$row->post_random_id); ?>" class="po-link"><?php echo $title_limit; ?>
							</a>
							<div class="text-sm">
								<a href="<?php echo base_url('member/post-edit/'.$row->post_random_id); ?>" class="text-muted text-sm po-link">Edit</a> |  
								<?php
									echo anchor(uri_string().'/trash/'.$row->post_random_id, 'Trash', array('class' => 'text-sm text-muted po-link'));
								?>
							</div>
						</td>
						<td class="width-20">
							<?php 
								if($row->post_category_id == 0){
									echo anchor('member/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class'=>'post-list'));

								}else{
									echo anchor('member/post-category/'. $row->category_slug, $row->category_name, array('class'=>'post-list'));
								}
							?>
						</td>
						<td class="width-20">
							<?php
								$id = $row->post_id;
								$post_tag = $this->post_term_model->count_post_tag($id);
															
								if($post_tag){
									foreach($post_tag as $tag):
									echo anchor('member/post-tag/'.$tag->tag_slug, character_limiter($tag->tag_name, 10).' ', array('class'=>'post-list'));
									endforeach;
								}else{
									echo "-";
								}

							?>
						</td>
						<td class="width-20 text-muted">
							<?php 
								if($row->post_published_created){
									echo date('M d, Y', strtotime($row->post_published_created));
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
						<th>
						<?php 
						  	echo form_submit('postTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); 
						?>
						</th>
						<th>Title</th>
						<th>Categories</th>
						<th>Tags</th>
						<th>Created</th>
					</tr>
				</thead>
			</table>
		</div>
		<?php echo form_close(); ?>
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