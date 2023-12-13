<?php
/**
 * Email Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'Email Settings', 'doctreat_core' ),
	'id' => 'email_settings',
	'desc' => '',
	'icon' => 'el el-inbox',
	'subsection' => false,
	'fields' => array(
		array(
			'id' => 'divider_1',
			'type' => 'info',
			'title' => esc_html__( 'General Settings', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'email_logo',
			'type' => 'media',
			'compiler' => 'true',
			'url' => true,
			'title' => esc_html__( 'Email Logo', 'doctreat_core' ),
			'desc' => esc_html__( 'Upload your email logo here.', 'doctreat_core' ),
		),
		array(
			'id' 		=> 'email_logo_width',
			'type' 		=> 'slider',
			'title' 	=> esc_html__('Set logo width', 'doctreat_core'),
			'desc' 		=> esc_html__('Leave it empty to use default', 'doctreat_core'),
			"default" 	=> 100,
			"min" 		=> 0,
			"step" 		=> 1,
			"max" 		=> 500,
			'display_value' => 'label',
		),
		array(
			'id' => 'email_banner',
			'type' => 'media',
			'compiler' => 'true',
			'title' => esc_html__( 'Email Banner', 'doctreat_core' ),
			'desc' => esc_html__( 'Upload your email banner here.', 'doctreat_core' ),
		),
		array(
			'id' => 'email_sender_avatar',
			'type' => 'media',
			'compiler' => 'true',
			'title' => esc_html__( 'Email Sender Avatar', 'doctreat_core' ),
			'desc' => esc_html__( 'Upload email sender picture here.', 'doctreat_core' ),
		),
		array(
			'id' => 'email_copyrights',
			'type' => 'textarea',
			'title' => esc_html__( 'Footer copyright text', 'doctreat_core' ),
			'desc' => esc_html__( 'Add copyright text for the emails in footer', 'doctreat_core' ),
		),
		array(
			'id' => 'email_sender_name',
			'type' => 'text',
			'title' => esc_html__( 'Email Sender Name', 'doctreat_core' ),
			'desc' => esc_html__( 'Add email sender name here like: Shawn Biyeam. Default your site name will be used.', 'doctreat_core' ),
			'default' => 'Amentotech.Pvt.ltd',
		),
		array(
			'id' => 'email_sender_tagline',
			'type' => 'text',
			'title' => esc_html__( 'Email Sender Tagline', 'doctreat_core' ),
			'desc' => esc_html__( 'Add email sender tagline here like: Team Doctreat. Default your site tagline will be used.', 'doctreat_core' ),
			'default' => esc_html__( 'Your software partner', 'doctreat_core' ),
		),
		array(
			'id' => 'email_sender_url',
			'type' => 'text',
			'title' => esc_html__( 'Email Sender URL', 'doctreat_core' ),
			'desc' => esc_html__( 'Add email sender url here.', 'doctreat_core' ),
			'default' => 'amentotech.com',
		),
		array(
			'id' => 'footer_bg_color',
			'type' => 'color',
			'default' => '#3d4461',
			'title' => esc_html__( 'Footer background color', 'doctreat_core' ),
			'desc' => esc_html__( 'Add email footer background color', 'doctreat_core' )
		),
		array(
			'id' => 'footer_text_color',
			'type' => 'color',
			'default' => '#FFF',
			'title' => esc_html__( 'Footer text color', 'doctreat_core' ),
			'desc' => esc_html__( 'Add email footer text color', 'doctreat_core' )
		),
	)
) );

Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'General Templates', 'doctreat_core' ),
	'id' => 'general_templates',
	'desc' => esc_html__( 'Registration templates', 'doctreat_core' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'divider_general_app_link_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email to send app url', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'subject_app_link',
			'type' => 'text',
			'default' => esc_html__( 'Application link', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_app_link_information',
			'desc' => wp_kses( __( '%email% — To display the user email address.<br>
%site% — To display the site name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'app_link_content',
			'type' => 'editor',
			'default' => 'Hello
						You can download our APP from below link
						<a href="#">Download</a>
						%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for doctor registration', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'doctor_registration_subject',
			'type' => 'text',
			'default' => esc_html__( 'Thank you for registeration!', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_information',
			'desc' => wp_kses( __( '%name% — To display the doctor name.<br>
%email% — To display the doctor email address.<br>
%password% — To display the password for login.<br>
%verification_link% — To display verification link.<br>
%site% — To display the site name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'doctor_registration_content',
			'type' => 'editor',
			'default' => 'Hello %name%!
							Thanks for registeration on our %site%. You can now verify your account by clicking below link
							%verification_link%
							%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_hospitals_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for hospitals registration', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'hospital_registration_subject',
			'type' => 'text',
			'default' => esc_html__( 'Thank you for registeration!', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_hospital_information',
			'desc' => wp_kses( __( '%name% — To display the hospital name.<br>
%email% — To display the hospital email address.<br>
%password% — To display the password for login.<br>
%verification_link% — To display verification link.<br>
%site% — To display the site name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'hospital_registration_content',
			'type' => 'editor',
			'default' => 'Hello %name%!
							Thanks for registeration on our %site%. You can now login to manage your account using the below details credentials:
							Email: %email%
							Password: %password%
							%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_regular_user_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for Patients', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'regular_registration_subject',
			'type' => 'text',
			'default' => esc_html__( 'Thank you for registeration!', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_regular_registration_information',
			'desc' => wp_kses( __( '%name% — To display the hospital name.<br>
%email% — To display the hospital email address.<br>
%password% — To display the password for login.<br>
%verification_link% — To display verification link.<br>
%site% — To display the site name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'regular_registration_content',
			'type' => 'editor',
			'default' => 'Hello %name%!
							Thanks for registeration on our %site%. You can now login to manage your account using the below details credentials:
							Email: %email%
							Password: %password%
							%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_seller_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for seller/vendor/pharmacy', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'seller_subject',
			'type' => 'text',
			'default' => esc_html__( 'Thank you for registeration!', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_seller_information',
			'desc' => wp_kses( __( '%name% — To display the hospital name.<br>
								%email% — To display the hospital email address.<br>
								%password% — To display the password for login.<br>
								%verification_link% — To display verification link.<br>
								%site% — To display the site name.<br>
								%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'seller_content',
			'type' => 'editor',
			'default' => 'Hello %name%!
							Thank you for the registeration on our %site%. You can now login to manage your account using the below details credentials:
							Email: %email%
							Password: %password%
							%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		//start new
		array(
			'id' => 'divider_change_password_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for user to change password', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'change_password_subject',
			'type' => 'text',
			'default' => esc_html__( 'Reset password', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_change_password_information',
			'desc' => wp_kses( __( '%name% — To display the doctor name.<br>
			%email% — To display the user email address.<br>
			%link% — To display link for change password.<br>
			%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'change_password_content',
			'type' => 'editor',
			'default' => wp_kses( __( 'Hi %name%,<br/>
			Someone requested to reset the password of following account:<br/><br/>
			Email Address: %email%<br>
			If this was a mistake, just ignore this email and nothing will happen.

			To reset your password, click reset link below:<br/>
			<a href="%link%">Reset</a>

			%signature%', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),

		array(
			'id' => 'divider_remove_account_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template to delete account', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'remove_account_email',
			'type' => 'text',
			'default' => esc_html__( 'Remove account', 'doctreat_core' ),
			'title' => esc_html__( 'Remove account email', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add email address to receive notice.', 'doctreat_core' )
		),
		array(
			'id' => 'remove_account_subject',
			'type' => 'text',
			'default' => 'Account has been deleted!',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_remove_account_information',
			'desc' => wp_kses( __( '%name% — To display the user name.<br>
%message% — To display content or message.<br>
%reason% — To display link reopen account.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'remove_account_content',
			'type' => 'editor',
			'default' => 'Hi,
							An existing user has deleted the account due to the following reason: 
							
							%reason%
							
							%signature%,',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
	
		array(
			'id' 	=> 'divider_resend_templates',
			'type' 	=> 'info',
			'title' => esc_html__( 'Resend verification email', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'resend_subject',
			'type' => 'text',
			'default' => 'Email Verification Link',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_resend_information',
			'desc' => wp_kses( __( '%name% — To display the doctor name.<br>
%email% — To display the doctor email address.<br>
%password% — To display the password for login.<br>
%verification_link% — To display verification link.<br>
%site% — To display the site name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'resend_content',
			'type' => 'editor',
			'default' => 'Hello %name%!<br/>
						Your account has created on %site%. Verification is required, To verify your account please use below link:<br> 
						Verification Link: %verification_link%<br/>

						%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		
		
		array(
			'id' 	=> 'divider_chat_notify',
			'type' 	=> 'info',
			'title' => esc_html__( 'Chat message email', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id'       => 'chat_notify_enable',
			'type'     => 'select',
			'title'    => esc_html__('Chat notification', 'doctreat_core'), 
			'desc' =>  __( 'Enable/Disable receiver chat notifications. If enabled message email will be sent to the receiver.', 'doctreat_core' ),
			'options'  => array(
				'yes' 	=> esc_html__('Yes', 'doctreat_core'),
				'no' 	=> esc_html__('No', 'doctreat_core') 
			),
			'default'  => 'no',
		),
		array(
			'id' => 'chat_notify_subject',
			'type' => 'text',
			'default' => 'A new message received',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_chat_notify_information',
			'desc' => wp_kses( __( '%username% — To display message receiver name.
%sender_name% — To display sender name.
%message% — To display message.
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'chat_notify_content',
			'type' => 'editor',
			'default' => 'Hi %username%!
You have received a new message from %sender_name%, below is the message
%message%

%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
	
		array(
			'id' 	=> 'divider_approve_account',
			'type' 	=> 'info',
			'title' => esc_html__( 'Account approved', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'approve_account_subject',
			'type' => 'text',
			'default' => 'Your account has been approved',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_approve_account_information',
			'desc' => wp_kses( __( '%username% — To display message receiver name.
%sender_name% — To display sender name.
%message% — To display message.
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'approve_account_content',
			'type' => 'editor',
			'default' => 'Hello %name%
Your account has been approved. You can now login to setup your profile.

<a href="%site_url%">Login Now</a>

%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'Admin Templates', 'doctreat_core' ),
	'id' => 'admin_templates',
	'desc' => esc_html__( 'Admin Templates', 'doctreat_core' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'admin_email',
			'type' => 'text',
			'default' => 'info@yourdomain.com',
			'title' => esc_html__( 'Admin email address', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add admin email address, leave it empty to get email address from WordPress Settings.', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_admin_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for new user to admin', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'admin_register_subject',
			'type' => 'text',
			'default' => esc_html__( 'New registration', 'doctreat_core' ),
			'title' => esc_html__( 'Admin new user subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add new user subject.', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_admin_new_user_information',
			'desc' => wp_kses( __( '%name% — To display new registered  user name.<br>
%email% — To display the email address of registered user.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'admin_register_content',
			'type' => 'editor',
			'default' => 'Hello!
						A new user "%name%" with email address "%email%" has been registered on your website.
						Please login to check user detail.
						%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_subscription_admin_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for subscription', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'admin_subscription_subject',
			'type' => 'text',
			'default' => esc_html__( 'Thank you for purchasing the package!', 'doctreat_core' ),
			'title' => esc_html__( 'Admin subscription subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add new user subject.', 'doctreat_core' )
		),
		array(
			'id' => 'divider_subscription_admin_information',
			'desc' => wp_kses( __( '%doctor_name% - To display Doctor name.<br>
			%invoice% - To display Doctor Invoice.<br>
			%package_name% - To display Package Name.<br>
			%amount% - To display Price<br>
			%status% - To display Payment status<br>
			%method% - To display Payment Method.<br>
			%date% - To display Purchase Date.<br>
			%expiry% - To display Expiry Date.<br>
			%signature% - To display site logo.
			', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'admin_subscription_content',
			'title' => esc_html__( 'subscription content', 'doctreat_core' ),
			'type' => 'editor',
			'default' => 'Hello admin,<br>
							A doctor with the name "%doctor_name%" has purchased a package. Detail of order is given below:
							Invoice ID: %invoice%
							Package Name: %package_name%
							Payment Amount: %amount%
							Payment status: %status%
							Payment Method: %method%
							Purchase Date: %date%
							Expiry Date: %expiry%

							%signature%,',
		),
		array(
			'id' => 'divider_admin_article_pending_templates',
			'type' => 'info',
			'title' => esc_html__( 'Article Email template with pending status', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'admin_article_pending_subject',
			'type' => 'text',
			'default' => esc_html__( 'Article needs approval', 'doctreat_core' ),
			'title' => esc_html__( 'Article pending subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add new user subject.', 'doctreat_core' )
		),
		array(
			'id' => 'admin_article_pending_information',
			'desc' => wp_kses( __( '%doctor_name% — To display Doctor name.<br>
			%article_title% - To display Article title.<br>
			%signature% - To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'admin_article_pending_content',
			'type' => 'editor',
			'title' => esc_html__( 'Article content', 'doctreat_core' ),
			'default' => 'Hello admin,
							A new article "%article_title%" has been submitted by a doctor %doctor_name%, it required your approval to make it publish.
							%signature%,',
		),
		//forum email
		array(
			'id' => 'divider_forum_email',
			'type' => 'info',
			'title' => esc_html__( 'Question posted', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'question_posted_admin',
			'type' => 'text',
			'title' => esc_html__( 'Admin email', 'doctreat_core' ),
			'default' => esc_html__( 'info@example.com', 'doctreat_core' ),
			'desc' => esc_html__( 'Add admin email address, leave it empty to use from WordPress', 'doctreat_core' )
		),
		array(
			'id' => 'question_posted',
			'type' => 'text',
			'default' => esc_html__( 'A new question has been posted', 'doctreat_core' ),
			'title' => esc_html__( 'Question posted title', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add a subject for the new question email', 'doctreat_core' )
		),
		array(
			'id' => 'question_posted_content_variables',
			'desc' => wp_kses( __( '%question% — To display question name.<br>
			%category% - To display category.<br>
			%description% - To display description.<br>
			%name% - To display username.<br>
			%signature% - To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'question_posted_content',
			'type' => 'editor',
			'title' => esc_html__( 'Question email content', 'doctreat_core' ),
			'default' => wp_kses( __( 'Hello admin,
						A new question has been posted has been posted<br>
						
						Question title: %question%<br>
						Username: %name%<br>
						Category: %category%<br>
						Question description: %description%<br>
						
						%signature%', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'Hospital Team Templates', 'doctreat_core' ),
	'id' => 'hospital_team_templates',
	'desc' => esc_html__( 'Hospital Team Templates', 'doctreat_core' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'divider_hospital_team_templates',
			'type' => 'info',
			'title' => esc_html__( 'Request to hospital to join as a team', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'doctor_hospital_request_subject',
			'type' => 'text',
			'default' => esc_html__( 'New request for team has been received', 'doctreat_core' ),
			'title' => esc_html__( 'Hospital request subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Hospital request to join team subject.', 'doctreat_core' )
		),
		array(
			'id' => 'divider_general_hospital_team_templates',
			'desc' => wp_kses( __( '%hospital_name% — To display the hospital name.<br>
%doctor_link% — To display the doctor profile link.<br>
%doctor_name% — To display the doctor name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'doctor_hospital_request_content',
			'type' => 'editor',
			'default' => 'Hello %hospital_name%,
			<a href="%doctor_link%">%doctor_name%</a> has sent you a new request to join your hospital.
			%signature%,',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_hospital_request_approved_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template to approved request to join a hospital', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'hospital_request_approved_subject',
			'type' => 'text',
			'default' => esc_html__( 'Hospital team request has been accepted!', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_hospital_request_approved_information',
			'desc' => wp_kses( __( '%doctor_name% — To display the doctor name.<br>
%hospital_link% — To display hospital profile link.<br>
%hospital_name% — To display hospital name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'hospital_request_approved_content',
			'type' => 'editor',
			'default' => 'Hello %doctor_name%,
						Your request to join <a href="%hospital_link%">%hospital_name%</a> has been <b>approved</b>.
						%signature%,',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_hospital_request_cancelled_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for Cancelled request to join hospital', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'hospital_request_cancelled_subject',
			'type' => 'text',
			'default' => esc_html__( 'Request has been cancelled to join hospital', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_hospital_request_cancelled_information',
			'desc' => wp_kses( __( '%doctor_name% — To display the doctor name.<br>
%hospital_link% — To display hospital profile link.<br>
%hospital_name% — To display hospital name.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'hospital_request_cancelled_content',
			'type' => 'editor',
			'default' => 'Hello %doctor_name%,
							Your request to join the <a href="%hospital_link%">%hospital_name%</a> has been <b>cancelled</b>.
							%signature%,',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		)
	)

) );

Redux::setSection( $opt_name, array(
	'title' => 'Booking Templates',
	'id' => 'hospital_booking_templates',
	'desc' => esc_html__( 'Booking Templates', 'doctreat_core' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'divider_booking_verification_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email verification code for booking', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'booking_verify_subject',
			'type' => 'text',
			'default' => 'verification code for booking',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_booking_verification_information',
			'desc' => wp_kses( __( '%name% — To display the user name.<br>
				%email% — To display the user email address.<br>
				%verification_code% — To display the verification code.<br>
				%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'booking_verify_content',
			'type' => 'editor',
			'default' => 'Hello %name%
							To complete your booking please add the below authentication code.
							Your verification code is : %verification_code%
							%signature%',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_booking_request_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email to user for receiving appointment booking request.', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'booking_request_subject',
			'type' => 'text',
			'default' => 'Appointment confirmation',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_booking_request_information',
			'desc' => wp_kses( __( '%user_name% — To display the user name.<br>
				%doctor_name% — To display the Doctor name.<br>
				%doctor_link% — To display the Doctor profile url.<br>
				%hospital_name% — To display the Hospital name.<br>
				%hospital_link% — To display the Hospital profile url.<br>
				%appointment_date% — To display the Appointment date.<br>
				%appointment_time% — To display the Appointment time.<br>
				%price% — To display the Booking total price.<br>
				%consultant_fee% — To display the consultation fee.<br>
				%description% — To display the booking description.<br>
				%email% — To display the User email.<br>
				%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'booking_request_content',
			'type' => 'editor',
			'default' => wp_kses( __( 'Hello %user_name%<br/>

			Your appointment booking request has been scheduled with the following details<br/>
			Appointment date 	: %appointment_date% <br>
			Appointment time 	: %appointment_time% <br>
			Doctor name 		: %doctor_name% <br>
			Hospital name 		: %hospital_name% <br>
			consultation fee 	: %consultant_fee% <br>
			Price 				: %price% <br>
			Description 		: %description% <br>
			%signature%,<br/>,', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		array(
			'id' => 'divider_doctor_booking_request_templates',
			'type' => 'info',
			'title' => esc_html__( 'Doctors receive appointment', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'doctor_booking_request_subject',
			'type' => 'text',
			'default' => 'New appointment received!',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_doctor_booking_request_information',
			'desc' => wp_kses( __( '%user_name% — To display the user name.<br>
%doctor_name% — To display the Doctor name.<br>
%doctor_link% — To display the Doctor profile url.<br>
%hospital_name% — To display the Hospital name.<br>
%hospital_link% — To display the Hospital profile url.<br>
%appointment_date% — To display the Appointment date.<br>
%appointment_time% — To display the Appointment time.<br>
%price% — To display the Booking total price.<br>
%consultant_fee% — To display the consultation fee.<br>
%description% — To display the booking description.<br>
%email% — To display the User email.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'doctor_booking_request_content',
			'type' => 'editor',
			'default' => 'Hello %doctor_name%
							%user_name% is request you for appointment in hospital %hospital_link% on %appointment_date% at %appointment_time%
							%signature%,',
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),

		// add approved/cancelled email
		array(
			'id' => 'divider_booking_approved_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email Patient when booking is approved', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'approved_booking_request_subject',
			'type' => 'text',
			'default' => esc_html__( 'Approved appoinment', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_approved_booking_information',
			'desc' => wp_kses( __( '%user_name% — To display the user name.<br>
%doctor_name% — To display the Doctor name.<br>
%doctor_link% — To display the Doctor profile link.<br>
%hospital_name% — To display the hospital name.<br>
%hospital_link% — To display the hospital profile link.<br>
%appointment_time% — To display the appointment time.<br>
%appointment_date% — To display the appointment date.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'approved_booking_request_content',
			'type' => 'editor',
			'default' => wp_kses( __( 'Hello %user_name%<br/>
							%doctor_name% is approved to your appoinment on date  %appointment_date% at %appointment_time% <br/>
							%signature%,<br/>', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),

		array(
			'id' => 'divider_booking_approved_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email Patient when booking is approved', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'approved_booking_request_subject',
			'type' => 'text',
			'default' => esc_html__( 'Approved appoinment', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_approved_booking_information',
			'desc' => wp_kses( __( '%user_name% — To display the user name.<br>
%doctor_name% — To display the Doctor name.<br>
%doctor_link% — To display the Doctor profile link.<br>
%hospital_name% — To display the hospital name.<br>
%hospital_link% — To display the hospital profile link.<br>
%appointment_time% — To display the appointment time.<br>
%appointment_date% — To display the appointment date.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'approved_booking_request_content',
			'type' => 'editor',
			'default' => wp_kses( __( 'Hello %user_name%<br/>
							%doctor_name% is approved your appoinment on date  %appointment_date% at %appointment_time% <br/>
							%signature%,<br/>', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),

		array(
			'id' => 'divider_booking_cancelled_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email Patient when booking is cancelled', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'cancelled_booking_request_subject',
			'type' => 'text',
			'default' => esc_html__( 'cancelled appoinment', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_cancelled_booking_information',
			'desc' => wp_kses( __( '%user_name% — To display the user name.<br>
%doctor_name% — To display the Doctor name.<br>
%doctor_link% — To display the Doctor profile link.<br>
%hospital_name% — To display the hospital name.<br>
%hospital_link% — To display the hospital profile link.<br>
%appointment_time% — To display the appointment time.<br>
%appointment_date% — To display the appointment date.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'cancelled_booking_request_content',
			'type' => 'editor',
			'default' => wp_kses( __( 'Hello %user_name%<br/>
							%doctor_name% is cancelled your appoinment on date  %appointment_date% at %appointment_time% <br/>
							%signature%,<br/>', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		),
		// end approved email
		array(
			'id' => 'divider_feedback_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email to doctor after feedback from user.', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'feedback_subject',
			'type' => 'text',
			'default' => 'Feedback received',
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add subject for email', 'doctreat_core' )
		),
		array(
			'id' => 'divider_feedback_information',
			'desc' => wp_kses( __( '%user_name% — To display the user name.<br>
%doctor_name% — To display the Doctor name.<br>
%rating% 	— To display ratings.<br>
%recommend% 	— To display user recommend or not.<br>
%waiting_time% — To display the waiting time.<br>
%description% — To display the feedback description.<br>
%signature% — To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'feedback_content',
			'type' => 'editor',
			'default' => wp_kses( __( 'Hello %doctor_name%<br>
							%user_name% has given the feedback with the following details :<br>
							Recommend 			: %recommend% <br>
							Waiting time 		: %waiting_time% <br>
							Rating				: %rating% <br>
							Description 		: %description% <br>
							%signature%,<br/>
							%signature%,', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email Contents', 'doctreat_core' )
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'Subscription Templates', 'doctreat_core' ),
	'id' => 'subscription_templates',
	'desc' => esc_html__( 'Subscription Templates', 'doctreat_core' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'divider_subscription_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for subscription', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'subscription_subject',
			'type' => 'text',
			'default' => esc_html__( 'Thank you for purchasing the package!', 'doctreat_core' ),
			'title' => esc_html__( 'subscription subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add new user subject.', 'doctreat_core' )
		),
		array(
			'id' => 'divider_subscription_information',
			'desc' => wp_kses( __( '%doctor_name% — To display Doctor name.<br>
%invoice% - To display Doctor Invoice.<br>
%package_name% - To display Package Name.<br>
%amount% - To display Price<br>
%status% - To display Payment status<br>
%method% - To display Payment Method.<br>
%date% - To display Purchase Date.<br>
%expiry% - To display Expiry Date.<br>
%signature% - To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'subscription_content',
			'type' => 'editor',
			'title' => esc_html__( 'subscription content', 'doctreat_core' ),
			'default' => 'Hello %doctor_name%<br>
							Thanks for purchasing the package. Your payment has been received and your invoice detail is given below:
							Invoice ID: %invoice%
							Package Name: %package_name%
							Payment Amount: %amount%
							Payment status: %status%
							Payment Method: %method%
							Purchase Date: %date%
							Expiry Date: %expiry%

							%signature%,',
		)
	)
) );

Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'Invitation Templates', 'doctreat_core' ),
	'id' => 'invitation_templates',
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'divider_hospitals_invitation_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template to invite hospitals', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'invite_hospitals_subject',
			'type' => 'text',
			'default' => esc_html__( 'Invitation to signup ', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Add subject for hospital invitation email.', 'doctreat_core' )
		),
		array(
			'id' => 'divider_hospitals_inviation_information',
			'desc' => wp_kses( __( '%doctor_name% — To display Doctor name.<br>
						%doctor_email% - To display Doctor email.<br>
						%doctor_profile_url% - To display Doctor profile link.<br>
						%invited_hospital_email% - To display invited hospital email.<br>
						%invitation_content% - To display content by doctor.<br>
						%invitation_link% - To display invitation link.<br>
						%signature% - To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'invite_hospitalss_content',
			'type' => 'editor',
			'title' => esc_html__( 'Content', 'doctreat_core' ),
			'default' => 'Hello,<br>
			You have an invitation from %doctor_name% to register on the site. He wants to list yourself in your hospital onboard doctors.<br>
			Create your profile and get listed on the site. He have leave a message for you<br>
			%invitation_content% <br>
			%invitation_link% <br>
			%signature%',
		),
		array(
			'id' => 'divider_doctors_invitation_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template to invite doctors', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'invite_doctors_subject',
			'type' => 'text',
			'default' => esc_html__( 'Invitation to signup ', 'doctreat_core' ),
			'title' => esc_html__( 'Subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Add subject for doctors invitation email.', 'doctreat_core' )
		),
		array(
			'id' => 'divider_docors_inviation_information',
			'desc' => wp_kses( __( '%hospital_name% — To display hospital name.<br>
						%hospital_email% - To display hospital email.<br>
						%hospital_profile_url% - To display hospital profile link.<br>
						%invited_docor_email% - To display invited docor email.<br>
						%invitation_content% - To display content by doctor.<br>
						%invitation_link% - To display invitation link.<br>
						%signature% - To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'invite_doctors_content',
			'type' => 'editor',
			'title' => esc_html__( 'Content', 'doctreat_core' ),
			'default' => 'Hello,<br>
			You have an invitation from %hospital_name% to register on the site. They wants to list you as their onboard doctors<br>
			Create your profile and get listed on the site. They have leave a message for you<br>
			%invitation_content% <br>
			%invitation_link% <br>
			%signature%
			',
		)
	),
) );

Redux::setSection( $opt_name, array(
	'title' => esc_html__( 'Article Templates', 'doctreat_core' ),
	'id' => 'article_templates',
	'desc' => esc_html__( 'Article Templates', 'doctreat_core' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id' => 'divider_article_pending_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template for pending article', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'article_pending_subject',
			'type' => 'text',
			'default' => esc_html__( 'Your submitted needs approval', 'doctreat_core' ),
			'title' => esc_html__( 'Article pending subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add new user subject.', 'doctreat_core' )
		),
		array(
			'id' => 'article_pending_information',
			'desc' => wp_kses( __( '%doctor_name% — To display Doctor name.<br>
%article_title% - To display Article title.<br>
%signature% - To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'article_pending_content',
			'type' => 'editor',
			'title' => esc_html__( 'Article content', 'doctreat_core' ),
			'default' => 'Hello %doctor_name%<br>
			Your article %article_title% has been received, Your article will be published after the review
			%signature%,',
		),
		array(
			'id' => 'divider_article_publish_templates',
			'type' => 'info',
			'title' => esc_html__( 'Email template with publish status', 'doctreat_core' ),
			'style' => 'info',
		),
		array(
			'id' => 'article_publish_subject',
			'type' => 'text',
			'default' => esc_html__( 'Your article has been published', 'doctreat_core' ),
			'title' => esc_html__( 'Article publish subject', 'doctreat_core' ),
			'desc' => esc_html__( 'Please add new user subject.', 'doctreat_core' )
		),
		array(
			'id' => 'article_publish_information',
			'desc' => wp_kses( __( '%doctor_name% — To display Doctor name.<br>
%article_title% - To display Article title.<br>
%signature% - To display site logo.', 'doctreat_core' ), array(
				'a' => array(
					'href' => array(),
					'title' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
			) ),
			'title' => esc_html__( 'Email setting variables', 'doctreat_core' ),
			'type' => 'info',
			'class' => 'dc-center-content',
			'icon' => 'el el-info-circle'
		),
		array(
			'id' => 'article_publish_content',
			'type' => 'editor',
			'title' => esc_html__( 'Article content', 'doctreat_core' ),
			'default' => 'Hello %doctor_name%<br>
							Your article %article_title% has been published.
							%signature%,'
		)
	)
) );