<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row">
	<div class="col-md-12">
		<?php echo heading('<i class="fa fa-fw fa-user-circle"></i> Profile Settings', 4); ?>
	</div>
</div>
<?php
	echo $this->session->flashdata('resize_fail');
?>
<?php if($this->session->flashdata('failed')){ ?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout-danger">
      <ul class="list-unstyled text-sm">
      	<?php echo $this->session->flashdata('failed'); ?>
      </ul>
     </div>
  </div>
</div>
<?php }elseif($this->session->flashdata('success')){ ?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout-success">
      <ul class="list-unstyled text-sm">
      	<?php echo $this->session->flashdata('success'); ?>
      </ul>
     </div>
  </div>
</div>
<?php } ?>
<br>
<div class="row">
	<div class="col-md-7">
		<?php echo form_open_multipart('member/profile-update', array('class' => 'form-horizontal')); ?>
		<div class="form-group">
			<div class="col-sm-12">
				<?php echo heading('Name', 4); ?>
			</div>
		</div>
		  <div class="form-group">
		    <label for="first_name" class="col-sm-3 text-sm profile-label">First Name</label>
		    <div class="col-sm-8">
		      <?php echo form_input('first_name', $first_name, array('class' => 'form-control text-sm uncontrol')); ?>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="last_name" class="col-sm-3 text-sm profile-label">Last Name</label>
		    <div class="col-sm-8">
		      <?php echo form_input('last_name', $last_name, array('class' => 'form-control text-sm uncontrol')); ?>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="nickname" class="col-sm-3 text-sm profile-label">Nickname (<i class="text-danger">required</i>)</label>
		    <div class="col-sm-8">
		      <?php echo form_input('nickname', $nickname, array('class' => 'form-control text-sm uncontrol')); ?>
		    </div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12">
				<?php echo heading('Contact', 4); ?>
			</div>
		   </div>
		   <div class="form-group ">
		    <label for="email" class="col-sm-3 text-sm profile-label">Email (<i class="text-danger">required</i>)</label>
		    <div class="col-sm-8">
		      <?php echo form_input('email', $email, array('class' => 'form-control text-sm uncontrol')); ?>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="website" class="col-sm-3 text-sm profile-label">Website</label>
		    <div class="col-sm-8">
		      <?php echo form_input('website', '', array('class' => 'form-control uncontrol')); ?>
		    </div>
		  </div>
		   <div class="form-group">
			<div class="col-sm-12">
				<?php echo heading('About', 4); ?>
			</div>
			</div>
		  <div class="form-group">
		    <label for="biographical_info" class="col-sm-3 text-sm profile-label">Biographical Info</label>
		    <div class="col-sm-8">
		      <?php echo form_textarea('biographical_info', $bio_info, array('class' => 'form-control uncontrol text-sm')); ?>
		      <span class="help-block text-sm">This may be shown publicly.</span>
		    </div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12">
				<?php echo heading('Account', 4); ?>
			</div>
			</div>
		  <div class="form-group">
		    <label for="new_password" class="col-sm-3 text-sm profile-label">New Password</label>
		    <div class="col-sm-8">
		      <?php echo form_password('new_password', '', array('class' => 'form-control uncontrol')); ?>
		      <span class="help-block text-sm">If changing password</span>
		    </div>
		  </div>
		  <!-- Avatar -->
		  <div class="form-group">
		    <label for="profile_picture" class="col-sm-3 text-sm profile-label">Profile Picture</label>
		    <div class="col-sm-8">
		    	<div class="fileinput fileinput-new" data-provides="fileinput">
				  <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
					    {user_img}
				  </div>
					  <div class="fileinput-preview fileinput-exists thumbnail" style="min-width: 100%; max-height: 100px;">
					  </div>
					  <div>
					    <span class="btn btn-default btn-file btn-sm">
					    <span class="fileinput-new">Select image</span>
					    <span class="fileinput-exists">Change</span>
					    <input type="file" name="profile_picture"></span>
					    <a href="#" class="btn btn-default fileinput-exists btn-sm" data-dismiss="fileinput">Remove</a>
					  </div>
				</div>
		    </div>
		  </div>
		  <div class="form-group">
		  	<div class="col-sm-12">
		  		<?php echo form_submit('update_profile', 'Update Profile', array('class' => 'btn btn-flat-primary btn-sm')); ?>
		  	</div>
		  </div>
		</form>
	</div>
</div>
{javascript}
<script type="text/javascript" src="<?php echo base_url('assets/libs/bootstrap-jasny/bootstrap-jasny.min.js'); ?>"></script>
<script type="text/javascript">
	$(function(){
		$('.fileinput').fileinput();
	});
</script>
{footer}