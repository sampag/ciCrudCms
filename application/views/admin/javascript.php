<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
</div>
</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.min.js');  ?>"></script>	
<script src="<?php echo base_url('assets/js/bootstrap.min.js');  ?>"></script>	
<script src="<?php echo base_url('assets/js/material.min.js');  ?>"></script>
<?php if($this->uri->segment(2) == 'post-list' ){ ?>
<script type="text/javascript">
$(function(){
	$("#checkall input").change(function() {
		var listElements = document.querySelectorAll('.check');

		for(var i=0, n=listElements.length; i<n; i++){
			var element = listElements[i];

			if($('#checkall input').is(":checked")) {
				element.MaterialCheckbox.check();
	  	}
		  else {
				element.MaterialCheckbox.uncheck();
		  }
		}
	});

	$('.check').change(function(){
		var listElements = document.querySelectorAll('.check');

		for(var i=0, n=listElements.length; i<n; i++){
			var element = listElements[i];
			if($('.check input:checked').length == $('.check input').length ) {
				document.querySelector('#checkall').MaterialCheckbox.check();
			}else{
				document.querySelector('#checkall').MaterialCheckbox.uncheck();
			}
		}
	});
});
</script>
<?php } ?>
<?php if($this->uri->segment(2) == 'comment'){ ?>
<script type="text/javascript">
$(function(){
	$("#checkall input").change(function() {
		var listElements = document.querySelectorAll('.check');

		for(var i=0, n=listElements.length; i<n; i++){
			var element = listElements[i];

			if($('#checkall input').is(":checked")) {
				element.MaterialCheckbox.check();
	  	}
		  else {
				element.MaterialCheckbox.uncheck();
		  }
		}
	});

	$('.check').change(function(){
		var listElements = document.querySelectorAll('.check');

		for(var i=0, n=listElements.length; i<n; i++){
			var element = listElements[i];
			if($('.check input:checked').length == $('.check input').length ) {
				document.querySelector('#checkall').MaterialCheckbox.check();
			}else{
				document.querySelector('#checkall').MaterialCheckbox.uncheck();
			}
		}
	});
});
</script>
<?php } ?>
<?php if($this->uri->segment(2) == 'comment-trash'){ ?>
<script type="text/javascript">
$(function(){
	$("#checkall input").change(function() {
		var listElements = document.querySelectorAll('.check');

		for(var i=0, n=listElements.length; i<n; i++){
			var element = listElements[i];

			if($('#checkall input').is(":checked")) {
				element.MaterialCheckbox.check();
	  	}
		  else {
				element.MaterialCheckbox.uncheck();
		  }
		}
	});

	$('.check').change(function(){
		var listElements = document.querySelectorAll('.check');

		for(var i=0, n=listElements.length; i<n; i++){
			var element = listElements[i];
			if($('.check input:checked').length == $('.check input').length ) {
				document.querySelector('#checkall').MaterialCheckbox.check();
			}else{
				document.querySelector('#checkall').MaterialCheckbox.uncheck();
			}
		}
	});
});
</script>
<?php } ?>