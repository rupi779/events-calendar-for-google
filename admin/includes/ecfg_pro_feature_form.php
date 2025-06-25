<?php
function ECFG_pro_features_page() {
    ?>
    <div class="wrap">
        <form method="post" class="gc_pro_page" action="options.php">
            <?php
            settings_fields('gc_pro_features');
            do_settings_sections('ecfg_pro_features');
            ?>
        </form>
    </div>
    <?php
}
function ecfg_pro_features_field_callback() {
    $search = plugin_dir_url(dirname(__FILE__)) . 'pro-advance-search.png';
    $image = plugin_dir_url(dirname(__FILE__)) . 'pro-features.png';
    

    echo '<div class="gc_pro_banner">
                <div class="gc_pro_link">
                    <a target="_blank" href="https://blueplugins.com/events-calendar-for-google-pro/" class="try_pro">Try Pro Version</a>
                </div>
				<img class="p_details" src="' . esc_url($search) . '">
                <img class="p_details" src="' . esc_url($image) . '"> 
                
                <div class="gc_pro_link">
                    <a target="_blank" href="https://blueplugins.com/events-calendar-for-google-pro/" class="try_pro">Try Pro Version</a>
                </div>
             </div>';

   
}

