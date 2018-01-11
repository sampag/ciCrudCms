<?php
defined('BASEPATH')OR exit('No direct script access allowed');
echo doctype('html5');
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='robots' content='noindex,follow' />
    <title>Login your account</title>
    <?php
       echo $site_favicons;
       echo link_tag('assets/css/bootstrap.min.css');
       echo link_tag('assets/css/admin.css');
    ?>
    <style>
      body,html {
        min-height: 100vh;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        position: relative;
      }
      .login{
            padding-top: 100px; 
        padding-left: 40px;
        padding-right: 40px;
      }
      .form-group-login{
        margin-bottom: 23px;
      }
      .btn-login{
        color: #fff;
        background-color: #4fa5ef;
        border-radius: 2px;
      }
      .btn-login:hover{
        background-color: #3f9bea;
        color: #fff;
      }
      .copyright{
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        font-size: 13px;
      }
    </style>
  </head>
  <body>
  <div class="container">
    <div class="row">
      <div class="col-md-4  col-md-offset-4 login col-xs-12">
        <div class="row">
          <div class="col-md-12">
            <div class="text-center"><?php echo $site_logo; ?></div>
          </div>
        </div>
        <br>
        <div id="infoMessage">
          <?php 
            if($message){
          ?>
          <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
            <?php echo $message; ?>
           </div>
          <?php
            }
          ?>
        </div>
        <?php echo form_open("login");?>
          <div class="form-group-login">
            <?php 
              echo lang('login_identity_label', 'identity');
              echo form_input($identity);
            ?>
          </div>
          <div class="form-group-login">
            <?php 
             echo lang('login_password_label', 'password');
             echo form_input($password);
            ?>
          </div>
          <div class="form-group-login">
            <div class="checkbox">
              <label>
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
                Remember me
              </label>
            </div>
          </div>
          <div class="form-group-login">
            <?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn btn-login btn-block'));?>
          </div>
        <?php echo form_close();?>
        <div class="form-login text-center">
          <a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
        </div>
      </div>
    </div>
  </div>
  <footer class="copyright">
     <p class="text-muted text-center"><?php echo $site_tagline; ?> &copy; <?php echo date('Y'); ?></p>
  </footer>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>  
  <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>  
  </body>
</html>
