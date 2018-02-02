<?php
defined('BASEPATH')OR exit('No direct script access allowed');

if($this->uri->segment(3) == 'all'){
	$active_all = 'btn-flat-primary';
}else{
	$active_all = NULL;
}

if($this->uri->segment(3) == 'mine'){
	$active_mine = 'btn-flat-primary';
}else{
	$active_mine = NULL;
}

if($this->uri->segment(3) == 'published'){
	$active_published = 'btn-flat-primary';
}else{
	$active_published = NULL;
}

if($this->uri->segment(3) == 'trash'){
	$active_trash = 'btn-flat-primary';
}else{
	$active_trash = NULL;
}

?>
<div class="row top-15">
	<div class="col-md-8">
		<?php echo anchor('admin/post', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Add New', array('class' => 'btn btn-flat-primary btn-sm')); ?>
	</div>
	<div class="col-md-4">
		<?php echo form_open('search-posts', array('class' => 'form-inline pull-right')); ?>
		<div class="input-group">
			<input type="text" name="search_post_title" class="form-control input-sm" placeholder="Post title...">
			<span class="input-group-btn">
				<button type="subbit" class="btn btn-primary btn-sm" type="button">Search</button>
			</span>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="row top-15">
	<div class="col-md-6 col-sm-6">
		<div class="btn-group" role="group" aria-label="...">
		<?php 
		$all_attr = array(
			'class' => 'btn btn-default btn-sm '.$active_all.'', 
		);

		$mine_attr = array(
			'class' => 'btn btn-default btn-sm '.$active_mine.'', 
		);

		$pub_attr = array(
			'class' => 'btn btn-default btn-sm '.$active_published.'',
		);

		$trash_attr = array(
			'class' => 'btn btn-default btn-sm '.$active_trash.'',
		);

		echo anchor('admin/post-list/all', 'All', $all_attr); 
		echo anchor('admin/post-list/mine', 'Mine',  $mine_attr);
		echo anchor('admin/post-list/published', 'Published', $pub_attr); 
		echo anchor('admin/post-list/trash', 'Trash', $trash_attr); 
		?>
		</div>
	</div>
	<div class="col-md-6 col-sm-6 text-right">
		<p>
			<?php
				if($count_all > 1){
					$word_item = plural('item');
				}else{
					$word_item = singular('items');
				}

				if($count_mine > 1){
					$word_item = plural('item');
				}else{
					$word_item = singular('items');
				}

				if($count_published > 1){
					$word_item = plural('item');
				}else{
					$word_item = singular('items');
				}

				if($count_trash > 1){
					$word_item = plural('item');
				}else{
					$word_item = singular('items');
				}

				if($this->uri->segment(3) == 'all'){

					echo '<span class="badge badge-danger">'. $count_all.'</span> '. $word_item;

				}elseif($this->uri->segment(3) == 'mine'){

					echo '<span class="badge badge-danger">'. $count_mine.'</span> '. $word_item;

				}elseif($this->uri->segment(3) == 'published'){

					echo '<span class="badge badge-danger">'. $count_published.'</span> '. $word_item;

				}elseif ($this->uri->segment(3) == 'trash') {
					echo '<span class="badge badge-danger">'. $count_trash.'</span> '. $word_item;
				}
			?>
		</p>	
	</div>
</div>
<br>