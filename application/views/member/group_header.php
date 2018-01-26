<?php
defined('BASEPATH')OR exit('No direct script access allowed');


if($this->uri->segment(3) == 'all'){
	$active_all = 'btn-primary';
	$item_count = $count_all;

	if($count_all > 1){
		$word_item = plural('Item');
	}else{
		$word_item = singular('Items');
	}
}else{
	$active_all = NULL;
}


if($this->uri->segment(3) == 'mine'){
	$active_mine = 'btn-primary';
	$item_count = $count_mine;

	if($count_mine > 1){
		$word_item = plural('Item');
	}else{
		$word_item = singular('Items');
	}
}else{
	$active_mine = NULL;
}

if($this->uri->segment(3) == 'published'){
	$active_published = 'btn-primary';
	$item_count = $count_published;

	if($count_published > 1){
		$word_item = plural('Item');
	}else{
		$word_item = singular('Items');
	}
}else{
	$active_published = NULL;
}

?>
<div class="row top-15">
	<div class="col-md-6">
		<?php echo anchor('member/post', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Add New', array('class' => 'btn btn-primary btn-sm')); ?>
	</div>
	<div class="col-md-6">
		<?php echo form_open('member/search-posts', array('class' => 'form-inline pull-right')); ?>
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

		echo anchor('member/post-list/all', 'All ', $all_attr); 
		echo anchor('member/post-list/mine', 'Mine ',  $mine_attr);
		echo anchor('member/post-list/published', 'Published ', $pub_attr); 
		?>
		</div>
	</div>
	<div class="col-md-6 text-right">
		<span class="badge badge-danger"><?php echo $item_count; ?></span> <?php echo $word_item; ?>
	</div>
</div>
<br>