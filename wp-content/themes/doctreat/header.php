<!doctype html>
<!--[if (gt IE 9)|!(IE)]><html lang="en"><![endif]-->
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	?>
	<?php do_action('doctreat_systemloader'); ?>
	<?php do_action('doctreat_app_available'); ?>
	<div id="dc-wrapper" class="dc-wrapper dc-haslayout">
		<?php do_action('doctreat_do_process_headers'); ?>
		<?php 
			if ( ! is_page_template('directory/dashboard.php')) { 
				do_action('doctreat_prepare_search');
			}
		?>
		<?php do_action('doctreat_do_process_titlebar'); ?>
		<main id="dc-main" class="dc-main dc-haslayout">