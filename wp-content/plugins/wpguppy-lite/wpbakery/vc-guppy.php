<?php
/**
 * WP Bakery shortcode
 *
 *
 * @package    WP Guppy
 * @subpackage WP Guppy/admin
 */

if (class_exists('Vc_Manager', false)) {
	class Wp_Guppy_Lite_VC extends WPBakeryShortCode{

		function __construct() {
			add_action('vc_before_init', array(&$this, 'wpguppy_shortcode_init'));
			add_shortcode( 'wpguppy_lite_chat_init', array(&$this, 'wpguppy_lite_chat_init') );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   Shortcode init
		 * @var      base
		 */
		public function wpguppy_shortcode_init()  {
			vc_map(
				array(
					'name'          => esc_html__('WP Guppy Chat','wpguppy-lite'),
					'base'          => 'wpguppy_lite_chat_init',
					'description'   => esc_html__('WP Guppy Chat','wpguppy-lite'),
					'category'      => esc_html__('WP Guppy Chat','wpguppy-lite'),
					'params'        => array(),
				)
			);

		}

		public function wpguppy_lite_chat_init($atts) {?>
			<div class="guppy-wrapper">
				<?php echo do_shortcode('[getGuppyConversation]'); ?>
			</div>
		<?php
		}

	}

	new Wp_Guppy_Lite_VC();
}