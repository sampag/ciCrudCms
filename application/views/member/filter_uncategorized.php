<?php
defined('BASEPATH')OR exit('No direct script access allowed');

if($count > 1){
	$word_item = plural('Item');
	$word_post = plural('Post');
}else{
	$word_item = singular('Items');
	$word_post = singular('Post');
}
?>
{header}
<div class="row top-15">
	<div class="col-md-6">
		<?php echo anchor('member/post', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Add New', array('class' => 'btn btn-primary btn-sm')); ?>
	</div>
	<div class="col-md-6">
		<?php echo form_open('search-posts', array('class' => 'form-inline pull-right')); ?>
		<div class="input-group">
			<input type="text" name="search_post_title" class="form-control input-sm" placeholder="Search post...">
			<span class="input-group-btn">
				<button type="subbit" class="btn btn-primary btn-sm" type="button">Search</button>
			</span>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
	<div class="row top-15">
		<div class="col-md-6">
			<p class="text-sm"><?php echo anchor(uri_string(), 'Uncategorized'); ?> <?php echo $word_post; ?></p>
		</div>
		<div class="col-md-6 text-right">
			<span class="badge badge-danger"><?php echo $count; ?></span> <?php echo $word_item; ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<?php echo form_open(uri_string().'/trash-multi-post'); ?>
			<div class="table-responsive">
				<table class="table table-hover table-bordered ">
					<thead>
						<tr>
							<th style="width:90px;">
							<?php 
							  	echo form_submit('postTrash', 'Trash', array('class' => 'btn btn-default btn-xs')); 
							?>
							</th>
							<th>Title</th>
							<th>Category</th>
							<th>Tag</th>
							<th>Created</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($uncategorized_post as $row): ?>
						<tr>
							<td style="width:90px;">
							<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
								<input type="checkbox" name="post_trash[]" value="<?php echo $row->post_random_id; ?>" class="mdl-checkbox__input check">
							</label>
							</td>
							<td class="list-title">	
							<div class="po-markup">
								<?php 
									$title_string =  character_limiter($row->post_title, 40);
									echo anchor('member/post-edit/'.$row->post_random_id, $title_string, array('class' => 'po-link')); 
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
							<div class="text-sm">
								<a href="<?php echo base_url('member/post-edit/'.$row->post_random_id); ?>" class="text-muted text-sm po-link">Edit</a> |  
								<?php
									echo anchor(uri_string().'/trash/'.$row->post_random_id, 'Trash', array('class' => 'text-sm text-muted po-link'));
								?>
							</div>
							</td>
							<td>
								<?php
									echo anchor('member/post/'.$row->post_uncategorized_slug, 'Uncategorized', array('class' => 'po-link'));
								?>
							</td>
							<td class="list-tag">
								<?php
									$id = $row->post_id;
									$post_tag = $this->post_term_model->count_post_tag($id);

									if($post_tag){
										foreach($post_tag as $tag): 
										echo anchor('member/post-tag/'.$tag->tag_slug, $tag->tag_name.' ', array('class'=>'post-list'));
										endforeach;
									}else{
										echo '-';
									}
								?>
							</td>
							<td class="text-muted">
								<?php 
									if($row->post_published_created){
										echo date('M d, Y', strtotime($row->post_published_created));
									}
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