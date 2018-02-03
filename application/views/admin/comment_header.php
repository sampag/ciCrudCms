<?php
defined('BASEPATH')OR exit('No direct script access allowed');

if($this->uri->segment(2) == 'comment'){
	$active_comment = 'btn-flat-primary';
}else{
	$active_comment = NULL;
}

if($this->uri->segment(2) == 'comment-trash'){
	$active_trash = 'btn-flat-primary';
}else{
	$active_trash = NULL;
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group btn-group-sm" role="group">
		  <a href="<?php echo base_url('admin/comment'); ?>" class="btn btn-default <?php echo $active_comment; ?>"><i class="fa fa-fw fa-comment"></i> Comment</a>
		  <a href="<?php echo base_url('admin/comment-trash'); ?>" class="btn btn-default <?php echo $active_trash; ?>"><i class="fa fa-fw fa-trash"></i>Trash</a>
		</div>
	</div>
</div>
