<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://blueplugins.com/
 * @since      1.0.0
 *
 * @package    ECFG_Events_Calendar_for_Google
 * @subpackage ECFG_Events_Calendar_for_Google/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    ECFG_Events_Calendar_for_Google
 * @subpackage ECFG_Events_Calendar_for_Google/public
 * @author     Blue Plugins <rupinder.php@gmail.com>
 */
class ECFG_events_calendar_google_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
			
		/**
		 * The class responsible for defining all functions for public interfacing
		 * side of the site.
		 */
		require_once ECFG_PLUGIN_DIR . 'includes/class-ecfg-template-functions.php';
		require_once ECFG_PLUGIN_DIR . 'includes/class-ecfg-custom-hooks.php';
		$this->template_function = new ECFG_template_functions();
		$this->custom_hooks = new ECFG_Define_Custom_Hooks();
		$this->layout =  $this->template_function->ECFG_option_field('gc_general_settings','gc_calender_layout'); 
		//$date_design = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_date_section_style','date_design');
		
		

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function ECFG_public_enqueue_styles() {

		/**
		 * This function will enque all the style
		
		 */
        $layout =  $this->layout;
		
		if($layout != '' && $layout == 'google_calender' )
		{
		wp_enqueue_style( 'gc-fullcalender-layout', plugin_dir_url( __FILE__ ) . 'css/gc-fullcalender.css', array(), $this->version, 'all' );	
		wp_enqueue_style( 'gc-fc-events', plugin_dir_url( __FILE__ ) . 'css/gc-fullcalender-events.css', array(), $this->version, 'all' );	
		}
		else
		{
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/events-calendar-for-google-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'gc_font_style', plugin_dir_url( __FILE__ ) . 'css/events-fontawesome.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function ECFG_public_enqueue_scripts() {

	
		/**
		 * This function will enque all the javascripts
		 */
			     
		$layout =  $this->layout;
		
		if($layout != '' && $layout == 'google_calender' )
		{
		$client_key = $this->template_function->client_key; 
		$calender_id = $this->template_function->calender_id; 
		$timezone = new DateTimeZone($this->custom_hooks->ecfg_google_timezone_function());
		$timezone_name = $timezone->getName(); 
	    $current_date = new DateTime('now', $timezone);
		$formatted_date = $current_date->format('Y-m-d H:i');
				
		
		/*the above timezone function sets the calendar timezone .further called by fullcalendar-events.js*/ 
		
		$ajax_objects = array( 
		    'ajax_url' => admin_url( 'admin-ajax.php' ),
			'api' => $client_key,
			'id' => $calender_id,
			'current_date'=>$formatted_date,
			'cal_timezone'=>$timezone_name,
		); 
        wp_enqueue_script( 'gc-fullcalender-layout', plugin_dir_url( __FILE__ ) . 'js/gc-fullcalender.js', array( 'jquery' ), $this->version, false );   
		wp_enqueue_script( 'gc-fullcalender-events', plugin_dir_url( __FILE__ ) . 'js/gc-fullcalender-events.js', array( 'jquery' ), $this->version, true );
		wp_localize_script('gc-fullcalender-events', 'events_objects',$ajax_objects);
		
	    } /*End of if condition*/
		else
		{
            /*Events Calendar Public JS*/
			wp_enqueue_script( 'public-event-js', plugin_dir_url( __FILE__ ) . 'js/events-calendar-for-google-public.js', array( 'jquery' ), $this->version, false );
			
		}
		
			

	}
	
	/**
	 * Function to be loaded for footer section style and scripts
	 *
	 * @since    1.0.0
	 */
	
	public  function ECFG_admin_footer_js() {
		
		$layout =  $this->layout;
		$tgc_date_bc_color = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_date_section_style','date-bc-color');
		$tgc_date_bc_color  = isset($tgc_date_bc_color)? $tgc_date_bc_color : '#08267c';
		$tgc_date_text_color = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_date_section_style','date-text-color');
		$tgc_date_text_color = isset($tgc_date_text_color) ? $tgc_date_text_color : '#e1e1e1'; 
		/*event description style*/
		$tgc_desc_bc_color =  $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_desc_style','desc-bc-color');
        $tgc_desc_bc_color  = $tgc_desc_bc_color ? $tgc_desc_bc_color : '#ffffff';
		$title_color =  $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_desc_style','title_color');
        $title_color  = $title_color ? $title_color : '#08267c';
		$icon_color =  $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_desc_style','icon_color');
		$icon_color  = $icon_color ? $icon_color : '#08267c';
		/*button style variables*/
		$tgc_button_bc_color = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_button_style','button_bc');
		$tgc_button_bc_color  = isset($tgc_button_bc_color)? $tgc_button_bc_color : '#08267c';
		$tgc_button_text_color = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_button_style','button_text');
		$tgc_button_text_color = isset($tgc_button_text_color) ? $tgc_button_text_color : '#ffffff'; 
		$tgc_button_hover_color = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_button_style','button_bc_hover');
		$tgc_button_hover_text_color = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_button_style','button_text_hover');
		
		
		?>		
		<?php  $admin_url = get_admin_url(); ?>
		<style>
		:root {
					--tgc-date-bc-color: <?php echo esc_attr(sanitize_hex_color( $tgc_date_bc_color ));?>;  
					--tgc-date-text-color: <?php echo esc_attr(sanitize_hex_color( $tgc_date_text_color ));?>;
					--tgc-desc-title-color: <?php echo esc_attr(sanitize_hex_color( $title_color ));?>; 
                    --tgc-desc-bc-color: <?php echo esc_attr(sanitize_hex_color( $tgc_desc_bc_color ));?>; 					
					--tgc-desc-icon-color: <?php echo esc_attr(sanitize_hex_color( $icon_color ));?>;  
					--tgc-title-align:left;
					
					--tgc-buttons-background: <?php echo esc_attr(sanitize_hex_color( $tgc_button_bc_color ));?>;
					--tgc-buttons-text-color: <?php echo esc_attr(sanitize_hex_color( $tgc_button_text_color ));?>;
					
					--tgc-hover-buttons: <?php echo esc_attr(sanitize_hex_color( $tgc_button_hover_color ));?>;
					--tgc-hover-buttons-text: <?php echo esc_attr(sanitize_hex_color( $tgc_button_hover_text_color ));?>;
					
					--tgc-active-buttons-background: #101b2e;
					--tgc-active-buttons-text: #fff;
					
					--tgc-border-color: #000;
					--tgc-date: #000;
										
					--fc-button-text-color:<?php echo esc_attr(sanitize_hex_color( $tgc_button_text_color ));?>;
					--fc-button-bg-color:<?php echo esc_attr(sanitize_hex_color( $tgc_button_bc_color ));?>;
			  }
		
		</style>
		 <script type="text/javascript">
		
					
					jQuery( ".gc_load_more_events a" ).each(function(index) {
		
						    var total_pages = jQuery(".gc_load_more_events .gc_total_pages").data('id');
							if(total_pages > 5)
							{
								jQuery( ".gc_load_more_events a.numeric" ).hide();
								jQuery( ".gc_load_more_events a.next" ).css('float','right');
								jQuery( ".gc_load_more_events a.prev" ).css('float','left');
							} 
							
                            /*on click pagination link*/							
						    jQuery(this).on("click", function(){
							/*scroll on top of events section*/
							jQuery('html, body').animate({
							scrollTop: jQuery("#the_gc_events_posts").offset().top
							}, 500); 
							
							jQuery('.gc_load_more_events a.active').removeClass("active");
                            jQuery(this).addClass("active");
							var current_page = jQuery(this).attr('data-id');
							var current_page = Number(current_page);
                         	var prev = current_page -1;
							var next = current_page +1;
							jQuery( ".gc_load_more_events a.next" ).attr('data-id',next);
							jQuery( ".gc_load_more_events a.prev" ).attr('data-id',prev);
							    
								
							    
								if(current_page > 1)
									{
									
										jQuery( ".gc_load_more_events a.prev" ).css('display','unset');
										
									}
								else
									{
											jQuery( ".gc_load_more_events a.prev" ).css('display','none');
									}
								
								if(current_page == total_pages )
									{
									
										jQuery( ".gc_load_more_events a.next" ).css('display','none');
									}
								else
									{
										jQuery( ".gc_load_more_events a.next" ).css('display','unset');
									}
						   
						
						 var data = {
                    		action: 'ECFG_events_pagination',
                    		curpage: current_page,
							nonce  : '<?php echo esc_js(wp_create_nonce( 'ecfg_pagination_nonce' ));?>',
							};
							
							jQuery.post( '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', data, function( response )
							{
							            //console.log(data);     
										jQuery('#ecfg_events_wrap').html();											
										jQuery('#ecfg_events_wrap').html(response);
							
							});  
							
						});
						
					});
					
		 </script>
			
		<?php
	}
	

		
	/**
	 * Function to be loaded for pagination.
	 *
	 * @since     1.0.0
	 */
		public function  ECFG_events_pagination()
		{
		    $template_function  = new ECFG_template_functions();
			$layout =  $this->layout;
			
			 if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['nonce'] )), 'ecfg_pagination_nonce' ) ) {
               echo 'invalid nonce';
			
            }
			
		    if ( isset( $_POST['curpage'] ) ) {
				$current_page = intval( wp_unslash( $_POST['curpage'] ) );  // Sanitize 'curpage' as an integer
			} else {
				$current_page = 1;  // Set default value if 'curpage' is not set
			}
			$events = $template_function->ECFG_get_calender_events();
			$total_events = count($events);
		 	$events_to_show = $template_function->ECFG_option_group_field('gc_advanced_settings','gc_pagination','gc_event_per_page');
			if($events_to_show == '' || $events_to_show == 0 || $events_to_show > $total_events)
			{
				$events_to_show = $total_events;
			}
			
			$intiate = $events_to_show*($current_page-1);
		    $events_limit = $events_to_show*$current_page;
			
			if($events_limit > $total_events)
			{
				 $events_limit = $total_events;
			}
					          
			for($i = $intiate; $i < $events_limit; $i++)
					{
						$start_date = $events[$i]['start_date'];
						$end_date = $events[$i]['end_date'];
						//$event_timezone = $events[$i]['timezone'];
						$event_timezone =  $this->custom_hooks->ecfg_e_timezone_function($events[$i]['timezone']); //based on selected preference
						$event_title = sanitize_text_field($events[$i]['name']);
						$event_content = wp_kses_post($events[$i]['description']);
						$event_location = wp_kses_post($events[$i]['location']);
						$event_link = esc_url_raw($events[$i]['link']);
						$alldayevent = $events[$i]['all_day'];
						
						ob_start();
						include plugin_dir_path( dirname( __FILE__ ) ). 'includes/templates/'.$layout.'.php'; 
						$file_included = ob_get_contents();
						ob_end_clean();
						
						echo wp_kses_post( $file_included );
					}/*end for loop*/
					
				 
			exit;
	
		}

	/**
	 * Function to be loaded with shorcode.
	 *
	 * @since     1.0.0
	 */
	
		public function ECFG_load_calender_events($attr)
	    {
			$output = '';
			$template_function  = new ECFG_template_functions();
			$layout =  $this->layout;
			$events = $template_function->ECFG_get_calender_events();
			$total_events = count($events);
			$allowed_layouts = ['list', 'grid', 'google_calendar']; 
			
			if($total_events == 0)
			{
				$output.='<div class="gc_errors"><p>No events Found. Please add Some events to your calendar.</p></div>';
			}/*if total events are 0 or empty show error message*/
			
			else
			{
				
				$events_to_show = $template_function->ECFG_option_group_field('gc_advanced_settings','gc_pagination','gc_event_per_page');
				$show_pagination = 'block';
				if($events_to_show == '' || $events_to_show == 0 ||  $events_to_show > $total_events)
				{
					$show_pagination = 'none';
					$events_to_show = $total_events;
				}
				
				$max_pages  = ceil($total_events/$events_to_show);
				$paginate  = $template_function->ECFG_pagainate_link_function($total_events,$events_to_show);
				
					
						
						$output.='<div id="the_gc_events_posts" class="gc_wrapper_event_'.$layout.'">';
						
						if($layout != '' && $layout == 'google_calender')
						{
							 $output.='<div id="loading">loading...</div>';
							 $output.='<div id="gc_google_calender"></div>';
							
						}
								
						else {
							
							$output.='<div id="ecfg_events_wrap" class="the_gc_event_'.$layout.'">';
								if (in_array($layout, $allowed_layouts))
								{					
								for($i = 0; $i < $events_to_show; $i++)
								{
									$start_date = $events[$i]['start_date'];
									$end_date = $events[$i]['end_date'];
									//$event_timezone = $events[$i]['timezone'];
									$event_timezone =  $this->custom_hooks->ecfg_e_timezone_function($events[$i]['timezone']); //based on selected preference
									$event_title = sanitize_text_field($events[$i]['name']);
									$event_content = wp_kses_post($events[$i]['description']);
									$event_location = wp_kses_post($events[$i]['location']);
									$event_link = esc_url_raw($events[$i]['link']);
									$alldayevent = $events[$i]['all_day'];
									
									ob_start();
									include plugin_dir_path( dirname( __FILE__ ) ). 'includes/templates/'.$layout.'.php'; 
									$file_included = ob_get_contents();
									ob_end_clean();
									$output.= $file_included;  
								}/*end for loop*/	
								$output.='</div>';	
								
								$output.='<div class="gc_load_more_events" style="display:'.$show_pagination.'">'.$paginate.'</div>';				
								} /*proceed if it is on allowed list of layout*/  
                                else
                                {
									$output.= '<p>Invalid layout specified.</p>';
								}								
							}/*end for layout condition*/
						
						$output.='</div>';
						
			}/*Else condition closes*/		

		    return $output; 		
	    }
		
	

}

