<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
	<div class="row">
		<div class="col-md-12">
			<?php echo heading('Category', 4); ?>
		</div>	
	</div>
	<div class="row">
		<div class="col-md-4">
			<br>
			<form action="<?php echo base_url('add-category'); ?>"  method="post" accept-charset="utf-8" id="addCategory">
				<input type="hidden" name="csrf_token" value="">
				<div class="form-group category-name-group">
					<?php
						echo form_label('Name','category_name');
						echo form_input('category_name', null, array('class' => 'form-control', 'id' => 'categoryName'));
					?>
					<span class="help-block error-category-name status"></span>
				</div>
				<div class="form-group category-description-group">
					<?php
						echo form_label('Description','category_description');
						echo form_textarea('category_description', null, array('class' => 'form-control', 'id' => 'categoryDescription'));
					?>
					<span class="help-block error-category-description status"></span>
				</div>
				<div class="form-group">
					<?php echo form_submit('add_category', 'Add Category', array('class' => 'btn btn-flat-primary')); ?>
				</div>
			</form>
		<!-- MDL TOAST -->
		<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
		<div class="mdl-snackbar__text"></div>
		<button class="mdl-snackbar__action" type="button"></button>
		</div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-6 col-sm-6 term-count">
					<span id="catCount"></span>
				</div>
				<div class="col-md-6 col-sm-6">
					<!-- Search Box -->
					<?php echo form_open('search-categories', array('class' => 'form-inline pull-right')); ?>
						<div class="form-group">
							<?php echo form_input('search_cat_name', NULL, array('class' => 'form-control input-sm', 'placeholder' => 'Search Categories...')); ?>
						</div>
						<div class="form-group">
							<?php echo form_submit('search_categories', 'Search', array('class' => 'btn btn-flat-primary btn-sm')); ?>
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
								<td>Category</td>
								<td>Slug</td>
								<td>Created@</td>
								<td class="text-center">Actions</td>
							</tr>
						</thead>
						<tbody id="parseCategory">
							
						</tbody>
					</table>
				</div>
			<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" >
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Confirm Delete</h4>
			      </div>
			      <div class="modal-body">
			        	<p>Delete <span id="catTitle" class="text-primary"></span> category?</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
			        <button type="button" id="catDelete" class="btn btn-danger btn-sm">Delete</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div><!-- row -->
{javascript}
{momentjs}
{mainjs}
<script type="text/javascript">
	$(function(){

		$(".close").on("click", function(){
			$(".status").html(" ");
		});

		//===================
		// CSRF
		//===================
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

		//===================
		// Category data.
		//===================
		getCategoryData();
		function getCategoryData()
		{
			var baseUrl = $("base").attr("href");
			$.ajax({
				url: baseUrl+'data-category',
				type: "GET",
				async: false,
				dataType: "JSON",
				success: function(response){
					$("#catCount").html(response.categoryCount);
					$("input[name=csrf_token]").val(response.hash);
				}
			});
		}



		//===================
		// Get categories
		//===================
		getCategories(); 
		function getCategories()
		{	
			var baseUrl = $("base").attr("href");
			$.ajax({
				url: baseUrl+'get-category',
				type: "GET",
				dataType: "JSON",
				success: function(response){

					if(response.message){
						var message = '<tr>' +
								  '<td colspan="5" class="text-center">' + response.message + '</td>' +
								  '</tr>';

						$("#parseCategory").html(message);
					}else{
						var categories = " ";
						var i;
						for(i=0; i<response.length; i++){
							categories += '<tr>' +
										  '<td>' + response[i].category_id + '</td>' +
										  '<td>' + response[i].category_name + '</td>' +
										  '<td>' + response[i].category_slug + '</td>' +
										  '<td>' + moment(response[i].category_created).format('L') + '</td>' +
										  '<td class="text-center">' + '<a href="'+baseUrl+'admin/category-edit/'+ response[i].category_id +'" class="cat-edit" title="Edit"><i class="fa fa-fw fa-pencil-square-o"></i></a> ' +
										  '<a href="javascript:;" title="Delete" data="'+ response[i].category_id +'" class="cat-delete link"><i class="fa fa-fw fa-trash"></i></a>' + '</td>' +
										  '</tr>';

							$("#parseCategory").html(categories);
						}
					}

					
				}
			});
		}


		//===================
		// Delete category
		//===================
		$("#parseCategory").on("click", ".cat-delete", function(){
			$("#deleteModal").modal({
				show: true,
				backdrop: 'static',
				keyboard: true,
			});

			var baseUrl = $("base").attr("href");
			var id = $(this).attr("data");
			var title = $(this).attr("title");

			$("#catTitle").html(title);

			$("#catDelete").unbind().click(function(){
				$.ajax({
					type: "ajax",
					url: baseUrl+'delete-category',
					method: "GET",
					async: false,
					dataType: "JSON",
					data: {id: id},
					success: function(response){

						if(response.success){
							$("#deleteModal").modal("hide");
							getCategories();
							getCategoryData();
						}

					}
				});
			});

		});

		//===================
		// Add category
		//===================
			$("#addCategory").on("submit", function(event){
				event.preventDefault();
				var baseUrl = $("base").attr("href");

				$.ajax({
					url: $(this).attr("action"),
					type: $(this).attr("method"),
					dataType: "JSON",
					data: $(this).serialize(),
					success: function(response){

						if(response.errCatName){
							$(".error-category-name").html(response.errCatName);
						}

						if(response.errCatDesc){
							$(".error-category-description").html(response.errCatDesc);
						}

						if(response.success){
							$("#addCategory")[0].reset();
							$(".status").html(" ");

							var snackbarContainer = document.querySelector('#demo-toast-example');
							var data = {message: response.success};
							snackbarContainer.MaterialSnackbar.showSnackbar(data);
							getCategories();
						}
						
						getCategoryData();
					}
				});
			});


		//===================
		// Keyups
		//===================
		$("#categoryName").on("keyup", function(){
			$(".error-category-name").html(" ");
		});

		$("#categoryDescription").on("keyup", function(){
			$(".error-category-description").html(" ");
		});



	});
</script>
{footer}