<?php
/**
 * The get twitters tweets widgets functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Doctreat
 * @subpackage Doctreat/admin
 */

if ( !class_exists( 'Doctreat_links' ) ) {

	class Doctreat_links extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'doctreat_links', // Base ID
				esc_html__( 'Twitter Live Feed | Doctreat', 'doctreat_core' ), // Name
				array( 'classname' => 'dc-widgettwitter',
					'description' => esc_html__( 'Show twittes.', 'doctreat_core' ), ) // Args
			);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			// outputs the content of the widget
			$counter = rand( 10, 99999 );
			extract( $instance );
			$username 		= isset( $username ) && !empty( $username ) ? $username : 'envato';
			$no_of_tweets 	= isset( $no_of_tweets ) && !empty( $no_of_tweets ) ? $no_of_tweets : 3;
			$title 			= isset( $instance[ 'title' ] ) && !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';

			$tweets 		= $this->prepare_tweets( $username, $no_of_tweets );
			echo( $args[ 'before_widget' ] );
			if ( !empty( $title ) ) {
				echo( $args[ 'before_title' ] . apply_filters( 'widget_title', esc_attr( $title ) ) . $args[ 'after_title' ] );
			}

			if ( isset( $tweets[ 'data' ] ) && !empty( $tweets[ 'data' ] ) ) { ?>
				<div class="dc-footercontent">
					<ul class="dc-livefeeddetails"><?php echo force_balance_tags($tweets['data']); ?></ul>
				</div>
			<?php } else {?>
				<div class="dc-description">
					<p><?php esc_html_e('Sorry! No tweets found','doctreat_core');?></p>
				</div>
			<?php } 
				echo( $args[ 'after_widget' ] );
		}

		/**
		 * @get Tweets
		 *
		 * @param $username
		 * @param $numoftweets
		 */
		public function prepare_tweets( $username, $numoftweets ) {
			global $counter,$theme_settings;
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

					$consumerkey 		= !empty( $theme_settings['consumer_key'] ) ? $theme_settings['consumer_key'] : '';
					$consumersecret 	= !empty( $theme_settings['consumer_secret'] )  ? $theme_settings['consumer_secret'] : '';
					$accesstoken 		= !empty( $theme_settings['access_token'] ) ? $theme_settings['access_token'] : '';
					$accesstokensecret 	= !empty( $theme_settings['access_token_secret'] ) ? $theme_settings['access_token_secret'] : '';

					$connection 		= new TwitterOAuth( $consumerkey, $consumersecret, $accesstoken, $accesstokensecret );
					
					if ( empty( $consumerkey ) || empty( $consumersecret ) ) {
						return '';
					}
					
					$tweets = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $username . "&count=" . $numoftweets );

					if ( !empty( $tweets ) ) {
						if ( !is_wp_error( $tweets )and is_array( $tweets ) ) {
							set_transient( $transName, $tweets, 60 * $cacheTime );
						} else {
							$tweets = get_transient( 'latest-tweets' );
						}
						delete_transient( 'latest-tweets' );
						if ( !is_wp_error( $tweets )and is_array( $tweets ) ) {

							$rand_id = rand( 5, 300 );
							$exclude = 0;
							foreach ( $tweets as $tweet ) {
								$exclude++;                             
								$text = $tweet->{'text'};
								$text = substr( $text, 0, 100 );
								foreach ( $tweet->{'user'} as $type => $userentity ) {
									if ( $type == 'profile_image_url' ) {
										$profile_image_url = $userentity;
									} else if ( $type == 'screen_name' ) {
										$screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="colrhover" title="' . $userentity . '">@' . $userentity . '</a>';
									}
								}

								foreach ( $tweet->{'entities'} as $type => $entity ) {
									if ( $type == 'hashtags' ) {
										foreach ( $entity as $j => $hashtag ) {
											$update_with_link = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&amp;src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
											$update_with = $hashtag->{'text'};
											$text = str_replace( '#' . $hashtag->{'text'}, $update_with, $text );
										}

									}
								}

								$large_ts = time();
								$n = $large_ts - strtotime( $tweet->{'created_at'} );
								if ( $n < ( 60 ) ) {
									$posted = sprintf( esc_html__( '%d seconds ago', 'doctreat_core' ), $n );
								} elseif ( $n < ( 60 * 60 ) ) {
									$minutes = round( $n / 60 );
									$posted = sprintf( _n( 'About a Minute Ago', '%d Minutes Ago', $minutes, 'doctreat_core' ), $minutes );
								} elseif ( $n < ( 60 * 60 * 16 ) ) {
									$hours = round( $n / ( 60 * 60 ) );
									$posted = sprintf( _n( 'About an Hour Ago', '%d Hours Ago', $hours, 'doctreat_core' ), $hours );
								} elseif ( $n < ( 60 * 60 * 24 ) ) {
									$hours = round( $n / ( 60 * 60 ) );
									$posted = sprintf( _n( 'About an Hour Ago', '%d Hours Ago', $hours, 'doctreat_core' ), $hours );
								} elseif ( $n < ( 60 * 60 * 24 * 6.5 ) ) {
									$days = round( $n / ( 60 * 60 * 24 ) );
									$posted = sprintf( _n( 'About a Day Ago', '%d Days Ago', $days, 'doctreat_core' ), $days );
								} elseif ( $n < ( 60 * 60 * 24 * 7 * 3.5 ) ) {
									$weeks = round( $n / ( 60 * 60 * 24 * 7 ) );
									$posted = sprintf( _n( 'About a Week Ago', '%d Weeks Ago', $weeks, 'doctreat_core' ), $weeks );
								} elseif ( $n < ( 60 * 60 * 24 * 7 * 4 * 11.5 ) ) {
									$months = round( $n / ( 60 * 60 * 24 * 7 * 4 ) );
									$posted = sprintf( _n( 'About a Month Ago', '%d Months Ago', $months, 'doctreat_core' ), $months );
								} elseif ( $n >= ( 60 * 60 * 24 * 7 * 4 * 12 ) ) {
									$years = round( $n / ( 60 * 60 * 24 * 7 * 52 ) );
									$posted = sprintf( _n( 'About a year Ago', '%d years Ago', $years, 'doctreat_core' ), $years );
								}


								$json[ 'data' ] .= '<li><div class="dc-description">';
								$json[ 'data' ] .= '<p>' . $text . '</p>';
								$json[ 'data' ] .= '</div>';
								$json[ 'data' ] .= '<time datetime="' . date( 'Y-m-d', strtotime( $posted ) ) . '">' . $posted . '</time>' . '</li>';
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
		public function form( $instance ) {
			// outputs the options form on admin
			$title 			= !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : esc_html__( 'Tweets', 'doctreat_core' );
			$username 		= !empty( $instance[ 'username' ] ) ? $instance[ 'username' ] : '';
			$no_of_tweets 	= !empty( $instance[ 'no_of_tweets' ] ) ? $instance[ 'no_of_tweets' ] : '';
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
		public function update( $new_instance, $old_instance ) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance[ 'title' ] 		= ( !empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
			$instance[ 'username' ] 	= ( !empty( $new_instance[ 'username' ] ) ) ? strip_tags( $new_instance[ 'username' ] ) : '';
			$instance[ 'no_of_tweets' ] = ( !empty( $new_instance[ 'no_of_tweets' ] ) ) ? strip_tags( $new_instance[ 'no_of_tweets' ] ) : '6';
			return $instance;
		}

	}
}

//register widget
function doctreat_register_doctreat_tweets_widgets() {
	register_widget( 'Doctreat_links' );
}
add_action( 'widgets_init', 'doctreat_register_doctreat_tweets_widgets' );