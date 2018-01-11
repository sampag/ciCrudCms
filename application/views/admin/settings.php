<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row">
	<div class="col-md-12">
		<?php echo heading('<i class="fa fa-fw fa-wrench"></i>Settings', 4); ?>
		<?php if($this->session->flashdata('settings_error')){ ?>
		<div class="bs-callout-danger">
			<ul class="list-unstyled text-sm">
				<?php echo $this->session->flashdata('settings_error'); ?>
			</ul>
		</div>
		<?php }elseif($this->session->flashdata('settings_save')){ ?>
		<div class="bs-callout-success">
			<ul class="list-unstyled text-sm">
				<?php echo $this->session->flashdata('settings_save'); ?>
			</ul>
		</div>
		<?php } ?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<?php echo form_open_multipart('save-settings'); ?>
			<div class="row">
				<div class="col-md-12">
					<?php echo heading('Site Identity', 4); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<p class="text-sm">Site Title</p>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<?php
							echo form_input('site_title', $site_title, array('class' => 'form-control uncontrol text-sm'));
						?>
					</div>		
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<p class="text-sm">Site Tagline</p>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<?php
							echo form_input('site_tagline', $tagline, array('class' => 'form-control uncontrol text-sm'));
						?>
					</div>		
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<p class="text-sm">Site Logo</p>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<div class="form-group">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								  <div class="fileinput-new thumbnail" style="width: 200px; height: auto;">
								    {site_logo}
								  </div>
								  <div class="fileinput-preview fileinput-exists thumbnail" style="min-width: 200px; height: auto;">

					 			 </div>
								  <div>
								    <span class="btn btn-default btn-file btn-sm">
								    <span class="fileinput-new">Select Logo</span>
								    <span class="fileinput-exists">Change</span>
								    <input type="file" name="settings_site_logo"></span>
								    <a href="#" class="btn btn-default fileinput-exists btn-sm" data-dismiss="fileinput">Remove</a>
								  </div>
							</div>
							<small class="help-block">Site logo must be atleast 300 by 100 pixels wide and tall.</small>
						</div>
					</div>		
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<p class="text-sm">Site Icon</p>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<div class="form-group">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								  <div class="fileinput-new thumbnail" style="width: 100px; height: auto;">
								    {favicon_32_x_32}
								  </div>
								  <div class="fileinput-preview fileinput-exists thumbnail" style="min-width: 100px; height: auto;">

					 			 </div>
								  <div>
								    <span class="btn btn-default btn-file btn-sm">
								    <span class="fileinput-new">Select Icon</span>
								    <span class="fileinput-exists">Change</span>
								    <input type="file" name="settings_site_icon"></span>
								    <a href="#" class="btn btn-default fileinput-exists btn-sm" data-dismiss="fileinput">Remove</a>
								  </div>
							</div>
							<small class="help-block">Site icon must be square, and atleast 500 pixels width and height.</small>
						</div>
					</div>		
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php echo heading('Reading', 4); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
				<p class="text-sm">Number of items per page</p>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<input type="number" class="form-control uncontrol" name="settings_pagination" class="form-control text-sm" id="pagination" value=" ">
					</div>		
				</div>
			</div>
			<div class="form-group">
				<?php echo form_submit('save_options', 'Save changes', array('class' => 'btn btn-flat-primary btn-sm')); ?>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
{javascript}
<script type="text/javascript" src="<?php echo base_url('assets/libs/bootstrap-jasny/bootstrap-jasny.min.js');  ?>"></script>	
<script>
	$(function(){

		$("#pagination").val('<?php echo $pagination; ?>');
	});
</script>
{footer}