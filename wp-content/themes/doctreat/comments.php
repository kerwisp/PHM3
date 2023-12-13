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

if(is_singular('healthforum')) {
	get_template_part('healthforum-comments');
} else{
	if (have_comments()) { ?>
		<div id="dc-comments" class="dc-comments dc-users-review dc-heading dc-py-20">
			<h3><?php comments_number(esc_html__('0 Comments' , 'doctreat') , esc_html__('1 Comment' , 'doctreat') , esc_html__('% Comments' , 'doctreat')); ?></h3>
			<ul class="dc-author dc-mt-20"><?php wp_list_comments(array ('callback' => 'doctreat_comments' ));?></ul>
			<?php the_comments_navigation(); ?>
		</div>	
	<?php } ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {?>
		<div class="alert alert-primary alert-dismissible fade show"><?php esc_html_e( 'Comments are closed.', 'doctreat' ); ?></div>
	<?php } ?>

	<?php if ( comments_open() ) { ?>
		<div class="card-body dc-card-review">
			<div class="card-text">
			<?php 
				$comments_args = array(
					'must_log_in'			=> '<div class="form-group"><div class="must-log-in">' .  sprintf( esc_html__( "You must be %slogged in%s to post a comment.", 'doctreat' ), '<a href="'.esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ).'">', '</a>' ) . '</div></div>',

					'logged_in_as'			=> '<div class="form-group logged-in-wrap"><div class="logged-in-as">' . esc_html__( "Logged in as",'doctreat' ).' <a href="' .esc_url( admin_url( "profile.php" ) ).'">'.$user_identity.'</a>. <a href="' .esc_url( wp_logout_url(get_permalink()) ).'" title="' . esc_attr__("Log out of this account", 'doctreat').'">'. esc_html__("Log out &raquo;", 'doctreat').'</a></div></div>',

					'comment_field'			=> '<div class="form-group"><textarea name="comment" id="comment" cols="39" rows="5" tabindex="4" class="form-control" placeholder="'. esc_attr__("Type your comment", 'doctreat').'"></textarea></div>',

					'notes'                => '' ,
					'comment_notes_before' => '' ,
					'comment_notes_after'  => '' ,
					'id_form'              => 'dc-formtheme' ,
					'id_submit'            => 'dc-formtheme-btn' ,
					'class_form'           => 'dc-formtheme dc-formleavecomment' ,
					'class_submit'         => 'dc-btn' ,
					'name_submit'          => 'submit' ,
					'title_reply'          => esc_html__('Leave Your Comment' , 'doctreat') ,
					'title_reply_to'       => esc_html__('Leave a reply to %s' , 'doctreat') ,
					'title_reply_before'   => '<div class="card-title dc-cardtitle-form"><h4>' ,
					'title_reply_after'    => '</h4></div>' ,
					'cancel_reply_before'  => '' ,
					'cancel_reply_after'   => '' ,
					'cancel_reply_link'    => esc_html__('Cancel reply' , 'doctreat') ,
					'label_submit'         => esc_html__('Post Comment' , 'doctreat') ,
					'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="dc-btn" value="%4$s"> '.esc_html__( 'Submit', 'doctreat' ).'</button>' ,
					'submit_field'         => ' %1$s %2$s ' ,
					'format'               => 'xhtml' ,
				);
				comment_form($comments_args);
				?>
			</div>
		</div>
	<?php }
}