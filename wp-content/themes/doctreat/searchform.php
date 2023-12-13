<?php
/**
 *
 * Theme Search form
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
?>
<form class="dc-formtheme dc-formsearch" method="get" role="search" action="<?php echo esc_url(home_url('/')); ?>">
	<fieldset>
		<div class="form-group">
			<input type="search" name="s" value="<?php echo get_search_query(); ?>" class="form-control" placeholder="<?php esc_attr_e('Searching might help', 'doctreat') ?>">
			<?php if( is_404() ) {?>
				<div class="dc-btnarea">
					<button type="submit" class="dc-btn"><?php esc_html_e('Search','doctreat');?></button>
					<span><?php esc_html_e('You can go back to','doctreat');?>&nbsp;<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home','doctreat');?></a>&nbsp;<?php esc_html_e('and start again','doctreat');?></span>
				</div>
			<?php } else { ?>
				<button type="submit" class="dc-searchgbtn"><i class="fa fa-search"></i></button>
			<?php } ?>
		</div>
	</fieldset>
</form>


