<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout bs-callout-warning">
	    <?php echo heading(lang('deactivate_heading'), 4); ?>
	   	<?php echo auto_typography(sprintf(lang('deactivate_subheading'), $user->username)); ?>
	    </div>
  </div>
</div>
<div class="row">
	<div class="col-md-4">
		<?php echo form_open("auth/deactivate/".$user->id);?>
			<div class="form-group">
				<div class="radio">
				<label>
				<input type="radio" name="confirm" value="yes" checked="checked" /> Yes
				</label>
				</div>
				<div class="radio">
				<label>
				<input type="radio" name="confirm" value="no" /> No
				</label>
				</div>
			</div>
			<?php echo form_hidden($csrf); ?>
  			<?php echo form_hidden(array('id'=>$user->id)); ?>
  			<div class="form-group">
  				<?php echo form_submit('submit', lang('deactivate_submit_btn'), array('class' => 'btn btn-flat-primary'));?>
  			</div>
		<?php echo form_close();?>
	</div>
</div>
