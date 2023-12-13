<?php
/**
 * Tabs settings
 *
 *
 * @link       https://wp-guppy.com/
 * @since      1.0.0
 *
 * @package    wp-guppy
 * @subpackage wp-guppy/admin/templates
 */
global  $wpguppy_settings;
$default_active_tab         = !empty($wpguppy_settings['default_active_tab']) ? $wpguppy_settings['default_active_tab'] : '';
$enabled_tabs               = !empty($wpguppy_settings['enabled_tabs']) ? $wpguppy_settings['enabled_tabs'] : array();
$floating_window            = !empty($wpguppy_settings['floating_window']) ? $wpguppy_settings['floating_window'] : 'enable';
$floating_messenger         = !empty($wpguppy_settings['floating_messenger'])  ? $wpguppy_settings['floating_messenger'] : 'enable';
$whatsapp_support           = !empty($wpguppy_settings['whatsapp_support'])     ? $wpguppy_settings['whatsapp_support'] : 'disable';
$messanger_page_id          = !empty($wpguppy_settings['messanger_page_id']) ? $wpguppy_settings['messanger_page_id'] : '0';
$dock_layout_image          = !empty($wpguppy_settings['dock_layout_image']) ? $wpguppy_settings['dock_layout_image'] : '';
$whatsapp_bg_image          = !empty($wpguppy_settings['whatsapp_bg_image'])    ? $wpguppy_settings['whatsapp_bg_image'] : '';

$delete_message             = !empty($wpguppy_settings['delete_message']) ? $wpguppy_settings['delete_message'] : 'enable';
$clear_chat                 = !empty($wpguppy_settings['clear_chat']) ? $wpguppy_settings['clear_chat'] : 'enable';
$hide_acc_settings          = !empty($wpguppy_settings['hide_acc_settings']) ? $wpguppy_settings['hide_acc_settings'] : 'no';
 ?>
<h3><?php esc_html_e('Tabs settings','wpguppy-lite');?></h3>
<table class="form-table" role="media">
    <tbody>
        <tr>
            <th scope="row"><label><span><?php esc_html_e('Default active tab','wpguppy-lite');?></span></label></th>
            <td>
                <fieldset>
                    <label><input type="radio" name="wpguppy_settings[default_active_tab]" value="contacts" <?php if( !empty($default_active_tab) && $default_active_tab == 'contacts') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Contacts list','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[default_active_tab]" value="messages" <?php if( !empty($default_active_tab) && $default_active_tab == 'messages') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Message list','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[default_active_tab]" value="friends" <?php if( !empty($default_active_tab) && $default_active_tab == 'friends') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Friend list','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[default_active_tab]" value="blocked" <?php if( !empty($default_active_tab) && $default_active_tab == 'blocked') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Blocked list','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[default_active_tab]" value="customer_support" <?php if( !empty($default_active_tab) && $default_active_tab == 'customer_support') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Customer support chat','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><label><span><?php esc_html_e('Enable tabs','wpguppy-lite');?></span></label></th>
            <td>
                <fieldset>
                    <label>
                        <input <?php echo in_array('contacts', $enabled_tabs) ? esc_attr('checked') : '' ;?> type="checkbox" name="wpguppy_settings[enabled_tabs][]" value="contacts">
                        <code><?php echo esc_html('Contacts list','wpguppy-lite');?></code> 
                    </label>

                    <label>
                        <input <?php echo in_array('messages', $enabled_tabs) ? esc_attr('checked') : '' ;?> type="checkbox" name="wpguppy_settings[enabled_tabs][]" value="messages">
                        <code><?php echo esc_html('Messages list','wpguppy-lite');?></code>
                    </label>

                    <label>
                        <input <?php echo in_array('friends', $enabled_tabs) ? esc_attr('checked') : '' ;?> type="checkbox" name="wpguppy_settings[enabled_tabs][]" value="friends">
                        <code><?php echo esc_html('Friends list','wpguppy-lite');?></code> 
                    </label>

                    <label>
                        <input <?php echo in_array('blocked', $enabled_tabs) ? esc_attr('checked') : '' ;?> type="checkbox" name="wpguppy_settings[enabled_tabs][]" value="blocked">
                        <code><?php echo esc_html('Blocked list','wpguppy-lite');?></code> 
                    </label>

                    <label>
                        <input <?php echo in_array('customer_support', $enabled_tabs) ? esc_attr('checked') : '' ;?> type="checkbox" name="wpguppy_settings[enabled_tabs][]" value="customer_support">
                        <code><?php echo esc_html('Customer support chat','wpguppy-lite');?></code> 
                    </label>
                </fieldset>
            </td>
        </tr>
    </tbody>
