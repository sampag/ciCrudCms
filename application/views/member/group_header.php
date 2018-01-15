<?php
defined('BASEPATH')OR exit('No direct script access allowed');

if($this->uri->segment(3) == 'all'){
	$active_all = 'btn-primary';
}else{
	$active_all = NULL;
}

if($this->uri->segment(3) == 'mine'){
	$active_mine = 'btn-primary';
}else{
	$active_mine = NULL;
}

if($this->uri->segment(3) == 'published'){
	$active_published = 'btn-primary';
}else{
	$active_published = NULL;
}

?>

<div class="row top-15">
	<div class="col-md-8">
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

		echo anchor('member/post-list/all', 'All '. $count_all, $all_attr); 
		echo anchor('member/post-list/mine', 'Mine '. $count_mine,  $mine_attr);
		echo anchor('member/post-list/published', 'Published '. $count_published, $pub_attr); 
		?>
		</div>
	</div>
	<div class="col-md-4">
		<?php echo form_open('search-posts', array('class' => 'form-inline pull-right')); ?>
		<div class="input-group">
			<input type="text" name="search_post_title" class="form-control input-sm" placeholder="Search post...">
			<span class="input-group-btn">
				<button type="subbit" class="btn btn-default btn-sm" type="button">Search</button>
			</span>
		</div><!-- /input-group -->
		<?php echo form_close(); ?>
	</div>
</div>
<br>