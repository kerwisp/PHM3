<?php
global $theme_settings;

$maintenance    = !empty( $theme_settings['maintenance'] )  ? $theme_settings['maintenance'] : '';
$logo           = !empty( $theme_settings['cm_logo']['url'] )  ? $theme_settings['cm_logo']['url'] : '';
$img            = !empty( $theme_settings['cm_image']['url'] )  ? $theme_settings['cm_image']['url'] : '';
$title          = !empty( $theme_settings['cm_title'] )  ? $theme_settings['cm_title'] : '';
$sub_title      = !empty( $theme_settings['cm_sub_title'] )  ? $theme_settings['cm_sub_title'] : '';
$description    = !empty( $theme_settings['cm_description'] )  ? $theme_settings['cm_description'] : '';
$copyright      = !empty( $theme_settings['cm_copyright'] )  ? $theme_settings['cm_copyright'] : '';
$date      		= !empty( $theme_settings['date'] )  ? $theme_settings['date'] : '';
$formatted_date = date("Y, n, d, H, i, s", strtotime("-1 month", strtotime($date)));

$post_name = doctreat_get_post_name();

if (( !empty($maintenance) && $maintenance == true and ! (is_user_logged_in()) ) || $post_name == "coming-soon") {
    if( !empty( $img ) ||
        !empty( $logo ) ||
        !empty( $title ) ||
        !empty( $description ) ||
        !empty( $date ) ) {
        ?>
        <main id="dc-main" class="dc-main dc-haslayout">
			<div class="dc-haslayout dc-comgsnspace">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div class="dc-comingsoon-holder dc-haslayout">
								<div class="dc-comingsoon-aligncenter dc-comingsoonvtwo">
								<?php 
									if( !empty( $logo ) ||
										!empty( $title ) ||
										!empty( $description ) ||
										!empty( $date ) ) {
										?>
										<div class="dc-comingsoon-content">
											<?php if (!empty($logo)) { ?>
											<strong class="dc-comingsoon-logo"><img src="<?php echo esc_url( $logo );?>" alt="<?php echo esc_attr( $title );?>"></strong>
											<?php } ?>
											<div class="dc-cmgsooncntent">
												<div class="dc-title">
													<h2>
														<?php if( !empty( $title ) ) { ?><span><?php echo esc_html( $title );?></span><?php } ?>
														<?php echo esc_html( $sub_title );?>
													</h2>
												</div>
												<?php if( !empty( $description ) ){?>
													<div class="dc-description"><p><?php echo do_shortcode( $description );?></p></div>	
												<?php } ?>	
											</div>
											<?php if( !empty( $date ) ) { ?>
											<ul id="dc-comming-sooncounter" class="dc-comming-sooncounter dc-comming-sooncountervtwo">
												<li class="dc-counterboxes">
													<div id="days" class="timer_box days"></div>
												</li>
												<li class="dc-counterboxes">
													<div id="hours" class="timer_box hours"></div>
												</li>
												<li class="dc-counterboxes">
													<div id="minutes" class="timer_box minutes"></div>
												</li>
												<li class="dc-counterboxes">
													<div  id="seconds" class="timer_box seconds"></div>
												</li>
											</ul>
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
      </main>
      <?php if( !empty( $copyright ) ){?>
		   <footer id="dc-footer" class="dc-cmgsoonftr dc-haslayout">
				<div class="dc-footerbottom">
						<div class="container">
							<div class="row">
								<div class="col-12 col-sm-12">
									<p class="dc-copyright"><?php echo do_shortcode( $copyright ); ?></p>
								</div>
							</div>
						</div>
					</div>
			</footer>
       <?php }
		
       $script = "
            (function($) {
                var launch = new Date(".esc_html($formatted_date).");
                console.log(launch);
                var days = jQuery('#days');
                var hours = jQuery('#hours');
                var minutes = jQuery('#minutes');
                var seconds = jQuery('#seconds');
                setDate();
                function setDate(){
                    var now = new Date();
                    if( launch < now ){
                        days.html('<h1>0</h1><p>". esc_html__('Days','doctreat') ."</p>');
                        hours.html('<h1>0</h1><p>". esc_html__('Hours','doctreat') ."</p>');
                        minutes.html('<h1>0</h1><p>". esc_html__('Minutes','doctreat') ."</p>');
                        seconds.html('<h1>0</h1><p>". esc_html__('Second','doctreat') ."</p>');
                    }
                    else{
                        var s = -now.getTimezoneOffset()*60 + (launch.getTime() - now.getTime())/1000;
                        var d = Math.floor(s/86400);
                        days.html('<h1>'+d+'</h1><p>". esc_html__('Day','doctreat') ."'+(d>1?'s':''),'</p>');
                        s -= d*86400;
                        var h = Math.floor(s/3600);
                        hours.html('<h1>'+h+'</h1><p>". esc_html__('Hour','doctreat') ."'+(h>1?'s':''),'</p>');
                        s -= h*3600;
                        var m = Math.floor(s/60);
                        minutes.html('<h1>'+m+'</h1><p>". esc_html__('Minute','doctreat') ."'+(m>1?'s':''),'</p>');
                        s = Math.floor(s-m*60);
                        seconds.html('<h1>'+s+'</h1><p>". esc_html__('Second','doctreat') ."'+(s>1?'s':''),'</p>');
                        setTimeout(setDate, 1000);
                    }
                }
            })(jQuery);
        ";
        wp_add_inline_script('doctreat-callback', $script, 'after');
    }
        wp_footer();
        die;
}
