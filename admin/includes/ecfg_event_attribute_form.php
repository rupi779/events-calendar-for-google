<?php

// Function to display the settings form
function ECFG_Event_Attribute_Form() {
    if (!current_user_can('manage_options')) {
        wp_die(esc_html(__('You do not have sufficient permissions to access this page.', 'events-calendar-for-google')));
    }
    ?>
    <div class="wrap">
        <h1>GC Events Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting "gc_event_attributes"
            settings_fields('gc_event_attributes');

            // Output setting sections and their fields
            do_settings_sections('ecfg_event_attributes');

            // Output save settings button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function gc_event_attribute_fields_callback( $args ) {
    $options = get_option( 'gc_event_attributes' );
    $value = isset( $options[ $args['id'] ] ) ? $options[ $args['id'] ] : 'on';
    ?>
    <label>
        <input type="radio" name="gc_event_attributes[<?php echo esc_attr( $args['id'] ); ?>]" value="on" <?php checked( $value, 'on' ); ?>>
        <?php esc_html_e( 'Show', 'events-calendar-for-google' ); ?>
    </label>
    <label>
        <input type="radio" name="gc_event_attributes[<?php echo esc_attr( $args['id'] ); ?>]" value="off" <?php checked( $value, 'off' ); ?>>
        <?php esc_html_e( 'Hide', 'events-calendar-for-google' ); ?>
    </label>
    <?php
}