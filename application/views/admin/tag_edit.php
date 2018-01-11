<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row">
	<div class="col-md-12">
		<?php echo heading('Edit Tag', 4); ?>
	</div>
</div>
<?php if($this->session->flashdata('tag_update_failed')){ ?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout-danger">
      <ul class="list-unstyled text-sm">
      	<?php echo $this->session->flashdata('tag_update_failed'); ?>
      </ul>
     </div>
  </div>
</div>
<?php } ?>
<?php if($this->session->flashdata('tag_update_success')){ ?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout-success">
      <ul class="list-unstyled text-sm">
      	<?php echo $this->session->flashdata('tag_update_success'); ?>
      </ul>
     </div>
  </div>
</div>
<?php } ?>
<br>
<div class="row">
	<div class="col-md-12">
		<?php echo form_open('update-tag/'.$id, array('class' => 'form-horizontal')); ?>
			<div class="form-group">
				<label class="col-sm-1 text-sm">Name</label>
				<?php
					if($this->session->flashdata('tag_name_failed')){
						$return_name = '';
						$return_name_error = 'has-error';
					}else{
						$return_name = $name;
						$return_name_error = '';
					}
				?>
				<div class="col-sm-4 tag-name <?php echo $return_name_error; ?>">
					<?php echo form_input('tag_update_name', $return_name, array('class'=>'form-control')); ?>
					<span class="help-block text-sm">The tag name.</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 text-sm">Slug</label>
				<?php 
					if($this->session->flashdata('tag_slug_failed')){
						$return_slug = NULL;
						$return_slug_error = 'has-error';
					}else{
						$return_slug = $slug;
						$return_slug_error = NULL;
					}
				?>
				<div class="col-sm-4 tag-slug <?php echo $return_slug_error; ?>">
					<?php echo form_input('tag_update_slug', $return_slug, array('class'=>'form-control')); ?>
					<span class="help-block text-sm">The slug is the URL version of the tag name.</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 text-sm">Description</label>
				<div class="col-sm-4">
					<?php echo form_textarea('tag_update_description', $description, array('class'=>'form-control')); ?>
					<span class="help-block text-sm">Description of the tag.</span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-1"></div>
				<div class="col-sm-4">
					<?php echo form_submit('update_tag', 'Save Tag', array('class' => 'btn btn-flat-primary')); ?>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
{javascript}
<script>
	$(function(){
		$(".tag-name").on("keyup", function(){
			$('.tag-name').removeClass("has-error");
		});

		$(".tag-slug").on("keyup", function(){
			$('.tag-slug').removeClass("has-error");
		});
	});
</script>
{footer}