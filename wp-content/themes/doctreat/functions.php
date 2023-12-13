<?php
/**
 *
 * Theme Files
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */
require_once ( get_template_directory() . '/theme-config/theme-setup/class-theme-setup.php'); //Theme setup
require_once ( get_template_directory() . '/includes/class-notifications.php'); //Theme notifications
require_once ( get_template_directory() . '/includes/scripts.php'); //Theme styles and scripts
require_once ( get_template_directory() . '/includes/sidebars.php'); //Theme sidebars
require_once ( get_template_directory() . '/directory/front-end/hooks.php');
require_once ( get_template_directory() . '/includes/functions.php'); //Theme functionalty

require_once doctreat_override_templates('/includes/class-headers.php'); //headers
require_once doctreat_override_templates('/includes/class-footers.php'); //footers
require_once doctreat_override_templates('/includes/class-titlebars.php'); //Sub headers

require_once ( get_template_directory() . '/includes/google_fonts.php'); // goolge fonts
require_once ( get_template_directory() . '/includes/hooks.php'); //Hooks
require_once ( get_template_directory() . '/includes/template-tags.php'); //Tags
require_once ( get_template_directory() . '/includes/jetpack.php'); //jetpack
require_once ( get_template_directory() . '/theme-config/tgmp/init.php'); //TGM init
require_once ( get_template_directory() . '/includes/constants.php'); //Constants
require_once ( get_template_directory() . '/includes/class-woocommerce.php'); //Woocommerce
require_once ( get_template_directory() . '/directory/front-end/class-dashboard-menu.php');
require_once ( get_template_directory() . '/directory/front-end/functions.php');
require_once ( get_template_directory() . '/directory/front-end/woo-hooks.php');
require_once ( get_template_directory() . '/includes/languages.php');
require_once ( get_template_directory() . '/includes/typo.php');
require_once ( get_template_directory() . '/directory/back-end/dashboard.php');
require_once ( get_template_directory() . '/directory/back-end/functions.php');
require_once ( get_template_directory() . '/directory/front-end/ajax-hooks.php');
require_once ( get_template_directory() . '/directory/front-end/term_walkers.php'); //Term walkers
if( class_exists( 'DoctreatGlobalSettings' ) ) {
    require_once ( get_template_directory() . '/includes/class-pdf.php'); //Hooks
}




function redirect_to_italian_version() {
    // Verifica si Polylang está activo y si el idioma actual es italiano
    if (function_exists('pll_current_language') && pll_current_language() == 'it') {
        // Obtiene la URL actual
        $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Verifica si la URL actual no contiene el segmento '/it/'
        if (strpos($current_url, '/it/') === false) {
            // Construye la URL en italiano
            $italian_url = str_replace(home_url(), home_url('/it'), $current_url);

            // Redirecciona a la URL en italiano
            wp_redirect($italian_url);
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_to_italian_version');
