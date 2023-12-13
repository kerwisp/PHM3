(function( $ ) {
	"use strict";
	//copy the code
    jQuery('.gp-copy-code').on('click', function(){
        var copy_text   = jQuery(this).data('code');
        jQuery('#gp-shortcode-coppy').select();
    });

    jQuery('#gb-add-reson').on('click', function(){
        var newRowContent = '<tr><td></td><td><input name="wpguppy_settings[reporting_reasons][]" type="text"  value=""/><a href="javascript:;" class="gb-remove-reason"><span class="dashicons dashicons-trash"></span></a></td></tr>';
        jQuery("#gb-report-user tbody").append(newRowContent);
        wpguppy_remove_reason();
    });
	//change settings tab
    jQuery('.gp-tabs-settings').on('click', function(){
        let _this   = jQuery(this);
        let tab_id  = _this.data('tab_id');
        let url     = window.location.href; 
        let new_url = wpguppy_UpdateParam(url,'tab',tab_id);
        jQuery('.gp-tabs-settings').removeClass('nav-tab-active');
        _this.addClass('nav-tab-active');
        jQuery('.gb-tab-content').addClass('hide-if-js');
        jQuery('#tb-content-'+tab_id).removeClass('hide-if-js');
        window.history.replaceState({},document.title, new_url); 
    });

    jQuery('.at-chatroletabs_list a').on('click', function(e){
        e.preventDefault();
        let _this   = jQuery(this);
        let tab_id  = _this.data('tab_id');
        _this.parents('.at-chatroletabs_list').find('a').removeClass('nav-tab-active')
        _this.addClass('nav-tab-active');
        _this.parents('.at-chatroletabs').find('.gp-role-content').addClass('hide-if-js');
        _this.parents('.at-chatroletabs').find('#'+tab_id).removeClass('hide-if-js');
    });
	
	

    //WP is guppy admin change status
    jQuery('.wpguppy-is-admin').on('click','button[name=is_guppy_admin]', function(e){
        e.preventDefault();
        let _this       = jQuery(this);
        let _id                     = _this.data('id');
        let removeAdminText         = _this.data('removeadmintext');
        let admintext                    = _this.data('admintext');
        let _value                    = _this.val();
        var dataString = 'user_id='+_id+'&status='+_value+'&security='+scripts_constants.ajax_nonce+'&action=wpguppy_update_guppy_admin_status';
        jQuery.ajax({
            type: "POST",
            url: scripts_constants.ajaxurl,
            dataType:"json",
            data: dataString,
            success: function(response) {
                if (response.type === 'success') {
                    if(_value == 1){
                        _this.addClass('db-guppy-greenbg');
                        _this.text(admintext);
                        _this.val(0);
                    }else{
                        _this.removeClass('db-guppy-greenbg');
                        _this.text(removeAdminText);
                        _this.val(1);
                    }
                }
            }
        });
    });

    jQuery('.db-guppy-whatsappcheck').on('click','input[name=is_guppy_whatsapp_user_checked]', function(e){
        let _this       = jQuery(this);
        let _id         = _this.data('id');
        if (_this.is(":checked")){ 
            get_wpguppy_whatsapp_user_info(_id);
        }else{
            wpguppy_update_whatsapp_info(_id, 0, false);
        }
    });

    // get user information
    function get_wpguppy_whatsapp_user_info(_id){
        let dataString = 'user_id='+_id+'&security='+scripts_constants.ajax_nonce+'&action=get_wpguppy_whatsapp_user_info';
        jQuery.ajax({
            type: "GET",
            url: scripts_constants.ajaxurl,
            dataType:"json",
            data: dataString,
            success: function(response) {
                if (response.type === 'success') {
                    jQuery('.db-guppy-cus-modal .db-guppy-cus-modal-body').html(response.html);
                    jQuery('.db-guppy-cus-modal').show();
                    jQuery('body').addClass('db-guppy-cus-modal-open');
                }else{
                    StickyAlert('', response.message, {classList: 'important', autoclose: 3000});
                }
            }
        });
    }

    //update whatsapp user status
    jQuery('.db-guppy-whatsappcheck .guppy_whatsapp_user_edit').on('click', function(e){
        let _this       = jQuery(this);
        let _id         = _this.data('id');
        get_wpguppy_whatsapp_user_info(_id);
    });

    //hide whatsapp user popop
    jQuery('.db-guppy-cus-close-modal').on('click', function(e){
        jQuery('.db-guppy-cus-modal').hide();
        jQuery('body').removeClass('db-guppy-cus-modal-open');
    });
    //update whatsapp user info
    jQuery(document).on('click', '.update-guppy-whatsapp-info', function(e){ 
        e.preventDefault();
        let _this       = jQuery(this);
        let _id         = _this.data('id');
        let _form       = _this.parents('#guppy-whatsapp-info-form').serialize();
        wpguppy_update_whatsapp_info(_id, 1, _form);
    });

   
     jQuery(document).on('click', '#guppy-whatsapp-info-form input[type=checkbox]', function(e){ 
        let _this       = jQuery(this);
        let day =       _this.val();
        if (_this.is(":checked")){
            jQuery("#start_time_"+day).prop('disabled', false); 
            jQuery("#end_time_"+day).prop('disabled', false); 
        }else{
            jQuery("#start_time_"+day).prop('disabled', true);
            jQuery("#end_time_"+day).prop('disabled', true);
        }
    });

    function wpguppy_update_whatsapp_info(_id, _value, _form){
        let dataString = _form+'&user_id='+_id+'&status='+_value+'&security='+scripts_constants.ajax_nonce+'&action=wpguppy_update_whatsapp_info';
        jQuery.ajax({
            type: "POST",
            url: scripts_constants.ajaxurl,
            dataType:"json",
            data: dataString,
            success: function(response) {
                if (response.type === 'success') {
                    jQuery('.db-guppy-cus-modal').hide();
                    jQuery('body').removeClass('db-guppy-cus-modal-open');
                    if(_value == 1){
                        StickyAlert('', response.message, {classList: 'success', autoclose: 3000});
                    }
                }else{
                    StickyAlert('', response.message, {classList: 'important', autoclose: 3000});
                }
                if(_value == 1){
                    jQuery('.gp-whatsapp-icon'+_id).addClass('db-guppy-greenicon');
                }else{
                    jQuery('.gp-whatsapp-icon'+_id).removeClass('db-guppy-greenicon');
                }
            }
        });
    }
	
	//color picker
    jQuery('.gp-color-field').wpColorPicker();
	
	//pusher settings
    jQuery('.rt-chat-settings').on('change',function() {
        let rt_chat_val  = jQuery(this).val();
        
        if(rt_chat_val == 'pusher'){
            jQuery('.gp-socket-settings').prop('checked',false);
            jQuery('.rt-pusher').removeClass('hide-if-js');
            jQuery('.rt-socket, .gp-socket-options').addClass('hide-if-js');
        } else if(rt_chat_val == 'socket') {
            jQuery('.gp-pusher-settings').prop('checked',false);
            jQuery('.rt-pusher, .gp-pusher-options').addClass('hide-if-js');
            jQuery('.rt-socket').removeClass('hide-if-js');
        }
    });
    jQuery('.gp-pusher-settings').on('change',function() {
        let pusher_val  = jQuery(this).val();
        jQuery('.gp-socket-options, .rt-socket').addClass('hide-if-js');
        if(pusher_val == 'enable'){
            jQuery('.gp-pusher-options').removeClass('hide-if-js');
        } else {
            jQuery('.gp-pusher-options').addClass('hide-if-js');
        }
    });

    jQuery('.gp-socket-settings').on('change',function() {
        jQuery('.gp-pusher-options, .rt-pusher').addClass('hide-if-js');
        let socket_val  = jQuery(this).val();
        if(socket_val == 'enable'){
            jQuery('.gp-socket-options').removeClass('hide-if-js');
        } else {
            jQuery('.gp-socket-options').addClass('hide-if-js');
        }
    });
    jQuery('.guppy-search-filter').on('keyup',function() {
        let _this   = jQuery(this);
        let searchVal = _this.val().toUpperCase();
        let data = _this.parent('.at-roletabs_search').next('.at-roletabs_list').find('li .at-checkbox label');
        guppySearchFilter(searchVal, data)
    });
    
	
})( jQuery );

function guppySearchFilter(searchVal, data) {
    let i;
    for (i = 0; i < data.length; i++) {
      txtValue = data[i].textContent || data[i].innerText;
      if (txtValue.toUpperCase().indexOf(searchVal) > -1) {
        data[i].style.display = "";
      } else {
        data[i].style.display = "none";
      }
    }
}


function wpguppy_UpdateParam(currentUrl,key,val) {
    var url = new URL(currentUrl);
    url.searchParams.set(key, val);
    return url.href; 
}

// Alert the notification
function StickyAlert($title = '', $message = '', data) {
    var $icon = 'ti-face-sad';
    var $class = 'dark';

    if (data.classList === 'success') {
        $icon = 'icon-check';
        $class = 'green';
    } else if (data.classList === 'danger') {
        $icon = 'icon-x';
        $class = 'red';
    }

    jQuery.confirm({
        icon: $icon,
        closeIcon: true,
        theme: 'modern',
        animation: 'scale',
        type: $class, //red, green, dark, orange
        title: $title,
        content: $message,
        autoClose: 'close|' + data.autoclose,
        buttons: {
            close: {btnClass: 'tb-sticky-alert'}
        }
    });
}