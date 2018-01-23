<?php
defined('BASEPATH')OR exit('No direct script access allowed');
echo doctype('html5');
?>

<html lang="en-US" prefix="og: http://ogp.me/ns#">
<head>
<?php echo meta($meta); ?>
<title><?php echo $site_title; ?></title>
	<!-- Optimized Search Engine Optimization -->
	<?php
		$canonical = array(
			'rel'  => 'canonical',
			'href' => current_url(),

		);
		echo link_tag($canonical);
	?>
	<!-- Facebook -->
	<meta property="og:locale" content="en_US" />
	<meta property="og:url" content="<?php echo current_url(); ?>" />
	<meta property="og:type" content="website">
	<meta property="og:title" content="for article title only..."/>
	<meta property="og:description" content="<?php echo $site_description; ?>"/>
	<meta property="og:site_title" content="<?php echo $site_title; ?>"/>
	<meta property="og:fb:app_id" content="App id goes here..."/>
	<!-- Twitter -->
	<meta name="twitter:card" content="summary" >
	<meta name="twitter:title" content="<?php echo $site_title; ?>"/>
	<meta name="twitter:description" content="<?php echo $site_description?>"/>
	<?php
		// Favicon
		echo $favicon_180;
		echo $favicon_32;
		echo $favicon_16;
		//Style
		echo link_tag('assets/css/bootstrap.min.css');
	?>
</head>
<body>
