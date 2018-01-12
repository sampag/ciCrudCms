<?php
defined('BASEPATH')OR exit('No direct script access allowed');

$add_new = anchor('admin/post', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Add new', array('class' => 'btn btn-flat-primary'));

if($this->uri->segment(3) == 'mine'){
	$active_mine = 'class="active"';
}
?>
<div class="row">
	<div class="col-md-12">
		<h4>Post <?php echo $add_new; ?></h4>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled list-inline pull-right">
			<li>
				<?php echo form_open('search-posts', array('class' => 'form-inline')); ?>
					<div class="form-group">
						<?php echo form_input('search_post_title', '',array('class' => 'form-control', 'placeholder' => 'Search post...')); ?>
					</div>
					<div class="form-group">
						<?php echo form_submit('search_post', 'Search', array('class' => 'btn btn-flat-primary')); ?>
					</div>
				<?php echo form_close(); ?>
			</li>
		</ul>
		<ul class="nav nav-tabs">
		  <li role="presentation"><a href="<?php echo base_url('admin/post-list'); ?>">All</a></li>
		  <li role="presentation" <?php echo $active_mine; ?>><a href="<?php echo base_url('admin/post-list/mine'); ?>">Mine <?php echo $count_mine ?></a></li>
		  <li role="presentation"><a href="#">Published</a></li>
		</ul>
	</div>
</div>