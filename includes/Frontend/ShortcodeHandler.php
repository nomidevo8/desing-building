<?php
namespace BuildingDesigner\Frontend;

class ShortcodeHandler {
    
    public function register_shortcode() {
        add_shortcode('building_designer', array($this, 'render_shortcode'));
    }

    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'step' => 'building-size'
        ), $atts);
        
        $renderer = new FormRenderer();
        return $renderer->render($atts);
    }
}
