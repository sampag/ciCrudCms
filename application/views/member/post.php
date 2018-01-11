<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<?php echo form_open_multipart('member/add-post'); ?>
<div class="row">
	<div class="col-md-12">
		<?php echo heading('Add new post', 4); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-9">
		<div class="form-group">
			<?php
				echo form_label('Title', 'post_title');
				echo form_input('post_title', '', array('class' => 'form-control', 'placeholder' => 'Post title...')); 
			?>
			<span class="help-block post-title-status "><?php echo $this->session->flashdata('failed'); ?></span>
		</div>
		<div class="form-group">
			<?php
				echo form_label('Content', 'post_content');
				echo form_textarea('post_content', '', array('id' => 'summernote'));
			?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php
				echo form_label('Category','post_category');
			?>
		     <select name="post_category"  class="selectpicker show-tick form-control"  title="Select category...">
		     	<option value="0">Uncategorized</option>
				<?php foreach($categories as $category): ?>
					<option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
				<?php endforeach; ?>
	       </select>
		</div>
		<div class="form-group">
			 <?php echo form_label('Tags', 'post_tag[]'); ?>
			  <select name="post_tag[]" id="done" class="form-control selectpicker" multiple data-done-button="true">
			  	<?php foreach($tags as $tag): ?>
			    <option value="<?php echo $tag->tag_id; ?>"><?php echo $tag->tag_name; ?></option>
			    <?php endforeach; ?>
			  </select>
		</div>
		<div class="form-group">
			<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
				  <input type="checkbox" name="post_published" id="switch-2" class="mdl-switch__input" value="1">
				  <span class="mdl-switch__label text-sm">Published</span> 
				</label>
		</div>
		<div class="form-group">
			<?php echo form_label('Featured Image', 'post_featured_image'); ?>
			<br>
			<div class="fileinput fileinput-new" data-provides="fileinput">
				  <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
				     <div class="feat-img-def"><small>Set Feature Image</small></div>
				  </div>
				  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
				  </div>
				  <div>
				    <span class="btn btn-default btn-file btn-sm">
				    <span class="fileinput-new">Select image</span>
				    <span class="fileinput-exists">Change</span>
				    <input type="file" name="post_featured_img"></span>
				    <a href="#" class="btn btn-default fileinput-exists btn-sm" data-dismiss="fileinput">Remove</a>
				  </div>
			</div>
		</div>
		<div class="form-group">
			<?php echo form_submit('add_post', 'Add Post', array('class' => 'btn btn-flat-primary')); ?>
		</div>
	</div>
</div>
<?php echo form_close(); ?>





{javascript}
<script type="text/javascript" src="<?php echo base_url('assets/libs/bootstrap-select/bootstrap-select.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/libs/bootstrap-jasny/bootstrap-jasny.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/libs/summernote/summernote.min.js'); ?>"></script>
<script>
	$(function(){

	$("input[name=post_title]").on("keyup", function(){
		$(".post-title-status").html(" ");
	});

	$('.fileinput').fileinput();

    	
	$('#summernote').summernote({
	        toolbar: [
		    ['style', ['bold', 'italic', 'underline', 'clear']],
		    ['para', ['ul', 'ol', 'paragraph']],
		],
		height: 300,
		placeholder: 'Write here...',
		disableResizeEditor: true	
     });

	});
</script>
{footer}