<?php
		register_setting('gc_general_settings', 'gc_general_settings');//Register Settings of general section
		add_settings_section(
        'general_settings_block', // Refering to the general settings section of plugin 
        '',           // No Title
        '', // No Description
        'ecfg_general_settings'              // Page slug
        );  
		
		// Add Google API Key field to Above section
		add_settings_field(
			'gc_events_api_key',
			'Google Api Key',
			'gc_events_api_key_callback',
			'ecfg_general_settings',//page Slug
			'general_settings_block', // Refering to the general settings section of plugin 
			array(
				'label_for' => 'gc_general_settings[gc_events_api_key]',
				'class'     => 'gc_row',
			)
		);

		// Add Google Calendar ID field
		add_settings_field(
			'gc_calender_id',
			'Google Calendar ID',
			'gc_calender_id_callback',
			'ecfg_general_settings', //page slug
			'general_settings_block',
			array(
				'label_for' => 'gc_general_settings[gc_calender_id]',
				'class'     => 'gc_row',
			)
		);

		// Add Events Layout field
		add_settings_field(
			'gc_calender_layout',
			'Select Events Layouts',
			'gc_calender_layout_callback',
			'ecfg_general_settings', //page slug
			'general_settings_block',
			array(
				'label_for' => 'gc_general_settings[gc_calender_layout]',
				'class'     => 'gc_row',
			)
		);

		// Add Shortcode info
		add_settings_field(
			'gc_shortcode',
			'Use Below Shortcode On any Page/Post',
			'gc_shortcode_callback',
			'ecfg_general_settings', //page slug
			'general_settings_block',
			array(
				'label_for' => 'gc_shortcode',
				'class'     => 'gc_row',
			)
		);
		
		
		
		/*Create a section for event attribute for submenu2 page*/
		register_setting( 'gc_event_attributes', 'gc_event_attributes'); //Register settings of attrribute section
		        
		 add_settings_section(
        'event_attributes_block',
        '',
        '',
        'ecfg_event_attributes' //Page slug for event attributes
         ); /*create a setting for basic event attributes*/
		 
		
        /*settings fields for event attributes*/
		
		
		$event_attr_fields = array(
        'gc-event-attribute-title'       => 'Event Title',
        'gc-event-attribute-description' => 'Event Description',
        'gc-event-attribute-location'    => 'Event Location',
		'gc-event-attribute-timezome'    => 'Event Timezone',
        'gc-event-attribute-readmore'    => 'Read More Link',
        );

		foreach ( $event_attr_fields as $id => $label ) {
			// Add fields to the general settings section
			add_settings_field(
				$id,
				$label,
				'gc_event_attribute_fields_callback',
				'ecfg_event_attributes',
				'event_attributes_block',
				array(
					'id' => $id,
					'label' => $label,
				)
			);
		}
		
		/* Register advance setting section */
		 register_setting('gc_advanced_settings', 'gc_advanced_settings');
		 
		  // Add sections
		//date section and fields declaration
		add_settings_section(
			'gc_date_section_style',
			'Events Date Section',
			 null,
			'ecfg_advanced_settings'
		);

		// Add fields for Date Section
		add_settings_field(
			'date_design',//field id 
			'',
			'ecfg_date_design_field_callback',
			'ecfg_advanced_settings',//page slug
			'gc_date_section_style',//nested inside
			array(
				'label_for' => 'gc_advanced_settings[date_design]',
				'class'     => 'gc_row',
			)
		);
		
		
		//add settings section and fields accordingly 
			add_settings_section(
					'gc_event_desc_section',
					'Events Details/Description Section',
					null,
					'ecfg_advanced_settings'
				);
				// Add fields for description Section
		add_settings_field(
			'description_design',//field id 
			'Select description Section Style',
			'ecfg_event_desc_section_fields_callback',
			'ecfg_advanced_settings',//page slug
			'gc_event_desc_section'//nested inside
		);

	  	add_settings_section(
					'gc_button_style_section',
					'Buttons Style / Calendar View style',
					null,
					'ecfg_advanced_settings'
				);
		
		add_settings_field(
        'gc_button_style',
        'Buttons Style',
        'ecfg_button_style_section_fields_callback',
        'ecfg_advanced_settings',//page slug
        'gc_button_style_section' //nested inside
        );		
		
		// Pagination Section
		add_settings_section(
			'gc_pagination_section',
			'Pagination/Load More',
			null,
			'ecfg_advanced_settings'
		);

		add_settings_field(
			'pagination',
			'Pagination',
			'ecfg_pagination_section_fields_callback',
			'ecfg_advanced_settings',//page slug
			'gc_pagination_section' //nested inside section
		);

		// Timezone Section
		add_settings_section(
			'gc_timezone_section',
			'Event Timezone Settings',
			null,
			'ecfg_advanced_settings'
		);

		add_settings_field(
			'timezone',
			'Timezone',
			'ecfg_timezone_section_fields_callback',
			'ecfg_advanced_settings',
			'gc_timezone_section'
		);
		
		//pro features page
         register_setting('gc_pro_features', 'gc_pro_features');
		 
		 add_settings_section(
        'gc_pro_features_section', // Section ID
        '', // Title
        null, // Callback
        'ecfg_pro_features' // Page slug
    );

    // Add the field to display the HTML content
    add_settings_field(
        'gc_pro_link', // Field ID
        '', // Title (empty because it's an HTML block)
        'ecfg_pro_features_field_callback', // Callback function
        'ecfg_pro_features', // Page slug
        'gc_pro_features_section' // Section ID
    );
        
		