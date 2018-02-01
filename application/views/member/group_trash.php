<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<?php echo form_open(uri_string().'/restore-multiple'); ?>
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>
						<div class="btn-group btn-group-xs">
							<input type="submit" name="restore" value="Restore" class="btn btn-default" title="Restore" >
						</div>
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
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect text-center">
								<input type="checkbox" name="post[]" value="<?php echo $row->post_random_id; ?>" class="mdl-checkbox__input">
							</label>
						</td>
						<td>
							<?php
								$title_limit =  character_limiter($row->post_title, 20);
							?>
							<span><?php echo $title_limit; ?></span>
							<div class="text-sm">
								<?php
									echo anchor(uri_string().'/restore/'.$row->post_random_id, 'Restore', array('class' => 'text-muted text-sm po-link'));
								?>
								|
								<?php
									echo anchor(uri_string().'/delete-permanently/'.$row->post_random_id, 'Delete Permanently', array('class' => 'text-muted po-link'));
								?>
							</div>
						</td>
						<td class="width-20">
							<?php 
								if($row->post_category_id == '0'){
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
						<div class="btn-group btn-group-xs">
							<input type="submit" name="restore" value="Restore" class="btn btn-default" title="Restore" >
						</div>
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