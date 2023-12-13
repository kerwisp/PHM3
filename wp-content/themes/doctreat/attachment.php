<?php
/**
 *
 * Attachment Page
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
get_header();
?>
<div class="blog-detail">
    <div class="post">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="post-text attachment-text">
                            <h1><?php the_title(); ?></h1>
                            <h5>
                            <?php echo get_the_author_meta('nickname'); ?>&nbsp;|&nbsp;
                            <?php echo get_the_date('d.m.y'); ?>&nbsp;|&nbsp;				                            
                            <?php doctreat_entry_footer(); ?>&nbsp;|&nbsp;
                            <?php echo sprintf( _n( '%s Comment', '%s Comments', get_comments_number(), 'doctreat' ), get_comments_number() );?>
                            </h5>
                            <?php echo wp_get_attachment_image(get_the_ID() , array (
                                1140 ,
                                289 )); ?>
                        <?php 
							the_content();
							wp_link_pages( array(
									'before'      => '<div class="dc-paginationvtwo"><nav class="dc-pagination"><ul>',
									'after'       => '</ul></nav></div>',
								) );
							edit_post_link( esc_html__( 'Edit', 'doctreat' ), '<span class="edit-link">', '</span>' );
						 ?>
                        </div>
            <?php endwhile; ?>
                </div>
            </div>
            <?php
            // If comments are open or we have at least one comment, load up the comment template
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>