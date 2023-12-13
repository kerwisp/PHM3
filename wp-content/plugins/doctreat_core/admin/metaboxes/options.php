<?php
/**
 * @File Type	Page Options
 * @package	 	WordPress
 * @link 		https://themeforest.net/user/amentotech
 */

// die if accessed directly
if (!defined('ABSPATH')) {
    die('no kiddies please!');
}

$form_el = new AMetaboxes();
$menu	= array();
$menu[]	= array( esc_html__('Seo', 'doctreat_core') , 'seo' , 'pushpin' , true );
$menu[]	= array( esc_html__('Sidebar', 'doctreat_core') , 'sidebar' , 'pushpin' , false );
$menu[]	= array( esc_html__('Page Title Bar', 'doctreat_core') , 'pagetitlebar' , 'pushpin' , false );
?>
<div class="dc-main-metaoptions">
	<div class="am_option_tabs">
		<ul><?php $form_el->form_process_general_menu($menu); ?></ul>
	</div>
	<div class='am_metabox'>
		<?php include 'page-options.php'; ?>
	</div>
</div>