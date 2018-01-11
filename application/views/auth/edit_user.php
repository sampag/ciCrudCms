<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout bs-callout-warning">
      <?php echo heading(lang('edit_user_heading'), 4); ?>
      <p class="text-sm"><?php echo lang('edit_user_subheading')?></p>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <?php if($message){ ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <?php echo $message; ?>
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <?php echo form_open(uri_string());?>
      <div class="form-group">
        <?php echo lang('edit_user_fname_label', 'first_name', array('class' => 'text-sm'));?> <br />
        <?php echo form_input($first_name);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_lname_label', 'last_name', array('class' => 'text-sm'));?> <br />
        <?php echo form_input($last_name);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_company_label', 'company', array('class' => 'text-sm'));?> <br />
        <?php echo form_input($company);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_phone_label', 'phone', array('class' => 'text-sm'));?> <br />
        <?php echo form_input($phone);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_password_label', 'password', array('class' => 'text-sm'));?> <br />
        <?php echo form_input($password);?>
      </div>
      <div class="form-group">
        <?php echo lang('edit_user_password_confirm_label', 'password_confirm', array('class' => 'text-sm'));?><br />
        <?php echo form_input($password_confirm);?>
      </div>

      <?php if ($this->ion_auth->is_admin()): ?>
      <?php echo heading(lang('edit_user_groups_heading'), 5 , array('class' => 'text-sm')); ?>  
      <?php foreach ($groups as $group):?>
      <div class="checkbox">
        <label>
             <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                      if ($gID == $grp->id) {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
              ?>
            <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
        </label>
      </div>
      <?php endforeach?>
      <?php endif ?>
       <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>
      
      <div class="form-group">
        <?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn btn-flat-primary btn-sm'));?>
      </div>
    <?php echo form_close();?>
  </div>
</div>



