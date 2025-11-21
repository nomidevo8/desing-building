<?php
namespace BuildingDesigner\Admin;

class MenuManager {
    
    public function add_menu_items() {
        add_menu_page(
            'Building Designer',
            'Building Designer',
            'manage_options',
            'building-designer',
            array($this, 'render_main_page'),
            'dashicons-admin-home',
            30
        );
        
        add_submenu_page(
            'building-designer',
            'Settings',
            'Settings',
            'manage_options',
            'building-designer-settings',
            array($this, 'render_settings_page')
        );
    }

    public function render_main_page() {
        ?>
        <div class="wrap">
            <h1>Building Designer</h1>
            <div class="card">
                <h2>Welcome to Building Designer Plugin</h2>
                <p>Use the <code>[building_designer]</code> shortcode to display the building configuration form on any page or post.</p>
                <h3>Features:</h3>
                <ul>
                    <li>Multi-step building configuration interface</li>
                    <li>Image-based option selection</li>
                    <li>Responsive design matching Menards theme</li>
                    <li>Extensible via hooks and filters</li>
                </ul>
                <h3>Quick Start:</h3>
                <ol>
                    <li>Create a new page or post</li>
                    <li>Add the shortcode: <code>[building_designer]</code></li>
                    <li>Publish and view the page</li>
                </ol>
                <p>
                    <a href="<?php echo admin_url('admin.php?page=building-designer-settings'); ?>" class="button button-primary">
                        Configure Settings
                    </a>
                </p>
            </div>
        </div>
        <?php
    }

    public function render_settings_page() {
        $settings = new Settings();
        $settings->render_page();
    }
}
