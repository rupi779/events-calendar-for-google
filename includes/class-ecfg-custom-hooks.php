<?php
/**

 * @link       https://blueplugins.com/
 * @since      1.0.0
 *
 * @package    ECFG_Events_Calendar_for_Google
 * @subpackage ECFG_Events_Calendar_for_Google/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define all functions For actions and Hooks
 *
 * @since      1.0.0
 * @author     Blue Plugins 
 */
class ECFG_Define_Custom_Hooks {
      
	/*Introducing variables here*/  
   	
		
	public function __construct() {
		//$this->error_message = '';
		require_once ECFG_PLUGIN_DIR . 'includes/class-ecfg-template-functions.php';
		$this->template_function = new ECFG_template_functions();
		//$this->layout =  $this->template_function->ECFG_option_field('gc_general_settings','gc_calender_layout'); 
	}
	/**
	 * The function to call event date
	 * @since     1.1.0
	 */
	public function ecfg_e_date_function($start_date,$event_timezone) {
		$event_timezone =  $this->ecfg_e_timezone_function($event_timezone);
		$datetime = new DateTime($start_date, wp_timezone()); // Create DateTime object with WordPress timezone
        $datetime->setTimezone(new DateTimeZone($event_timezone)); // Set the timezone to 'event_timezone'
        /*$timezone = $datetime->getTimezone(); print_r($timezone); to retrive timezone**/
		
		 
			   
     	if(isset($start_date) && $start_date != '' )
		    {
 
			$date_design = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_date_section_style','date_design');
			$date_design = isset($date_design) ? $date_design : 'style_1';
			?>
			   
			<div class="tgse_date tgse_date_<?php echo esc_attr($date_design); ?>">
					<div class="tgse_date_day"><?php echo esc_html($datetime->format('d'));?></div>
					<div class="tgse_date_month"><?php echo esc_html($datetime->format('M'));?></div>
			</div>
				  
				  <?php
            } 
	  
	}
	
	/**
	 * The function to call event title
	 * @since     1.1.0
	 */
	public function ecfg_e_title_function($event_title) {
    
	    $title_tag = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_desc_style','title_tag');
		$title_tag = isset($title_tag )?$title_tag : 'h4';
		$show_title = $this->template_function->ECFG_option_field('gc_event_attributes','gc-event-attribute-title');
     	   if(isset($event_title) && $event_title != '' && $show_title == 'on' || $show_title == '')
		   {
		     echo '<div class="tgse_title"><'.esc_attr($title_tag).' class="tgse_header">'. esc_attr($event_title) .'</'.esc_attr($title_tag).'></div>';
		   }
		   
   	}
	/**
	 * The function to call event description
	 * @since     1.1.0
	 */
	public function ecfg_e_desc_function($event_content) {
    
	
	    $show_desc  = $this->template_function->ECFG_option_field('gc_event_attributes','gc-event-attribute-description');
   
		if(isset($event_content) && $event_content != '' && $show_desc == 'on' || $show_desc == '' )
				{
				
				echo '<div class="tgse_description">
						<span>'.esc_html(wp_trim_words(($event_content), 15, '...' )).'</span>
						</div>';
				}
	}
	
	/**
	 * The function to call event title
	 * @since     1.1.0
	 */
	public function ecfg_e_location_function($event_location) {
    
	   	$show_location = $this->template_function->ECFG_option_field('gc_event_attributes','gc-event-attribute-location');   
		if((isset($event_location) && $event_location != '') && ($show_location == 'on' || $show_location == '') )
		{
			$gmap_link =  'https://maps.google.com/maps?q='.$event_location;
			?>
		<div class="tgse_location">
		<span class="tgse_location_icon tgse_icon"><li class="fa fa-map-marker-alt"></li></span>
		<span class="tgse_location_adress"><?php echo wp_kses_post($event_location);?></span>
		<a href="<?php echo esc_url($gmap_link);?>"><?php echo  esc_html__('View on Map','events-calendar-for-google'); ?></a>
			
		</div>
		<?php 
        }    
   	}
	
