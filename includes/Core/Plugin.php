<?php
namespace BuildingDesigner\Core;

use BuildingDesigner\Admin\MenuManager;
use BuildingDesigner\Admin\Settings;
use BuildingDesigner\Frontend\ShortcodeHandler;

class Plugin {
    
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'building-designer-plugin';
        $this->version = '1.0.0';
        
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_frontend_hooks();
    }

    private function load_dependencies() {
        $this->loader = new Loader();
    }

    private function define_admin_hooks() {
        $menu_manager = new MenuManager();
        $settings = new Settings();
        
        $this->loader->add_action('admin_menu', $menu_manager, 'add_menu_items');
        $this->loader->add_action('admin_init', $settings, 'register_settings');
        $this->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_admin_assets');
    }

    private function define_frontend_hooks() {
        $shortcode_handler = new ShortcodeHandler();
        $form_renderer = new \BuildingDesigner\Frontend\FormRenderer();
        
        $this->loader->add_action('init', $shortcode_handler, 'register_shortcode');
        $this->loader->add_action('wp_enqueue_scripts', $this, 'enqueue_frontend_assets');
        
        $this->loader->add_action('wp_ajax_building_designer_save_selection', $form_renderer, 'ajax_save_selection');
        $this->loader->add_action('wp_ajax_nopriv_building_designer_save_selection', $form_renderer, 'ajax_save_selection');
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'building-designer') === false) {
            return;
        }
        
        if (defined('BUILDING_DESIGNER_PLUGIN_FILE')) {
            $plugin_url = plugin_dir_url(BUILDING_DESIGNER_PLUGIN_FILE);
        } else {
            $plugin_url = plugin_dir_url(__FILE__) . '../../';
        }
        
        wp_enqueue_style(
            $this->plugin_name . '-admin',
            $plugin_url . 'assets/css/admin.css',
            array(),
            $this->version
        );
        
        wp_enqueue_script(
            $this->plugin_name . '-admin',
            $plugin_url . 'assets/js/admin.js',
            array('jquery'),
            $this->version,
            true
        );
    }

    public function enqueue_frontend_assets() {
        if (defined('BUILDING_DESIGNER_PLUGIN_FILE')) {
            $plugin_url = plugin_dir_url(BUILDING_DESIGNER_PLUGIN_FILE);
        } else {
            $plugin_url = plugin_dir_url(__FILE__) . '../../';
        }
        
        wp_enqueue_style(
            $this->plugin_name . '-frontend',
            $plugin_url . 'assets/css/frontend.css',
            array(),
            $this->version
        );
        
        wp_enqueue_script(
            $this->plugin_name . '-frontend',
            $plugin_url . 'assets/js/frontend.js',
            array('jquery'),
            $this->version,
            true
        );
        
        $steps_config = \BuildingDesigner\Config\Steps::get_steps();
        $options_config = \BuildingDesigner\Config\Options::get_options();
        
        $steps_config = apply_filters('building_designer_register_steps', $steps_config);
        $options_config = apply_filters('building_designer_register_options', $options_config);
        
        wp_localize_script(
            $this->plugin_name . '-frontend',
            'buildingDesignerConfig',
            array(
                'steps' => $steps_config,
                'options' => $options_config,
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('building_designer_nonce')
            )
        );
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}
