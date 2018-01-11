<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-md-12">
		<div class="bs-callout bs-callout-warning">
	    <?php echo heading(lang('edit_group_heading'), 4); ?>
	   	<?php echo auto_typography(lang('edit_group_subheading')); ?>
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<?php if($message){ ?>
	    <div class="alert alert-danger alert-dismissible fade in" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	    <div id="infoMessage"><?php echo $message;?></div>
	    </div>
	    <?php } ?>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<?php echo form_open(current_url());?>
			<div class="form-group">
			   <?php echo lang('edit_group_name_label', 'group_name');?> <br />
               <?php echo form_input($group_name);?>
			</div>
			<div class="form-group">
			  <?php echo lang('edit_group_desc_label', 'description');?> <br />
              <?php echo form_input($group_description);?>	
			</div>
			<div class="form-group">
				<?php echo form_submit('submit', lang('edit_group_submit_btn'), array('class' => 'btn btn-flat-primary'));?>
			</div>
		<?php echo form_close();?>
	</div>
</div>

