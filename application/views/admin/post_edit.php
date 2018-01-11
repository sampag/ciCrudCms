<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<?php
	
?>
<div class="row">
	<div class="col-md-2">
		<?php echo heading('Edit post', 4); ?>
	</div>
	<div class="col-md-6 alert-group">
		<?php if($this->session->flashdata('post_success')){ ?>
		<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <?php echo $this->session->flashdata('post_success'); ?></div>
		<?php } ?>
	</div>
	<div class="col-md-4 alert-group">
		<?php echo anchor('admin/post-list', '<i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Post List', array('class' => 'btn btn-default pull-right')); ?>
	</div>
</div>
<?php 
// Failed updation
if($this->session->flashdata('post_update_failed')){ 
?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout-danger">
      <ul class="list-unstyled text-sm">
      	<?php echo $this->session->flashdata('post_update_failed'); ?>
      </ul>
     </div>
  </div>
</div>
<?php 
// Success updation
}elseif($this->session->flashdata('post_update_success')){ ?>
<div class="row">
  <div class="col-md-12">
    <div class="bs-callout-success">
      <ul class="list-unstyled text-sm">
      	<?php echo $this->session->flashdata('post_update_success'); ?>
      </ul>
     </div>
  </div>
</div>
<?php } ?>

<?php echo form_open_multipart('admin/post-update/'.$this->uri->segment(3)); ?>
	<div class="row">
		<div class="col-md-9">
			<div class="form-group">
				<?php
					echo form_label('Title', 'edit_post_title');
					echo form_input('edit_post_title', $post_title, array('class' => 'form-control'));
				?>
			</div>
			<div class="form-group">
				<p class="text-sm">{permalink}</p>
			</div>	
			<div class="form-group">
				<?php
					echo form_label('Content', 'edit_post_content');
					echo form_textarea('edit_post_content', $post_content, array('id' => 'summernote'));
				?>
				<span class="help-block text-sm">
					<?php 
						/**
						* Ex. Last edited on August 15, 2017 at 8:20pm 
						*/
						echo $last_updated;
						echo br(1);
					?>
					</span>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<?php echo form_label('Category', 'edit_post_category'); ?>
				 <select name="edit_post_category"  class="selectpicker show-tick form-control cstm-border"  id="categoryId">
				 	<option value="0">Uncategorized</option>
					<?php foreach($categories as $category): ?>
						<option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
					<?php endforeach; ?>
		        </select>
			</div>
			<div class="form-group">
				<?php echo form_label('Tags', 'edit_post_tag[]'); ?>
				<select name="edit_post_tag[]" id="tagId" class="form-control selectpicker cstm-border" multiple >
		

			  	<?php 
			  	foreach($tags as $tag): ?>
			    	 <option 
			    	 value="<?php echo $tag->tag_id; ?>"
			    	 <?php 
			    	 	$checked = $this->post_term_model->checked_tag($tag->tag_id, $id);

			    	 	if($checked){
			    	 		echo "selected";
			    	 	}else{
			    	 		echo NULL;
			    	 	}
			    	 ?>
			    	 ><?php echo $tag->tag_name; ?></option> 
			    <?php endforeach; ?>
			    </select>
			</div>
			<div class="form-group">
            <div class="form-group">
	      		<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-2">
				  <input type="checkbox" name="edit_post_published" id="switch-2" class="mdl-switch__input" value="1" {published_status}>
				  <span class="mdl-switch__label text-sm">Published</span> 
				</label>
			</div>
			</div>
			<div class="form-group">
				<?php echo form_label('Featured Image', 'edit_post_featured_image'); ?>
				<br>
				<div class="fileinput fileinput-exists" data-provides="fileinput">
					  <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
					  </div>
					  <div class="fileinput-preview fileinput-exists thumbnail" style="min-width: 200px; height: 150px;">
						 {featured_img}
					  </div>
					  <div>
					    <span class="btn btn-default btn-file btn-sm">
					    <span class="fileinput-new">Select image</span>
					    <span class="fileinput-exists">Change</span>
					    <input type="file" name="edit_featured_img"></span>
					    <a href="#" class="btn btn-default fileinput-exists btn-sm" data-dismiss="fileinput">Remove</a>
					  </div>
					</div>
			</div>
			<div class="form-group">
				<?php echo form_submit('edit_post', 'Update Post', array('class' => 'btn btn-flat-primary')); ?>
			</div>
		</div>	
	</div>
	<?php echo form_close(); ?>
	<div class="row">
		<div class="col-md-7 col-xs-6">
			{comment_header}
		</div>
		<div class="col-md-2 col-xs-6">
			<p class="pull-right">{comment_count}</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-9">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-striped">
					<?php foreach($comment as $row): ?>
						<tr>
							<div class="media">
								<div class="media-left">
									<?php
										$comment_avatar = array(
											'src' => 'assets/img/comment/comment-avatar.png',
											'class' => 'media-object comment-avatar',
										);

										echo img($comment_avatar);
									?>
								</div>
								<div class="media-body">
									<div class="text-sm">
									<?php
										echo '<b class="text-primary">'.$row->comment_name.'</b><br>';
										
										echo '<span>'.$row->comment_content.'</span>';
										echo '<div class="text-sm text-muted">'. timespan($row->comment_created, time(), 1).' ago';
									?>
									</div>
								</div>
							</div>
						</tr>
				    <?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
{javascript}
<script src="<?php echo base_url('assets/libs/summernote/summernote.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/bootstrap-select/bootstrap-select.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/libs/bootstrap-jasny/bootstrap-jasny.min.js'); ?>"></script>
<script>
	$(function(){
		$('.fileinput').fileinput();

		// Category ============//
		$('#categoryId').selectpicker({
		    size: 4
		});

		var optionToSet = '{post_category}';
		$("#categoryId option").filter(function(){
		  	var hasText = $.trim($(this).text()) ==  optionToSet;
		    if(hasText){
			      $("#categoryId").val($(this).val());
			      $("#categoryId").selectpicker('refresh')
		    }
		}).prop('selected', true);



		$('#summernote').summernote({
		    toolbar: [
			    ['style', ['bold', 'italic', 'underline', 'clear']],
			    ['para', ['ul', 'ol', 'paragraph']],
			],
			height: 337,
			placeholder: 'Write here...',
			disableResizeEditor: true	
	    });
	});
</script>
{footer}