<?php
namespace BuildingDesigner\Core;

class Activator {
    
    public static function activate() {
        $default_settings = array(
            'steps' => \BuildingDesigner\Config\Steps::get_steps(),
            'options' => \BuildingDesigner\Config\Options::get_options()
        );
        
        if (!get_option('building_designer_settings')) {
            add_option('building_designer_settings', $default_settings);
        }
        
        set_transient('building_designer_activated', true, 30);
        
        flush_rewrite_rules();
    }
}
