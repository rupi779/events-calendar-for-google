<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://blueplugins.com/
 * @since      1.0.0
 *
 * @package    ECFG_Events_Calendar_for_Google
 * @subpackage ECFG_Events_Calendar_for_Google/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hook function
 *
 * @package    ECFG_Events_Calendar_for_Google
 * @subpackage ECFG_Events_Calendar_for_Google/admin
 * @author     Blue Plugins <rupinder.php@gmail.com>
 */
 
class ECFG_events_calendar_google_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function ECFG_admin_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/events-calendar-for-google-admin.css', array(), $this->version, 'all' );
		//wp_enqueue_style('wp-color-picker');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function ECFG_admin_enqueue_scripts() {

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/events-calendar-for-google-admin.js', array( 'jquery' ), $this->version, false );
		// Enqueue the color picker initialization script (with dependency on wp-color-picker)
		wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'gc-color-picker', plugin_dir_url( __FILE__ ) . 'js/color-picker-init.js', array( 'wp-color-picker' ), $this->version, true );
    }



	
	public  function ECFG_admin_settings_pages() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/custom_admin_setting_fields.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/ecfg_general_settings_form.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/ecfg_event_attribute_form.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/ecfg_advanced_setting_form.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/includes/ecfg_pro_feature_form.php';
		
	}
	
	public function ECGF_custom_admin_menu() {
    add_menu_page(
        'GC Settings', // Page title
        'GC Calendar', // Menu title
        'manage_options', // Capability
        'gc_general_settings', // Menu slug
        'ECFG_General_Settings_Form', // Callback function
        'dashicons-calendar', // Icon
        20 // Position
    );

    add_submenu_page(
        'gc_general_settings', // Parent slug
        'General Settings', // Page title
        'General Settings', // Menu title
        'manage_options', // Capability
        'gc_general_settings', // Submenu slug
        'ECFG_General_Settings_Form' // Callback function
    );
	
	add_submenu_page(
        'gc_general_settings', // Parent slug
        'Event Attributes', // Page title
        'Event Attributes', // Menu title
        'manage_options', // Capability
        'gc_event_attributes', // Submenu slug
        'ECFG_Event_Attribute_Form' // Callback function
    );

    add_submenu_page(
        'gc_general_settings', // Parent slug
        'Advanced Settings', // Page title
        'Advanced Settings', // Menu title
        'manage_options', // Capability
        'gc_advanced_settings', // Submenu slug
        'ECFG_Advance_setting_Form' // Callback function
    );

    add_submenu_page(
        'gc_general_settings', // Parent slug
        'Pro Features', // Page title
        'Pro Features', // Menu title
        'manage_options', // Capability
        'gc_pro_features', // Submenu slug
        'ECFG_pro_features_page' // Callback function
    );
}
	

	
	public function ECFG_admin_settings_link($links) {
	    $mylink = array();
		$mylink[] = '<a style="font-weight: 700; color:#b76613;" target="_blank" href="https://blueplugins.com/events-calendar-for-google-pro/">Go Pro</a>';
		$mylink[] = '<a href="' . admin_url( 'admin.php?page=gc_general_settings' ) . '">Settings</a>';
		return array_merge( $mylink, $links );
	}
	

	
	

}
