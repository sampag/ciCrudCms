<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
  <div class="col-md-12">
    <?php 
      echo heading(lang('create_user_heading'),4);
      echo auto_typography(lang('create_user_subheading'));
    ?>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div id="infoMessage"><?php echo $message; ?></div>
    <?php echo form_open('auth/create_user'); ?>
      <div class="form-group">
          <?php echo lang('create_user_fname_label', 'first_name');?> <br />
          <?php echo form_input($first_name);?>
      </div>
      <div class="form-group">
          <?php echo lang('create_user_lname_label', 'last_name');?> <br />
          <?php echo form_input($last_name);?>
      </div>
      <div class="form-group">
          <?php
          if($identity_column!=='email') {
              echo '<p>';
              echo lang('create_user_identity_label', 'identity');
              echo '<br />';
              echo form_error('identity');
              echo form_input($identity);
              echo '</p>';
          }
          ?>
      </div>
      <div class="form-group">
          <?php echo lang('create_user_company_label', 'company');?> <br />
          <?php echo form_input($company);?>
      </div>
      <div class="form-group">
          <?php echo lang('create_user_email_label', 'email');?> <br />
          <?php echo form_input($email);?>
      </div>
      <div class="form-group">
          <?php echo lang('create_user_phone_label', 'phone');?> <br />
          <?php echo form_input($phone);?>
      </div>
      <div class="form-group">
          <?php echo lang('create_user_password_label', 'password');?> <br />
          <?php echo form_input($password);?>
      </div>
      <div class="form-group">
          <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
          <?php echo form_input($password_confirm);?>
      </div>
      <div class="form-group">
          <?php echo form_submit('submit', lang('create_user_submit_btn'), array('class' => 'btn btn-md btn-flat-primary'));?>
      </div>
    <?php echo form_close(); ?>
  </div>
</div>


