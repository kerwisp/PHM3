<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of class-out-authors-widget
 *
 * @author ab
 */
if ( !class_exists( 'Doctreat_Tweets' ) ) {

	class Doctreat_Tweets extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'doctreat_tweets', // Base ID
				esc_html__( 'Twitter Live Feed | Doctreat', 'doctreat_core' ), // Name
				array( 'classname' => 'dc-widgettwitter',
					'description' => esc_html__( 'Show latest tweets.', 'doctreat_core' ), ) // Args
			);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public
		function widget( $args, $instance ) {
			// outputs the content of the widget
			$counter = rand( 10, 99999 );
			extract( $instance );
			$username = isset( $username ) && !empty( $username ) ? $username : 'envato';
			$no_of_tweets = isset( $no_of_tweets ) && !empty( $no_of_tweets ) ? $no_of_tweets : 3;
			$title = isset( $instance[ 'title' ] ) && !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';

			$tweets = $this->prepare_tweets( $username, $no_of_tweets );

			echo( $args[ 'before_widget' ] );

			if ( !empty( $title ) ) {
				echo( $args[ 'before_title' ] . apply_filters( 'widget_title', esc_attr( $title ) ) . $args[ 'after_title' ] );
			}

			if ( isset( $tweets[ 'data' ] ) && !empty( $tweets[ 'data' ] ) ) {?>
				<div class="dc-footercontent">
					<ul class="dc-livefeeddetails">
						<?php echo force_balance_tags($tweets['data']); ?>
					</ul>
				</div>
				<?php } else {?>
					<div class="txt-box">
						<p><?php esc_html_e('Sorry! No tweets found','doctreat_core');?></p>
					</div>
				<?php } ?>
				<?php
				echo( $args[ 'after_widget' ] );
			}

			/**
			 * @get Tweets
			 *
			 */
			public function prepare_tweets( $username, $numoftweets ) {
				global $theme_settings;
				$protocol = is_ssl() ? 'https' : 'http';
				try {

					$username = html_entity_decode( $username );
					$json = array();

					if ( empty( $numoftweets ) ) {
						$numoftweets = 2;
					}

					if ( strlen( $username ) > 1 ) {

						$text = '';
						$return = '';

						$json[ 'data' ] = '';
						$json[ 'followers' ] = '';
						$cacheTime = 10000;
						$transName = 'latest-tweets';
						
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'libraries/twitter/twitteroauth.php';
						
						$consumerkey		= !empty( $theme_settings['consumer_key'] ) ? $theme_settings['consumer_key'] : ''; 
						$consumersecret		= !empty( $theme_settings['consumer_secret'] ) ? $theme_settings['consumer_secret'] : ''; 
						$accesstoken		= !empty( $theme_settings['access_token'] ) ? $theme_settings['access_token'] : ''; 
						$accesstokensecret	= !empty( $theme_settings['access_token_secret'] ) ? $theme_settings['access_token_secret'] : ''; 
						
						$connection = new TwitterOAuth( $consumerkey, $consumersecret, $accesstoken, $accesstokensecret );
						if ( empty( $consumerkey ) || empty( $consumersecret ) ) {
							return '';
						}
						
						$tweets = get_transient( 'latest-tweets' );
						if( empty($tweets) ){
							delete_transient( $transName );
							$tweets 	= $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?include_entities=true&tweet_mode=extended&screen_name=" . $username . "&count=" . $numoftweets );
							
							if ( !is_wp_error( $tweets )and is_array( $tweets ) ) {
								set_transient( $transName, $tweets, 60 * 60 * 24 );
							}
						}

						if ( !empty( $tweets ) ) {
							if ( !is_wp_error( $tweets )and is_array( $tweets ) ) {

								$rand_id = rand( 5, 300 );
								$exclude = 0;
								foreach ( $tweets as $tweet ) {
									$exclude++;                             
									$text = !empty( $tweet->full_text ) ? $tweet->full_text : '';
									$text = substr( $text, 0, 55 );
									foreach ( $tweet->user as $type => $userentity ) {
										if ( $type == 'profile_image_url' ) {
											$profile_image_url = $userentity;
										} else if ( $type == 'screen_name' ) {
											$screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="colrhover" title="' . $userentity . '">@' . $userentity . '</a>';
										}
									}

									foreach ( $tweet->entities as $type => $entity ) {
										if ( $type == 'hashtags' ) {
											foreach ( $entity as $j => $hashtag ) {
												$update_with_link = '<a href="https://twitter.com/search?q=%23' . $hashtag->text . '&amp;src=hash" target="_blank" title="' . $hashtag->text . '">#' . $hashtag->text . '</a>';
												$update_with = !empty( $hashtag->text ) ? $hashtag->text : '';
												$text = str_replace( '#' . $hashtag->text, $update_with, $text );
											}

										}
									}
									
									
									if (isset($tweet->entities->media)) {
										foreach ($tweet->entities->media as $media) {
											if(function_exists('doctreat_add_http_protcol')){
												$media_url = doctreat_add_http_protcol( $media->media_url );
											}
										}
									}

									$large_ts = time();
									$n = $large_ts - strtotime( $tweet->created_at );
									
									$posted	= human_time_diff( strtotime( $tweet->created_at ));
									
									

									$json[ 'data' ] .= '<li>';
									if( !empty( $media_url ) ){
										$json[ 'data' ] .= '<figure class="dc-latestadimg"><img width="50" height="50" src="'.$media_url.':thumb" alt="'.esc_html__('Tweets','doctreat_core').'"></figure>';
									}
									$json[ 'data' ] .= '<div class="dc-latestadcontent"><p>' . $text . '</p>';
									$json[ 'data' ] .= '<time datetime="' . date( 'Y-m-d', strtotime( $posted ) ) . '">' . date('H:i A - m D, Y',strtotime( $tweet->created_at)) . '</time>';
									$json[ 'data' ] .= '</div></li>';
								
								}
							}
							return $json;
						} else {
							if ( isset( $tweets->errors[ 0 ] ) && $tweets->errors[ 0 ] <> "" ) {
								return $json[ 'data' ] = '<li>' . $tweets->errors[ 0 ]->message . "</li>";
							} else {
								return $json[ 'data' ] = '<li>' . esc_html__( 'No Tweets Found', 'doctreat_core' ) . '</li>';
							}
						}
					} else {
						return $json[ 'data' ] = '<li>' . esc_html__( 'No Tweets Found', 'doctreat_core' ) . '</li>';
					}
				} catch ( Exception $ex ) {
					return $json[ 'data' ] = '<li>' . esc_html__( 'Some error occur, please try again later.', 'doctreat_core' ) . '</li>';
				}
			}

			/**
			 * Outputs the options form on admin
			 *
			 * @param array $instance The widget options
			 */
			public
			function form( $instance ) {
				// outputs the options form on admin
				$title = !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : esc_html__( 'Tweets', 'doctreat_core' );
				$username = !empty( $instance[ 'username' ] ) ? $instance[ 'username' ] : '';
				$no_of_tweets = !empty( $instance[ 'no_of_tweets' ] ) ? $instance[ 'no_of_tweets' ] : '';
				?>
				<p>
					<label for="<?php echo ( $this->get_field_id('title') ); ?>">
						<?php esc_html_e('Title:','doctreat_core'); ?>
					</label>
					<input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo(  $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
				</p>
				<p>
					<label for="<?php echo ( $this->get_field_id('username') ); ?>">
						<?php esc_html_e('Username:','doctreat_core'); ?>
					</label>
					<input class="widefat" id="<?php echo(  $this->get_field_id('username') ); ?>" name="<?php echo ( $this->get_field_name('username') ); ?>" type="text" value="<?php echo esc_attr($username); ?>">
				</p>
				<p>
					<label for="<?php echo ( $this->get_field_id('no_of_tweets') ); ?>">
						<?php esc_html_e('Number of Tweets:','doctreat_core'); ?>
					</label>
					<input class="widefat" id="<?php echo ( $this->get_field_id('no_of_tweets') ); ?>" name="<?php echo( $this->get_field_name('no_of_tweets') ); ?>" type="number" min="0" value="<?php echo esc_attr($no_of_tweets); ?>"/>
				</p>
				<?php
			}

			/**
			 * Processing widget options on save
			 *
			 * @param array $new_instance The new options
			 * @param array $old_instance The previous options
			 */
			public
			function update( $new_instance, $old_instance ) {
				// processes widget options to be saved
				$instance = $old_instance;
				$instance[ 'title' ] = ( !empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
				$instance[ 'username' ] = ( !empty( $new_instance[ 'username' ] ) ) ? strip_tags( $new_instance[ 'username' ] ) : '';
				$instance[ 'no_of_tweets' ] = ( !empty( $new_instance[ 'no_of_tweets' ] ) ) ? strip_tags( $new_instance[ 'no_of_tweets' ] ) : '6';
				return $instance;
			}

		}

}
//register widget
function doctreat_register_doctreat_tweets_widgets() {
	register_widget( 'Doctreat_Tweets' );
}
add_action( 'widgets_init', 'doctreat_register_doctreat_tweets_widgets' );