</table>
<h3><?php esc_html_e('Chat settings','wpguppy-lite');?></h3>
<table class="form-table" role="media">
    <tbody>
        <tr>
            <th scope="row"><label><span><?php esc_html_e('Select Messanger Page','wpguppy-lite');?></span></label></th>
            <td>
            <fieldset>  
                <?php
                    $args = array(
                        'depth'                 => 0,
                        'child_of'              => 0,
                        'selected'              => $messanger_page_id ,
                        'echo'                  => 1,
                        'name'                  => 'wpguppy_settings[messanger_page_id]',
                        'id'                    => null, // string
                        'class'                 => null, // string
                        'show_option_none'      => null, // string
                        'show_option_no_change' => null, // string
                        'option_none_value'     => null, // string
                    );
                    wp_dropdown_pages( $args ); 
                ?>
            </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Dock layout Image','wpguppy-lite');?></label></th>
            <td>
                <input name="wpguppy_settings[dock_layout_image]" placeholder="<?php esc_attr_e('Dock layout image URL','wpguppy-lite');?>" type="text"  value="<?php echo esc_url($dock_layout_image);?>"/>
                <p class="description"><?php esc_html_e('You can upload dock layout image into WordPress media and copy that URL and add here for dock image.','wpguppy-lite');?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Whatsapp chat background image','wpguppy-lite');?></label></th>
            <td>
                <input name="wpguppy_settings[whatsapp_bg_image]" placeholder="<?php esc_attr_e('Image URL','wpguppy-lite');?>" type="text"  value="<?php echo esc_url($whatsapp_bg_image);?>"/>
                <p class="description"><?php esc_html_e('You can upload a background image into WordPress media and copy that URL and add it here for chat backgroud image.','wpguppy-lite');?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Enable floating window','wpguppy-lite');?></label></th>
            <td>
                <fieldset>
                    <label><input type="radio" name="wpguppy_settings[floating_window]" value="enable" <?php if( !empty($floating_window) && $floating_window == 'enable') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Enable','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[floating_window]" value="disable" <?php if( !empty($floating_window) && $floating_window == 'disable') {?>checked="checked"<?php } ?>> 
                    <code><?php esc_html_e('Disable','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Enable floating messenger','wpguppy-lite');?></label></th>
            <td>
                <fieldset>
                    <label><input type="radio" name="wpguppy_settings[floating_messenger]" value="enable" <?php if( !empty($floating_messenger) && $floating_messenger == 'enable') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Enable','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[floating_messenger]" value="disable" <?php if( !empty($floating_messenger) && $floating_messenger == 'disable') {?>checked="checked"<?php } ?>> 
                    <code><?php esc_html_e('Disable','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Enable whatsapp support','wpguppy-lite');?></label></th>
            <td>
                <fieldset>
                    <label><input type="radio" name="wpguppy_settings[whatsapp_support]" value="enable" <?php if( !empty($whatsapp_support) && $whatsapp_support == 'enable') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Enable','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[whatsapp_support]" value="disable" <?php if( !empty($whatsapp_support) && $whatsapp_support == 'disable') {?>checked="checked"<?php } ?>> 
                    <code><?php esc_html_e('Disable','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Delete message option','wpguppy-lite');?></label></th>
            <td>
                <fieldset>
                    <label><input type="radio" name="wpguppy_settings[delete_message]" value="enable" <?php if( !empty($delete_message) && $delete_message == 'enable') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Enable','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[delete_message]" value="disable" <?php if( !empty($delete_message) && $delete_message == 'disable') {?>checked="checked"<?php } ?>> 
                    <code><?php esc_html_e('Disable','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Clear chat option','wpguppy-lite');?></label></th>
            <td>
                <fieldset>
                    <label><input type="radio" name="wpguppy_settings[clear_chat]" value="enable" <?php if( !empty($clear_chat) && $clear_chat == 'enable') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Enable','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[clear_chat]" value="disable" <?php if( !empty($clear_chat) && $clear_chat == 'disable') {?>checked="checked"<?php } ?>> 
                    <code><?php esc_html_e('Disable','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="group"><?php esc_html_e('Hide account settings','wpguppy-lite');?></label></th>
            <td>
                <fieldset>
                    <label><input type="radio" name="wpguppy_settings[hide_acc_settings]" value="yes" <?php if( !empty($hide_acc_settings) && $hide_acc_settings == 'yes') {?>checked="checked"<?php } ?>>
                    <code><?php esc_html_e('Yes','wpguppy-lite');?></code></label>
                    <label><input type="radio" name="wpguppy_settings[hide_acc_settings]" value="no" <?php if( !empty($hide_acc_settings) && $hide_acc_settings == 'no') {?>checked="checked"<?php } ?>> 
                    <code><?php esc_html_e('no','wpguppy-lite');?></code></label>
                </fieldset>
            </td>
        </tr>
       
    </tbody>
</table>

<?php  ?> 