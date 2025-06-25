<?php

// Function to display the settings form
function ECFG_Advance_setting_Form() {
    if (!current_user_can('manage_options')) {
        wp_die(esc_html(__('You do not have sufficient permissions to access this page.', 'events-calendar-for-google')));
    }
    ?>
    <div class="wrap ecfg_advance_settings_wrap">
        <h1>GC Events Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting "gc_advanced_settings"
            settings_fields('gc_advanced_settings');

            // Output setting sections and their fields
            do_settings_sections('ecfg_advanced_settings');

            // Output save settings button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Callbacks for Fields
function ecfg_date_design_field_callback() {
    $options = get_option('gc_advanced_settings');
	$value = isset($options['gc_date_section_style']['date_design']) ? $options['gc_date_section_style']['date_design'] : 'style_1';
    
echo '<div class="ecfg-ad-field-group">';
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="date-design" class="ecfg-ad-field-label">Date Design</label>';
    echo '<select id="date_design" name="gc_advanced_settings[gc_date_section_style][date_design]">';
    echo '<option value="style_1"' . selected($value, 'style_1', false) . '>Style 1</option>';
    echo '<option value="style_2"' . selected($value, 'style_2', false) . '>Style 2</option>';
    echo '</select>';
    echo '</div>'; // End field-row

    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="date-bc-color" class="ecfg-ad-field-label">Background Color</label>';
    echo '<input type="text" id="date-bc-color" name="gc_advanced_settings[gc_date_section_style][date-bc-color]" value="' . esc_attr($options['gc_date_section_style']['date-bc-color']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#08267c">';
    echo '</div>'; // End field-row

    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="date-text-color" class="ecfg-ad-field-label">Text Color</label>';
    echo '<input type="text" id="date-text-color" name="gc_advanced_settings[gc_date_section_style][date-text-color]" value="' . esc_attr($options['gc_date_section_style']['date-text-color']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#ffffff">';
    echo '</div>'; // End field-row
    echo '</div>'; // End field-group

}


function ecfg_event_desc_section_fields_callback() {
    $options = get_option('gc_advanced_settings');
    $value = isset($options['gc_event_desc_style']) ? $options['gc_event_desc_style'] : array(
        'title_tag' => 'h4',
        'desc-bc-color' => '#ffffff',
        'title_color' => '#08267c',
        'icon_color' => '#08267c'
    );
    echo '<div class="ecfg-ad-field-group">';

    // Event Title Tag Dropdown
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="title_tag" class="ecfg-ad-field-label">Event Title Tag</label>';
    echo '<select id="title_tag" name="gc_advanced_settings[gc_event_desc_style][title_tag]" >';
    echo '<option value="h1"' . selected($value['title_tag'], 'h1', false) . '>H1</option>';
    echo '<option value="h2"' . selected($value['title_tag'], 'h2', false) . '>H2</option>';
    echo '<option value="h3"' . selected($value['title_tag'], 'h3', false) . '>H3</option>';
    echo '<option value="h4"' . selected($value['title_tag'], 'h4', false) . '>H4</option>';
    echo '</select>';
    echo '</div>'; // End field-row

    // Background Color
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="desc-bc-color" class="ecfg-ad-field-label">Background Color</label>';
    echo '<input type="text" id="desc-bc-color" name="gc_advanced_settings[gc_event_desc_style][desc-bc-color]" value="' . esc_attr($value['desc-bc-color']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#ffffff">';
    echo '</div>'; // End field-row

    // Title Color
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="title_color" class="ecfg-ad-field-label">Title Color</label>';
    echo '<input type="text" id="title_color" name="gc_advanced_settings[gc_event_desc_style][title_color]" value="' . esc_attr($value['title_color']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#08267c">';
    echo '</div>'; // End field-row

    // Icon Color
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="icon_color" class="ecfg-ad-field-label">Icon Color</label>';
    echo '<input type="text" id="icon_color" name="gc_advanced_settings[gc_event_desc_style][icon_color]" value="' . esc_attr($value['icon_color']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#08267c">';
    echo '</div>'; // End field-row

    echo '</div>'; // End field-group
}

function ecfg_button_style_section_fields_callback() {
    $options = get_option('gc_advanced_settings');
    $value = isset($options['gc_button_style']) ? $options['gc_button_style'] : array(
        'button_bc' => '#08267c',
        'button_text' => '#ffffff',
        'button_bc_hover' => '#08267c',
        'button_text_hover' => '#ffffff'
    );
    echo '<div class="ecfg-ad-field-group">';

    // Button Background Color
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="button_bc" class="ecfg-ad-field-label">Button Background Color</label>';
    echo '<input type="text" id="button_bc" name="gc_advanced_settings[gc_button_style][button_bc]" value="' . esc_attr($value['button_bc']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#08267c">';
    echo '</div>'; // End field-row

    // Button Text Color
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="button_text" class="ecfg-ad-field-label">Button Text Color</label>';
    echo '<input type="text" id="button_text" name="gc_advanced_settings[gc_button_style][button_text]" value="' . esc_attr($value['button_text']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#ffffff">';
    echo '</div>'; // End field-row

    // Button Background Hover Color
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="button_bc_hover" class="ecfg-ad-field-label">Button Background Hover Color</label>';
    echo '<input type="text" id="button_bc_hover" name="gc_advanced_settings[gc_button_style][button_bc_hover]" value="' . esc_attr($value['button_bc_hover']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#08267c">';
    echo '</div>'; // End field-row

    // Button Text Hover Color
    echo '<div class="ecfg-ad-field-row">';
    echo '<label for="button_text_hover" class="ecfg-ad-field-label">Button Text Hover Color</label>';
    echo '<input type="text" id="button_text_hover" name="gc_advanced_settings[gc_button_style][button_text_hover]" value="' . esc_attr($value['button_text_hover']) . '" class="color-picker ecfg-ad-field-input" data-default-color="#ffffff">';
    echo '</div>'; // End field-row

    echo '</div>'; // End field-group
}

function ecfg_pagination_section_fields_callback() {
    $options = get_option('gc_advanced_settings');
    $value = isset($options['gc_pagination']['gc_event_per_page']) ? $options['gc_pagination']['gc_event_per_page'] : 0;
    echo '<div class="ecfg-ad-field-group">';
	echo '<div class="ecfg-ad-field-row">';
	echo '<label for="gc_event_per_page" class="ecfg-ad-field-label">Events Per Page</label>';
    echo '<input type="number" id="gc_event_per_page" name="gc_advanced_settings[gc_pagination][gc_event_per_page]" value="' . esc_attr($value) . '"  min="0"><br>';
   	echo '</div>';
    echo '</div>';
}

function ecfg_timezone_section_fields_callback() {
    $options = get_option('gc_advanced_settings');
    $value = isset($options['gc_event_timezone']) ? $options['gc_event_timezone'] : array(
        'gc_timezone_preference' => 'default_cal',
        'gc_custom_timezone' => 'America/Toronto'
    );
	$current_timezone = get_option('my_timezone_option', 'UTC'); // Default to 'UTC'
    $timezones = DateTimeZone::listIdentifiers();
    
	echo '<div class="ecfg-ad-field-group">';
	echo '<div class="ecfg-ad-field-row">';
	echo '<label for="gc_timezone_preference" class="ecfg-ad-field-label">Timezone Preference</label>';
    echo '<select id="gc_timezone_preference" name="gc_advanced_settings[gc_event_timezone][gc_timezone_preference]" >';
    echo '<option value="default_cal"' . selected($value['gc_timezone_preference'], 'default_cal', false) . '>Default Calendar</option>';
    echo '<option value="custom"' . selected($value['gc_timezone_preference'], 'custom', false) . '>Custom</option>';
    echo '</select><br>';
	echo '</div>';
  

    echo '<div class="ecfg-ad-field-row">';
	echo '<label for="gc_custom_timezone" class="ecfg-ad-field-label">Custom Timezone</label>';
    echo '<select id="gc_custom_timezone" name="gc_advanced_settings[gc_event_timezone][gc_custom_timezone]">';
	echo '</div>';
	
    
    // Get all available time zones
    $timezones = DateTimeZone::listIdentifiers();
    foreach ($timezones as $timezone) {
        echo '<option value="' . esc_attr($timezone) . '" ' . selected($value['gc_custom_timezone'], $timezone, false) . '>' . esc_html($timezone) . '</option>';
    }

    echo '</select><br>';
	echo '</div>';
}

