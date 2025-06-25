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
 * This is used to define all functions For curl and database requests
 *
 * @since      1.0.0
 * @author     Blue Plugins <rupinder.php@gmail.com>
 */
class ECFG_template_functions {
      
	/*Introducing variables here*/  
   	protected $error_message;
		
	public function __construct() {
		$this->error_message = '';
		$this->calender_id = $this->ECFG_option_field('gc_general_settings','gc_calender_id'); 
	    $this->client_key =  $this->ECFG_option_field('gc_general_settings','gc_events_api_key'); 
			
	}
	
	/*Errors functions*/
	public function ECFG_curl_errors($list_events)
	{
	
	
	    $general_settings = get_option('gc_general_settings');
		if(empty($general_settings))
		{
			echo '<div class="gc_errors"><p>'.esc_html__('Please go to plugin settings page and save your settings.','events-calendar-for-google').'</p></div>';
			exit;
		}
		
		if(is_wp_error($list_events))
		{
		       echo '<div class="gc_errors"><p>' . esc_html($list_events->get_error_message()) .'. '. esc_html__('Please check your internet connection.','events-calendar-for-google').'</p></div>';
				exit;
			
		}
		
		$api_errors = json_decode($list_events['body']);
		if(isset($api_errors->error) && $api_errors->error != '')
		{
		echo '<div class="gc_errors"><p>'.esc_html($api_errors->error->message).'</p></div>';
		exit;
		}
	
		
	
	
	}
	/*
     * Get dashboard saved option values from database wp_option
	 * @since     1.0.0
	 * @return    $output.
	*/
	public function ECFG_option_field($op_value,$key)
	{
		$value = get_option( $op_value );
		if( isset($value) && isset($value[$key]) && $value != '')
		{
			$value = $value[$key];
			return $value;
		}
		else
		{
			$value = '';
			return $value;
			//$this->error_message = esc_html__('Please go to plugin settings page and save your settings','events-calendar-for-google');
		}
			
	}
	
	/*
	 * Get option value from cmb2 group values
	 * @since     1.0.0
	 * @return    $output.
	*/
	
	public function ECFG_option_group_field($option_value,$group_section,$key)
	{
		$value = get_option( $option_value );
		if(isset($value) && $value != '')
		{
			$value = $value[$group_section][$key];
			return $value;
		}
		else
		{
			$this->error_message = esc_html__('Please go to plugin settings page and save your settings','events-calendar-for-google');
		}
			
	}
	
	/**
	 * Function to set Events parameters to be called.
	 *
	 * @since     1.0.0
	 */
	 
	public function ECFG_calendar_param()
	{
		
		$params = array();
		/*Get current date*/
		$event_timezone = $this->ECFG_option_group_field('gc_advanced_settings','gc_event_timezone','gc_custom_timezone');
		$timezone = new DateTimeZone($event_timezone); // Set the desired timezone
		$datetime = new DateTime('now');
		
		/*Convert it to google calendar's rfc_format */
		$rfc_format = $datetime->format('c');
		
		$params[] = 'orderBy=startTime';
		$params[] ='maxResults=100';
		$params[] = 'timeMin='.urlencode($rfc_format);
		//$website_timezone = wp_timezone_string();
		//may be needed timezone as ctx here
		
		$url_param = '';
		foreach($params as $param)
		{
			$url_param.= '&'.$param;
		}
		
		return $url_param;
	}
	

	
	/**
	 * List  Google Calender events based on Api key and Calender Id 
	 * @since    1.0.0
	 * @access   public
	 */
	public	function ECFG_get_calender_events()
	{
		$params  = $this->ECFG_calendar_param();
       
		$calender_id = $this->calender_id;
		$client_key =  $this->client_key;
		$url = "https://www.googleapis.com/calendar/v3/calendars/".$calender_id."/events?key=".$client_key."&singleEvents=true".$params;
		
		$list_events = wp_remote_post($url, array(
           'method' => 'GET',
           'timeout' => 45,		  
		 )
        );
		/*list all error here before listing events*/
		$this->ECFG_curl_errors($list_events);	 	 
		$list_events = json_decode($list_events['body']);
		$cal_events = $list_events->items;
		$full_calender = array();
		
		foreach($cal_events as $single_event)
		{
			
		    if(isset($single_event->start->date) && property_exists($single_event, 'start') && property_exists($single_event->start, 'date') )
				{   
					$all_day = 'yes'; 
					$startdate = $single_event->start->date;
					$enddate = $single_event->end->date;
					$event_date = (new DateTime($startdate))->format('Y-m-d');
					
				}
		   if(isset($single_event->start->dateTime))
				{
					$all_day = 'no'; 
					$startdate = $single_event->start->dateTime;
					$enddate = $single_event->end->dateTime;
					$event_date = (new DateTime($startdate))->format('Y-m-d');
				}  
			
						
			if($single_event->status == 'confirmed')
			{
				if(isset($single_event->start->timeZone))
				{
					$event_timezone =  $single_event->start->timeZone;
				}
				else
				{
					$event_timezone =  '';
				}
				
				if(isset($single_event->description) && $single_event->description != '')
				{
					$description = $single_event->description;
				}
				else
					{
						$description = '';
					}		
				if(isset($single_event->location) && $single_event->location != '')
					{
						$location = $single_event->location;

					}	
				else
					{
						$location = '';
					}	
				
				$full_calender[] = array(
									 'name'=> $single_event->summary,
									 'description'=>wp_kses_post($description),
									 'all_day'=>$all_day,
									 'start_date'=>$startdate,
									 'end_date'=>$enddate,
									 'timezone'=>$event_timezone,
									 'location'=>wp_kses_post($location),
									 'link'=>  esc_url_raw( $single_event->htmlLink ),
									 );
									
			
			} 
			
		}/**end of foreach condition*/
	 	
		
		usort($full_calender,function($a,$b)
			{
				$t1 = strtotime($a['start_date']);
				$t2 = strtotime($b['start_date']);
				return $t1 - $t2;
			});
		
		return $full_calender;
	
	}
	
	/**End ECFG_get_calender_events function**/
	/**
	 * List pagination links under events
	 * @since    1.0.0
	 * @access   public
	 **/
	public function ECFG_pagainate_link_function($total_events,$events_to_show){
		
		
		$current_page = 1;
		
		$prev = $current_page -1;
		$next = $current_page +1;
		
		$total_pages  = ceil($total_events/$events_to_show);
		         

	             $output = ''; 
				             
				               $output .='<p class="gc_total_pages" data-id="'.$total_pages.'" style="display:none;"></p>';
							   $output .='<a class="page-numbers prev" href="#" data-id="'.$prev.'" style="display:none;">'.esc_html__('Prev','events-calendar-for-google').'</a>';
							 
							
								if(!empty($total_pages)){
									
									for($i=1; $i<=$total_pages; $i++)
									{
										
										$output .='<a class="page-numbers numeric" href="#" data-id="'.$i.'">'.$i.'</a>';
									}
								}
								
							 	$output .='<a class="page-numbers next" href="#" data-id="'.$next.'" >'.esc_html__('Next','events-calendar-for-google').'</a>';
							
								
								
			
				return $output ; 

    }

}/*end of class*/
