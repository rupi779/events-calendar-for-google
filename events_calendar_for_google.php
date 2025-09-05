<?php

/**
 * @link              https://blueplugins.com/
 * @package           ECFG_Events_Calendar_for_Google
 * @wordpress-plugin
 * Plugin Name:       Events Calendar for Google
 * Description:       List Google Calender with customized layouts. Manange your Calender events Style from wordpress dashboard.
 * Version:           3.2.1
 * Author:            Blue Plugins
 * Author URI:        https://blueplugins.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       events-calendar-for-google
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'ECFG_VERSION', '3.2.1' );
define('ECFG_PLUGIN_DIR',plugin_dir_path( __FILE__ ));


/**
 * Register rewrite rule on every init (no flush here)
 */
function ecfg_register_routes() {
    add_rewrite_rule(
        '^event-details/([^/]+)/?',
        'index.php?ecfg_event=$matches[1]',
        'top'
    );
}
add_action('init', 'ecfg_register_routes');

/**
 * Register query var
 */
function ecfg_register_qv($vars) {
    $vars[] = 'ecfg_event';
    return $vars;
}
add_filter('query_vars', 'ecfg_register_qv');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-events-calendar-for-google-activator.php
 */

function ecfg_activate_events_calendar_google() {
	//nothing to do
	ecfg_register_routes();
    flush_rewrite_rules();
	$time = strtotime("+1 day");
	update_user_meta( get_current_user_id(), 'ecfg_activated_on', $time );
	$settings = array(
        'gc_date_section_style' => array(
            'date_design'     => 'style_1',
            'date-bc-color'   => '#08267c',
            'date-text-color' => '#e1e1e1',
        ),
        'gc_event_desc_style' => array(
            'title_tag'     => 'h4',
            'desc-bc-color' => '#ffffff',
            'title_color'   => '#08267c',
            'icon_color'    => '#08267c',
        ),
        'gc_button_style' => array(
            'button_bc'         => '#08267c',
            'button_text'       => '#ffffff',
            'button_bc_hover'   => '#08267c',
            'button_text_hover' => '#ffffff',
        ),
        'gc_pagination' => array(
            'gc_event_per_page' => '0',
        ),
        'gc_event_timezone' => array(
            'gc_timezone_preference' => 'default_cal',
            'gc_custom_timezone'     => 'UTC'
        )
    );

    add_option('gc_advanced_settings', $settings);
	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-events-calendar-for-google-deactivator.php
 */
function ecfg_deactivate_events_calendar_google() {
	
	//nothing to do
	flush_rewrite_rules();
	//delete_option('gc_advanced_settings');
}

register_activation_hook( __FILE__, 'ecfg_activate_events_calendar_google' );
register_deactivation_hook( __FILE__, 'ecfg_deactivate_events_calendar_google' );


	/** URL-safe base64 helpers **/
	function ecfg_b64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
	function ecfg_b64url_decode($data) {
		// pad to correct base64 length and swap back to standard chars
		$pad = strlen($data) % 4;
		if ($pad) $data .= str_repeat('=', 4 - $pad);
		return base64_decode(strtr($data, '-_', '+/'));
	}

	/**
	 * Handle /event-details/<key>/ requests
	 */
	function ecfg_template_redirect_handler() {
		$event_key = get_query_var('ecfg_event');
		if (!$event_key) return; // not our route

		$event_link = ecfg_b64url_decode(sanitize_text_field($event_key));
		if (!$event_link) {
			wp_die('Invalid event key.');
		}

		// Fetch events
		$template_function = new ECFG_template_functions();
		$params  = $template_function->ECFG_calendar_param();
		$events  = $template_function->ECFG_get_calender_events($params);

		// Find matching event by Google link
		$event = null;
		foreach ($events as $e) {
			if (!empty($e['link']) && $e['link'] === $event_link) {
				$event = $e;
				break;
			}
		}

		if (!$event) {
			wp_die('Sorry, event not found.');
		}

		// Prepare variables for template (available in included file)
		$start_date     = $event['start_date'] ?? '';
		$end_date       = $event['end_date'] ?? '';
		$event_timezone = $event['timezone'] ?? 'UTC';
		$event_title    = isset($event['name']) ? sanitize_text_field($event['name']) : '';
		$event_content  = isset($event['description']) ? wp_kses_post($event['description']) : '';
		$event_location = isset($event['location']) ? wp_kses_post($event['location']) : '';
		$alldayevent    = $event['all_day'] ?? 'no';
		$random_color   = '';
		//error_log('Router hit: ' . $event_key);
				// Render your plugin template (no theme file needed)
		$path = plugin_dir_path(__FILE__) . 'includes' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'single-event' . DIRECTORY_SEPARATOR . 'events-details.php';

		if ( file_exists( $path ) ) {
			include $path;
		} else {
			error_log( 'Template not found: ' . $path );
		}

		exit; // prevent theme from loading
	}
add_action( 'template_redirect', 'ecfg_template_redirect_handler' );
	    
class ECFG_Events_Calendar_for_Google{
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	 
	public function __construct() {
		if ( defined( 'ECFG_VERSION' ) ) {
			$this->version = ECFG_VERSION;
		} else {
			$this->version = '3.2.1';
		}
		$this->plugin_name = 'events_calendar_google';

		$this->ecfg_load_dependencies();
		$this->ecfg_set_locale();
		$this->ecfg_load_admin_hooks();
		$this->ecfg_define_public_hooks();
		$this->ecfg_define_custom_hooks();
	
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ECFG_events_calendar_google_i18n. Defines internationalization functionality.
	 * - ECFG_events_calendar_google_Admin. Defines all hooks for the admin area.
	 * - ECFG_events_calendar_google_Public. Defines all hooks for the public side of the site.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function ecfg_load_dependencies() {

			
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		 
		require_once ECFG_PLUGIN_DIR . 'includes/class-events-calendar-for-google-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once ECFG_PLUGIN_DIR . 'admin/class-events-calendar-for-google-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once ECFG_PLUGIN_DIR . 'public/class-events-calendar-for-google-public.php';
		/**
		 * The class responsible for defining all custom actions and Hooks in the public-facing
		 * side of the site.
		 */
		
		require_once ECFG_PLUGIN_DIR . 'includes/class-ecfg-custom-hooks.php'; 
			
				

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ECFG_events_calendar_google_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function ecfg_set_locale() {

		$plugin_i18n = new ECFG_events_calendar_google_i18n();

		add_action( 'plugins_loaded', array($plugin_i18n, 'load_plugin_textdomain' ));

	}


	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function ecfg_load_admin_hooks() {
        
		$ECFG_events_admin = new ECFG_events_calendar_google_Admin( $this->get_plugin_name(), $this->get_version() );
		add_action( 'admin_enqueue_scripts', array($ECFG_events_admin, 'ECFG_admin_enqueue_styles' ));
		add_action( 'admin_enqueue_scripts', array($ECFG_events_admin, 'ECFG_admin_enqueue_scripts' ));
	 	add_filter( 'plugin_action_links_' .plugin_basename(__FILE__),array($ECFG_events_admin,'ECFG_admin_settings_link'));
		//add_action( 'admin_notices', array($ECFG_events_admin,'ECFG_plugin_notice' )); //shows plugins ratings bar
		add_action('admin_menu', array($ECFG_events_admin,'ECGF_custom_admin_menu')); /*Admin Menu on left dashboard*/
		/*needed to add menu again*/
		//add_action( 'admin_init', array( $ECFG_events_admin, 'ECFG_notice_actions' )); //remove rating bar once reveiwed
		add_action('admin_init', array($ECFG_events_admin,'ECFG_admin_settings_pages')); // including setting fields pages
    		
		/*including setting pages*/
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function ecfg_define_public_hooks() {

		$plugin_public = new ECFG_events_calendar_google_Public( $this->get_plugin_name(), $this->get_version() );

		add_action( 'wp_enqueue_scripts', array($plugin_public, 'ECFG_public_enqueue_styles' ));
		add_action( 'wp_enqueue_scripts', array($plugin_public, 'ECFG_public_enqueue_scripts' ));
		add_action( 'wp_footer',array($plugin_public,'ECFG_admin_footer_js'));
		add_shortcode( 'ECFG_calender_events', array( $plugin_public, 'ECFG_load_calender_events' ) );
		add_action( 'wp_ajax_nopriv_ECFG_advance_filter_search',array($plugin_public,'ECFG_advance_filter_search'));
		add_action( 'wp_ajax_ECFG_advance_filter_search',array($plugin_public,'ECFG_advance_filter_search'));
		add_action( 'wp_ajax_nopriv_ECFG_events_pagination',array($plugin_public,'ECFG_events_pagination'));
		add_action( 'wp_ajax_ECFG_events_pagination',array($plugin_public,'ECFG_events_pagination'));
		
	}
	
	/**
	 * Register all of the hooks related to the custom functionality
	 * of the plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	
	private function ecfg_define_custom_hooks() {
		$ecfg_hooks = new ECFG_Define_Custom_Hooks();
		add_action('ecfg_e_date', array($ecfg_hooks,'ecfg_e_date_function'),10,2);
		add_action('ecfg_e_title', array($ecfg_hooks,'ecfg_e_title_function'));
		add_action('ecfg_e_desc', array($ecfg_hooks,'ecfg_e_desc_function'));
		add_action('ecfg_e_location', array($ecfg_hooks,'ecfg_e_location_function'));		
		add_action('ecfg_e_time', array($ecfg_hooks,'ecfg_e_time_function'),10, 4);
		add_action('ecfg_e_more', array($ecfg_hooks,'ecfg_e_more_function'));
		add_action('ecfg_e_single_desc', array($ecfg_hooks,'ecfg_e_desc_single'),10,1);	
		
	}
	
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
$ECFG_plugin = new ECFG_Events_Calendar_for_Google();