	/**
	 * The function to call event time and date in description section
	 * @since     1.1.0
	 */
	public function ecfg_e_time_function($start_date,$end_date,$alldayevent,$event_timezone) {
    
		$show_time  = $this->template_function->ECFG_option_field('gc_event_attributes','gc-event-attribute-time');
		$show_time = isset($show_time) ? $show_time : 'on';
		$show_date  = $this->template_function->ECFG_option_field('gc_event_attributes','gc-event-attribute-date');
		$show_date = isset($show_date) ? $show_date : 'on';
		$event_timezone =  $this->ecfg_e_timezone_function($event_timezone);
		$start_datetime = new DateTime($start_date, wp_timezone()); // Create DateTime object with WordPress timezone
        $start_datetime->setTimezone(new DateTimeZone($event_timezone)); // Set the timezone to 'event_timezone'
		$end_datetime = new DateTime($end_date, wp_timezone()); // Create DateTime object with WordPress timezone
        $end_datetime->setTimezone(new DateTimeZone($event_timezone)); // Set the timezone to 'event_timezone'
		if($alldayevent == 'yes')
		{
		$event_start = $start_date;
		?>
			
		<div class="tgse_date_all_day">
		<span class="tgse_time_icon tgse_icon"> <i class="fas fa-calendar-alt"></i></span>
		<span class="tgse_timerange"><?php echo esc_html($start_datetime->format('Y-m-d'));?></span>
		</div>
		<div class="tgse_all_day_check">
		<span class="tgse_allday_icon tgse_icon"> <i class="fa fa-check-circle" aria-hidden="true"></i></span>
		<span class="tgse_all_day"><?php echo  esc_html__('All Day Event','events-calendar-for-google'); ?></span>
		</div>
		<?php
		}
		else
		{
		$event_start_date = $start_datetime->format('Y-m-d');
		$event_start_time = $start_datetime->format('H:i');
		$event_end_date = $end_datetime->format('Y-m-d');
		$event_end_time = $end_datetime->format('H:i');
		$show_timezone  = $this->template_function->ECFG_option_field('gc_event_attributes','gc-event-attribute-timezome');
			if($event_start_date == $event_end_date)
			{
				$newdate = $event_start_date;
			}
			else
			{
				$newdate = $event_start_date.' - '.$event_end_date;
			}
		
		?>
				<div class="tgse_date_time">
				<span class="tgse_time_icon tgse_icon"> <i class="fas fa-calendar-alt"></i></span>
				<span class="tgse_timerange"><?php echo esc_attr($newdate);?></span>
				</div>

				<div class="tgse_time">
				<span class="tgse_time_icon tgse_icon"><i class="fas fa-clock"></i></span>
				<span class="tgse_timerange"><?php echo esc_attr($event_start_time).' - '.esc_attr($event_end_time) ;?></span>
				</div>
				<?php 
				if($show_timezone == 'on' || $show_timezone == '')
					{
				?>
				<div class="tgse_timezone">
				<span class="tgse_globe_icon tgse_icon"><i class="fas fa-globe"></i></span>
				<span class="tgse_timezone"><?php echo esc_html($event_timezone) ;?></span>
				</div>
				
				<?php
					}/*timezone condition closes*/
				
		}


		
   	}/*end of time function*/


	/**
	 * The function to call Timezone For event listing
	 * @since     1.1.0
	 */
	public function ecfg_e_timezone_function($event_timezone) {
		//gc-timezone-preference
		    $timezone_type = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_timezone','gc_timezone_preference');
           	if ($timezone_type == 'custom')
			{
				$timezone = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_timezone','gc_custom_timezone');
               ////timezone is set to custom setting
			
			}
			if ($timezone_type == 'default_cal' || $timezone_type == '' )
			{
                 // Timezone is following the default of google calendar
				    if(isset($event_timezone) && $event_timezone != '')
					{
						$timezone = $event_timezone;
					}	
					else
					{
						$timezone = 'UTC';
					}		   
			}
	
	return $timezone;

		
   	}/*end of timezone function*/
	
	/**
	 * The function to call Timezone For event listing "grid layout"
	 * @since     1.1.0
	 */
	public function ecfg_google_timezone_function() {
		//gc-timezone-preference
		    $timezone_type = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_timezone','gc_timezone_preference');
           	if ($timezone_type == 'custom')
			{
				$timezone = $this->template_function->ECFG_option_group_field('gc_advanced_settings','gc_event_timezone','gc_custom_timezone');
               ////timezone is set to custom setting
			
			}
			if ($timezone_type == 'default_cal')
			{
                $timezone = 'UTC';
						   
			}
	
	return $timezone;

		
   	}/*end of timezone function*/
	
	/**
	 * The function to Add read more Link at link
	 * @since     1.1.0
	 */
	public function ecfg_e_more_function($event_link) {
    
	    $show_readmore  = $this->template_function->ECFG_option_field('gc_event_attributes','gc-event-attribute-readmore');
		if($show_readmore == 'on' || $show_readmore == '')
		{
		?>
		<div class="tgse_readmore">
		<a class="tgse_readmore_link" href="<?php echo esc_url($event_link);?>" target="_blank"><?php echo  esc_html__('Read More','events-calendar-for-google'); ?></a>
		</div>
		<?php
		}
   	}
	

}/*end of class*/
