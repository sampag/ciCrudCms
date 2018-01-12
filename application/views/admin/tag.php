<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
	<div class="row">
		<div class="col-md-12">
				<?php echo heading('Tag', 4); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<form action="<?php echo base_url('add-tag'); ?>" method="post" accept-charset="utf-8" id="addTag">
				<input type="hidden" name="csrf_token" value="">
				<div class="form-group">
					<?php
						echo form_label('Name', 'tag_name');
						echo form_input('tag_name', null, array('class' => 'form-control', 'id' => 'tagName'));
					?>
					<span class="help-block err-tag-name status"></span>
				</div>
				<div class="form-group">
					<?php
						echo form_label('Description', 'tag_description');
						echo form_textarea('tag_description', null, array('class' => 'form-control', 'id' => 'tagDesc'));
					?>
					<span class="help-block err-tag-desc status"></span>
				</div>
				<div class="form-group">
					<?php echo form_submit('add_tag', 'Add Tag', array('class' => 'btn btn-flat-primary')); ?>
				</div>
			</form>
		</div>
		<div class="col-md-8">
				<div class="row">
				<div class="col-md-6 term-count">
					<span id="tagCount"></span>
				</div>
				<div class="col-md-6">
					<!-- Search Box -->
					<?php echo form_open('search-tags', array('class' => 'form-inline pull-right')); ?>
						<div class="form-group">
							<?php echo form_input('search_tag_name', NULL, array('class' => 'form-control input-sm', 'placeholder' => 'Search Tags...')); ?>
						</div>
						<div class="form-group">
							<?php echo form_submit('search_tags', 'Search', array('class' => 'btn btn-flat-primary btn-sm')); ?>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
			<br>
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<td>Identification</td>
								<td>Tag</td>
								<td>Slug</td>
								<td>Created @</td>
								<td class="text-center">Actions</td>
							</tr>
						</thead>
						<tbody id="parseTags">
						</tbody>
					</table>
				</div>
			
			<!-- Delete modal -->
			<div id="tagDeleteModal" class="modal fade" tabindex="-1" role="dialog" >
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Confirm Delete</h4>
			      </div>
			      <div class="modal-body">
			        	<p>Delete <span id="tagTitle" class="text-primary"></span> category?</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
			        <button type="button" id="tagDelete" class="btn btn-danger btn-sm">Delete</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
{javascript}
{momentjs}
<script type="text/javascript">
$(function(){

		$(".close").on("click", function(){
			$(".status").html(" ");
		});

		


			$("#addTag").on("submit", function(event){
			event.preventDefault();

				$.ajax({
					url: $(this).attr("action"),
					type: $(this).attr("method"),
					dataType: "JSON",
					data: $(this).serialize(),
					success: function(response){

						if(response.errTagName){
							$(".err-tag-name").html(response.errTagName);
						}

						if(response.errTagDesc){
							$(".err-tag-desc").html(response.errTagDesc);
						}

						if(response.success){
							$("#addTag")[0].reset();
							$(".status").html(" ");
							getTags();
							getTagData(); 
						}

						getCsrf();
					}

				});
		});


		// Delete single tag.
		$("#parseTags").on("click", ".tag-delete", function(){
			$("#tagDeleteModal").modal({
				show: true,
				backdrop: 'static',
				keyboard: true,
			});

			var baseUrl = $("base").attr("href");
			var id = $(this).attr("data");
			var title = $(this).attr("title");

			$("#tagTitle").html(title);

			$("#tagDelete").unbind().click(function(){
				$.ajax({
					type: "ajax",
					url: baseUrl+'delete-tag',
					method: "GET",
					async: false,
					dataType: "JSON",
					data: {id: id},
					success: function(response){

						if(response.success){
							getTags();
							getTagData();
							$("#tagDeleteModal").modal("hide");
							
						}

					}
				});
			});

		});

		// Get all tags.
		getTags(); // executable when document is ready.
		function getTags()
		{	
			var baseUrl = $("base").attr("href");
			$.ajax({
				url: baseUrl+'get-tag',
				type: "GET",
				dataType: "JSON",
				success: function(response){

					if(response.message){
						message = '<tr>' +
								  '<td colspan="5" class="text-center">' + response.message + '</td>' +
								  '</tr>';
						$("#parseTags").html(message);
					}else{
						$("#showTag").html(" ");

						var tags = " ";
						var i;
						for(i=0; i<response.length; i++){
							tags += '<tr>' +
										  '<td>' + response[i].tag_id + '</td>' +
										  '<td>' + response[i].tag_name + '</td>' +
										  '<td>' + response[i].tag_slug + '</td>' +
										  '<td>' + moment(response[i].tag_created).format('L') + '</td>' +
									
										    '<td class="text-center">' + '<a href="'+baseUrl+'admin/tag-edit/'+ response[i].tag_id +'" class="tag-edit" title="Edit"><i class="fa fa-fw fa-pencil-square-o"></i></a> ' +
										  '<a href="javascript:;" title="Delete" data="'+ response[i].tag_id +'" class="tag-delete link" title="Delete"><i class="fa fa-fw fa-trash"></i></a>' + '</td>' +
										  '</tr>';

							$("#parseTags").html(tags);
						}	// foreach
						
					}	

					
						
				}
			});
		}

		$("#tagName").on("keyup", function(){
			$(".err-tag-name").html(" ");
		});
		$("#tagDesc").on("keyup", function(){
			$(".err-tag-desc").html(" ");
		});

		getCsrf();
		function getCsrf()
		{
			var baseUrl = $("base").attr("href");

			$.ajax({
				url: baseUrl+'csrf',
				type: "GET",
				dataType: "JSON",
				success: function(response){
					$("input[name=csrf_token]").val(response.hash);
				}
			});
		}

		getTagData();
		function getTagData()
		{
			var baseUrl = $("base").attr("href");
			$.ajax({
				url: baseUrl+'data-tag',
				type: "GET",
				async: false,
				dataType: "JSON",
				success: function(response){
					
					if(response.tagCount){
						$("#tagCount").html(response.tagCount);
					}
				}
			});
		}

	});
</script>
{footer}