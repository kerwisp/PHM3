<?php
/**
 * Pusher settings
 *
 *
 * @link       https://wp-guppy.com/
 * @since      1.0.0
 *
 * @package    wp-guppy
 * @subpackage wp-guppy/admin/templates
 */
global  $wpguppy_settings;
$pusher = !empty($wpguppy_settings['pusher']) ? $wpguppy_settings['pusher'] : 'disable';
$option = !empty($wpguppy_settings['option']) ? $wpguppy_settings['option'] : array();
$class  = !empty($pusher) && $pusher == 'enable' ? '' : 'hide-if-js';

$app_id         = !empty($option['app_id']) ? $option['app_id'] : '';
$app_key        = !empty($option['app_key']) ? $option['app_key'] : '';
$app_secret     = !empty($option['app_secret']) ? $option['app_secret'] : '';
$app_cluster    = !empty($option['app_cluster']) ? $option['app_cluster'] : '';
?>
<h3><?php esc_html_e('Real-time chat settings','wpguppy-lite');?></h3>
<table class="form-table"  role="chat">
    <tbody>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Pusher settings','wpguppy-lite');?></label></th>
            <td>
                <fieldset>
                    <label><input class="gp-pusher-settings" type="radio" name="wpguppy_settings[pusher]" value="enable" <?php if( !empty($pusher) && $pusher == 'enable') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Enable','wpguppy-lite');?></code></label>
                    <label><input class="gp-pusher-settings" type="radio" name="wpguppy_settings[pusher]" value="disable" <?php if( !empty($pusher) && $pusher == 'disable') {?>checked="checked"<?php } ?>> 
                    <code><?php esc_html_e('Disable','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
        <tr class="gp-pusher-options <?php echo esc_attr($class);?>">
            <th scope="row"><label for="gp-app-id"><span></span></label></th>
            <td><p class="description"><?php echo wp_kses( __( 'We have used <a href="https://pusher.com/channels">Pusher Channel API</a> for the real-time chat experience, you must create channel API keys and add into the below settings. You may <a href="https://www.youtube.com/watch?v=70JOw13QKk8&list=PLuU227tzkYJEix0c4hOmUuo0wYf_4LWc2">check this guide</a>', 'wpguppy-lite' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) );?></p></td>
        </tr>
        <tr class="gp-pusher-options <?php echo esc_attr($class);?>">
            <th scope="row"><label for="gp-app-id"><span><?php esc_html_e('App ID','wpguppy-lite');?></span></label></th>
            <td><input class="regular-text ltr" placeholder="<?php esc_attr_e('Add APP Id here','wpguppy-lite');?>" name="wpguppy_settings[option][app_id]" type="text" value="<?php echo esc_attr($app_id);?>" /></td>
        </tr>
        <tr class="gp-pusher-options <?php echo esc_attr($class);?>">
            <th scope="row"><label for="gp-app-key"><span><?php esc_html_e('App Key','wpguppy-lite');?></span></label></th>
            <td><input class="regular-text ltr" placeholder="<?php esc_attr_e('Add APP key here','wpguppy-lite');?>" name="wpguppy_settings[option][app_key]" type="text" value="<?php echo esc_attr($app_key);?>" /></td>
        </tr>
        <tr class="gp-pusher-options <?php echo esc_attr($class);?>">
            <th scope="row"><label for="gp-app-secret"><span><?php esc_html_e('App Secret','wpguppy-lite');?></span></label></th>
            <td><input class="regular-text ltr" placeholder="<?php esc_attr_e('Add APP secret here','wpguppy-lite');?>" name="wpguppy_settings[option][app_secret]" type="text" value="<?php echo esc_attr($app_secret);?>" /></td>
        </tr>
        <tr class="gp-pusher-options <?php echo esc_attr($class);?>">
            <th scope="row"><label for="gp-app-cluster"><span><?php esc_html_e('App Cluster','wpguppy-lite');?></span></label></th>
            <td><input class="regular-text ltr" placeholder="<?php esc_attr_e('Add APP cluster here','wpguppy-lite');?>" name="wpguppy_settings[option][app_cluster]" type="text" value="<?php echo esc_attr($app_cluster);?>" /></td>
        </tr>
    </tbody>
</table>