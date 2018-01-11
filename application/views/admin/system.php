<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{header}
<div class="row">
	<div class="col-md-12">
		<h4><i class="fa fa-fw fa-info-circle"></i> System Information</h4>
		<p class="text-muted text-sm">This Content Management System (CMS) type web application are using the following frameworks and platform.</p>
	</div>
</div>
<div class="row">
	<div class="col-md-3 col-sm-6">
		<a href="http://php.net/" target="_blank" class="thumbnail">{php}</a>
		<p>Language: <span class="text-muted">PHP: Hypertext Preprocessor</span></p>
	</div>
	<div class="col-md-3 col-sm-6">
		<a href="https://codeigniter.com/" target="_blank" class="thumbnail">{ci}</a>
		<p>Backend: <span class="text-muted">Codeigniter v<?php echo CI_VERSION; ?></span></p>
	</div>
	<div class="col-md-3 col-sm-6">
		<a href="http://getbootstrap.com/" target="_blank" class="thumbnail">{bs}</a>
		<p>Frontend: <span class="text-muted">Bootstrap v3.3.7</span></p>
	</div>
	<div class="col-md-3 col-sm-6">
		<a href="https://www.mysql.com/" target="_blank" class="thumbnail">{sql}</a>
		<p>Database: <span class="text-muted"><?php echo $this->db->platform(); echo ' '.$this->db->version(); ?></span></p>
	</div>
</div>
{javascript}
{footer}