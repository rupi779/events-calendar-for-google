<?php
/**
 * Single Event Design 1
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */
get_header();
if (!defined('ABSPATH')) exit; ?>
<div class="tgs_single_event" style="<?php echo esc_attr($random_color); ?>">
  <h2><?php echo esc_html($event_title); ?></h2>
  <div class="tgse_single_desc">
    <div class="tgse_meta">
      <?php do_action('ecfg_e_single_desc', $event_content); ?>
      <?php do_action('ecfg_e_location', $event_location); ?>
      <?php do_action('ecfg_e_time', $start_date, $end_date, $alldayevent, $event_timezone); ?>
    </div>
  </div>
</div>
<?php 
get_footer();
?>