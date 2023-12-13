<?php
/**
 *
 * Comments Page
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
if (post_password_required()) {
    return;
}
global $current_user;
$user_identity 	= $current_user->ID;
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {?>
	<p class="no-comments"><?php esc_html_e( 'Answers are closed.', 'doctreat' ); ?></p>
<?php } ?>

<?php if ( comments_open() ) { ?>

	<div class="dc-formtheme">
		<?php 
			doctreat_modify_comment_form_fields();	
			$comments_args = array(
				'must_log_in'			=> '',
				'logged_in_as'			=> '',
				'comment_field'			=> '<div class="form-group"><textarea name="comment" id="comment" cols="39" rows="5" tabindex="4" class="form-control" placeholder="'. esc_attr__("Type your answer", 'doctreat').'"></textarea></div>',

				'notes'                => '' ,
				'comment_notes_before' => '' ,
				'comment_notes_after'  => '' ,
				'id_form'              => 'dc-formtheme' ,
				'id_submit'            => 'dc-formtheme-btn' ,
				'class_form'           => 'dc-formtheme dc-formleavecomment' ,
				'class_submit'         => 'dc-btn' ,
				'name_submit'          => 'submit' ,
				'title_reply'          => esc_html__('Leave Your Answer' , 'doctreat') ,
				'title_reply_to'       => esc_html__('Leave a reply to %s' , 'doctreat') ,
				'title_reply_before'   => '<div class="card-title dc-cardtitle-form"><h4>' ,
				'title_reply_after'    => '</h4></div>' ,
				'cancel_reply_before'  => '' ,
				'cancel_reply_after'   => '' ,
				'cancel_reply_link'    => esc_html__('Cancel reply' , 'doctreat') ,
				'label_submit'         => esc_html__('Post Answer' , 'doctreat') ,
				'submit_button'        => '<div class="dc-btnarea"><button name="%1$s" type="submit" id="%2$s" class="dc-btn" value="%4$s"> '.esc_html__( 'Submit', 'doctreat' ).'</button></div>' ,
				'submit_field'         => ' %1$s %2$s ' ,
				'format'               => 'xhtml' ,
			);
			comment_form($comments_args);
		?>
	</div>

<?php }
