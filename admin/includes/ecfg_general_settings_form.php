<?php
 function ECFG_General_Settings_Form() {
	 if (!current_user_can('manage_options')) {
        wp_die(esc_html(__('You do not have sufficient permissions to access this page.', 'events-calendar-for-google')));
    }
    ?>
    <div class="wrap">
        <h1>GC Events Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('gc_general_settings');// to  hold the value in database
            do_settings_sections('ecfg_general_settings');//based on page name
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
// callback functions


function gc_events_api_key_callback($args) {
    $options = get_option('gc_general_settings');
    $value = isset($options['gc_events_api_key']) ? $options['gc_events_api_key'] : '';
    echo '<input type="text" id="' . esc_attr($args['label_for']) . '" name="gc_general_settings[gc_events_api_key]" value="' . esc_attr($value) . '" required />';
    echo '<p><strong>Create and Add Google Api to connect your calendar. <a href="https://console.cloud.google.com/apis/credentials">Get Your Api Credentials Here</a></strong></p>';
}

function gc_calender_id_callback($args) {
    $options = get_option('gc_general_settings');
    $value = isset($options['gc_calender_id']) ? $options['gc_calender_id'] : '';
    echo '<input type="text" id="' . esc_attr($args['label_for']) . '" name="gc_general_settings[gc_calender_id]" value="' . esc_attr($value) . '" required />';
    echo '<p><strong>Enter ID of particular calendar which events you want to list. <a href="https://calendar.google.com/calendar">Get your Calendar ID</a></strong></p>';
}

function gc_calender_layout_callback($args) {
    $options = get_option('gc_general_settings');
    $value = isset($options['gc_calender_layout']) ? $options['gc_calender_layout'] : '';
    $layouts = array(
        'grid'            => 'Grid',
        'list'            => 'List',
        'google_calender' => 'Google Calendar',
    );
    echo '<select id="' . esc_attr($args['label_for']) . '" name="gc_general_settings[gc_calender_layout]" required>';
    foreach ($layouts as $layout_value => $label) {
        echo '<option value="' . esc_attr($layout_value) . '" ' . selected($value, $layout_value, false) . '>' . esc_html($label) . '</option>';
    }
    echo '</select>';
    echo '<p>Select style to list your events at frontend.</p>';
}

function gc_shortcode_callback() {
    echo '<h3>[ECFG_calender_events]</h3><hr>';
}
