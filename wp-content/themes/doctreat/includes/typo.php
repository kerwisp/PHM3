<?php
/**
 * @Set Post Views
 * @return {}
 */
if (!function_exists('doctreat_add_dynamic_styles')) {

    function doctreat_add_dynamic_styles() {
		global $theme_settings;
        
		$enable_typo 	= !empty( $theme_settings['typography_option'] ) ? $theme_settings['typography_option'] : '';
		$body_font		= !empty( $theme_settings['regular_typography'] ) ? $theme_settings['regular_typography'] : '';
		$body_p			= !empty( $theme_settings['body_paragraph_typography'] ) ? $theme_settings['body_paragraph_typography'] : '';
		$h1_font		= !empty( $theme_settings['h1_heading_typography'] ) ? $theme_settings['h1_heading_typography'] : '';
		$h2_font		= !empty( $theme_settings['h2_heading_typography'] ) ? $theme_settings['h2_heading_typography'] : '';
		$h3_font		= !empty( $theme_settings['h3_heading_typography'] ) ? $theme_settings['h3_heading_typography'] : '';
		$h4_font		= !empty( $theme_settings['h4_heading_typography'] ) ? $theme_settings['h4_heading_typography'] : '';
		$h5_font		= !empty( $theme_settings['h5_heading_typography'] ) ? $theme_settings['h5_heading_typography'] : '';
		$h6_font		= !empty( $theme_settings['h6_heading_typography'] ) ? $theme_settings['h6_heading_typography'] : '';
		$color_base 	= !empty( $theme_settings['site_colors'] ) ? $theme_settings['site_colors'] : '';
		$custom_css 	= !empty( $theme_settings['custom_css'] ) ? $theme_settings['custom_css'] : '';
		$logo_wide 		= !empty( $theme_settings['logo_wide'] ) ? $theme_settings['logo_wide'] : '';
		
		$loader_wide 		= !empty( $theme_settings['loader_wide'] ) ? $theme_settings['loader_wide'] : '';
		$loader_height 		= !empty( $theme_settings['loader_height'] ) ? $theme_settings['loader_height'] : '';
		
		$pull_loader		= !empty($loader_wide) ? $loader_wide / 2 : ''; 
		
        ob_start();

        if (!empty($enable_typo)) { ?>
        
			body{<?php echo doctreat_extract_typography($body_font); ?>}
			body p{<?php echo doctreat_extract_typography($body_p); ?>}
			body ul {<?php echo doctreat_extract_typography($body_font); ?>}
			body li {<?php echo doctreat_extract_typography($body_font); ?>}
			body h1{<?php echo doctreat_extract_typography($h1_font); ?>}
			body h2{<?php echo doctreat_extract_typography($h2_font); ?>}
			body h3{<?php echo doctreat_extract_typography($h3_font); ?>}
			body h4{<?php echo doctreat_extract_typography($h4_font); ?>}
			body h5{<?php echo doctreat_extract_typography($h5_font); ?>}
			body h6{<?php echo doctreat_extract_typography($h6_font); ?>}
       
        <?php } ?>
		
        <?php
		
        if (!empty($color_base) ) {
			
			$primary_color = !empty( $theme_settings['theme_primary_color'] ) ? $theme_settings['theme_primary_color'] : '';
			$tertiary_color = !empty( $theme_settings['theme_tertiary_color'] ) ? $theme_settings['theme_tertiary_color'] : '';

			$theme_secondary_color 	= !empty( $theme_settings['theme_secondary_color'] ) ? $theme_settings['theme_secondary_color'] : '';
			$theme_footer_color 	= !empty( $theme_settings['theme_footer_color'] ) ? $theme_settings['theme_footer_color'] : '';

            if (!empty($primary_color)) {
                $theme_color = $primary_color;
                ?>
                :root {--themecolor:<?php echo esc_html($theme_color);?>;}
            <?php } 

			if( !empty( $theme_secondary_color ) ){ ?>
				:root {--secthemecolor:<?php echo esc_html($theme_secondary_color);?>;}
			<?php
			}
			if( !empty( $theme_footer_color ) ){ ?>
				:root {--terthemefootercolor:<?php echo esc_html( $theme_footer_color );?>;}
			<?php
			}

			if( !empty( $tertiary_color ) ){ ?>
				:root {--terthemecolor:<?php echo esc_html( $tertiary_color );?>;}
			<?php
			}
		}
		
		if( !empty( $custom_css ) ){
			echo esc_html($custom_css); 
		}
		
		if(!empty($logo_wide)){
			echo '.dc-logo{flex-basis: '.$logo_wide.'px;}';
		}
		
		//loader dynamic settings
		if(!empty($loader_wide) && !empty($pull_loader)){
			
			echo '.preloader-outer.dc-customloader .dc-loader,
			.preloader-outer.dc-customloader .dc-preloader-holder{
				width: 150px;
				height: 150px;
				margin: -75px 0 0 -75px;
			}';
		}
		
        return ob_get_clean();
    }

}