<?php
/**
 * General settings
 *
 *
 * @link       https://wp-guppy.com/
 * @since      1.0.0
 *
 * @package    wp-guppy
 * @subpackage wp-guppy/admin/templates
 */

global  $wpguppy_settings;
$user_rolse = array();
if( function_exists( 'wpguppy_user_roles' ) ) {
	$user_rolse = wpguppy_user_roles();
}
$auto_invite        = !empty($wpguppy_settings['auto_invite']) ? $wpguppy_settings['auto_invite'] : array();
?>

<h3><?php esc_html_e('General settings','wpguppy-lite');?></h3>
<div class="guppy-shortcode-bar">
    <label for="gp-shorcode"><span><?php esc_html_e('Shortcode','wpguppy-lite');?></span></label>
    <input type="text" id="gp-shortcode-coppy" aria-describedby="gp-shorcode-description" value="<?php echo esc_attr('[getGuppyConversation]');?>" class="regular-text code">
    <button type="button" class="gp-copy-code button">
        <span aria-hidden="true" data-code="<?php echo esc_attr('[getGuppyConversation]');?>"><?php esc_html_e('Copy code','wpguppy-lite');?></span>
    </button>
    <p class="description" id="gp-shorcode-description"><?php esc_html_e('Add shortcode to use anywhere in the PHP files. Like below code','wpguppy-lite');?></p><br>
    <code>&lt;?php echo do_shortcode('[getGuppyConversation]');?&gt;</code>
</div>
<h3 class="title"><?php esc_html_e('Role management','wpguppy-lite');?></h3>
<div class="at-chatroles">
    <?php 
    if( !empty($user_rolse) ){
        foreach($user_rolse as $key => $user_rols ) {
            $invite_checked  = '';
            if(!empty($auto_invite) &&  in_array($key,$auto_invite)){
                $invite_checked = 'checked';
            }
            ?>
            <div class="at-chatroles_item">
                <div class="at-chatrole">
                    <div class="at-chatrole_title">
                        <h6><?php echo esc_html($user_rols);?></h6>
                    </div>
                    <div class="at-chatrole_head">
                        <div class="at-roleoption">
                            <div class="at-roleoption_info">
                                <i class="dashicons dashicons-buddicons-pm"></i>
                                <span><?php esc_html_e('You can enable auto invite for this role. This role will be able to start chat with any user from the contact list','wpguppy-lite');?></span>
                            </div>
                            <div class="at-roleoption_radio at-switchbtn">
                                <label>
                                    <span><?php esc_html_e('ON','wpguppy-lite');?></span>
                                    <input type="checkbox" <?php echo esc_attr($invite_checked);?> type="checkbox" name="wpguppy_settings[auto_invite][]" value="<?php echo esc_attr($key);?>" >
                                    <i></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
