<?php
/**
 * List Design 1
 * @package Blog Designer Pack
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="tgs_event">
					
					 
					  <div class="tgse_section_left tgse_date_section">
					  <!--inludes date-->
					 <?php  do_action('ecfg_e_date',$start_date,$event_timezone); ?>
					  </div>
					
					  
					   <div class="tgse_section_right tgse_desc_section">
					    <!--inludes title-->
					     <?php  do_action('ecfg_e_title',$event_title); ?>
						  
							<div class="tgse_meta">
							    <!--inludes desciption-->
							    <?php do_action('ecfg_e_desc',$event_content); ?>
								<!--inludes location-->
								<?php  do_action('ecfg_e_location',$event_location); ?>
									
								<!--inludes time-->
								<?php do_action('ecfg_e_time',$start_date,$end_date,$alldayevent,$event_timezone);?>
								
								<!--inludes Read more-->
								<?php do_action('ecfg_e_more',$event_link);?>
																
									
								
							</div>
					</div>
						
</div>
