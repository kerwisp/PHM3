<?php
/**
 * Media settings
 *
 *
 * @link       https://wp-guppy.com/
 * @since      1.0.0
 *
 * @package    wp-guppy
 * @subpackage wp-guppy/admin/templates
 */
global  $wpguppy_settings;
$default_bell_url       = esc_url(WP_GUPPY_LITE_DIRECTORY_URI.'public/media/notification-bell.wav');
$notification_bell_url  = !empty($wpguppy_settings['notification_bell_url']) ? $wpguppy_settings['notification_bell_url'] : $default_bell_url;

 ?>
<h3><?php esc_html_e('Media settings','wpguppy-lite');?></h3>
<table class="form-table" role="media">
    <tbody>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Notification bell url','wpguppy-lite');?></label></th>
            <td>
                <input name="wpguppy_settings[notification_bell_url]" placeholder="<?php esc_attr_e('Add bell URL','wpguppy-lite');?>" type="text"  value="<?php echo esc_url($notification_bell_url);?>"/>
                <p class="description"><?php esc_html_e('You can upload mp3 or wav file into WordPress media and copy that URL and add here for the ring tune.','wpguppy-lite');?>
            </td>
        </tr>
    </tbody>
</table>