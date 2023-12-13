<?php
/**
 *
 * 404 Page
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
get_header();
global $theme_settings;
$title			= !empty( $theme_settings['404_title'] ) ? $theme_settings['404_title'] : esc_html__('Sorry! Page not found', 'doctreat');
$sub_title		= !empty( $theme_settings['404_subtitle'] ) ? $theme_settings['404_subtitle'] : esc_html__('Something Went Wrong', 'doctreat');;
$description	= !empty( $theme_settings['404_description'] ) ? $theme_settings['404_description'] : esc_html__('If you didn\'t find what you were looking for, try a new search!', 'doctreat');;
$img			= !empty( $theme_settings['404_image']['url'] ) ? $theme_settings['404_image']['url'] : get_template_directory_uri().'/images/404.jpg';
?>
<div class="dc-haslayout dc-parent-section">
	<div class="container">
		<div class="row">
			<?php if( !empty( $img ) ){?>
				<div class="col-sm-12 col-md-6">
					<div class="dc-errorpage">
						<figure>
							<img src="<?php echo esc_url( $img );?>" alt="<?php esc_attr_e('404 image','doctreat');?>">
						</figure>
					</div>
				</div>
			<?php } ?>
			<div class="col-sm-12 col-md-6">
				<div class="dc-errorcontent">
					<div class="dc-title">
						<?php if( !empty( $sub_title ) ) {?><h4><?php echo esc_html( $sub_title );?></h4><?php } ?>
						<?php if( !empty( $title ) ) {?><h3><?php echo esc_html( $title );?></h3><?php } ?>
					</div>
					<?php if( !empty( $description ) ){?>
						<div class="dc-description"><p><?php echo do_shortcode( $description );?></p></div>
					<?php } ?>
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
