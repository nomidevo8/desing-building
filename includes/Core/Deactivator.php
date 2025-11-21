<?php
namespace BuildingDesigner\Core;

class Deactivator {
    
    public static function deactivate() {
        delete_transient('building_designer_activated');
        
        flush_rewrite_rules();
    }
}
