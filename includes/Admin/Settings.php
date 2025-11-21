<?php
namespace BuildingDesigner\Admin;

class Settings {
    
    public function register_settings() {
        register_setting(
            'building_designer_settings_group',
            'building_designer_settings',
            array($this, 'sanitize_settings')
        );
        
        add_settings_section(
            'building_designer_main_section',
            'Plugin Configuration',
            array($this, 'render_section_info'),
            'building-designer-settings'
        );
        
        add_settings_field(
            'building_designer_enabled',
            'Enable Plugin',
            array($this, 'render_enabled_field'),
            'building-designer-settings',
            'building_designer_main_section'
        );
    }

    public function sanitize_settings($input) {
        $sanitized = array();
        
        if (isset($input['enabled'])) {
            $sanitized['enabled'] = sanitize_text_field($input['enabled']);
        }
        
        if (isset($input['steps'])) {
            $sanitized['steps'] = $input['steps'];
        }
        
        if (isset($input['options'])) {
            $sanitized['options'] = $input['options'];
        }
        
        return $sanitized;
    }

    public function render_section_info() {
        echo '<p>Configure the Building Designer plugin settings below. Steps and options are managed in <code>includes/Config/</code> files.</p>';
    }

    public function render_enabled_field() {
        $settings = get_option('building_designer_settings', array('enabled' => '1'));
        $enabled = isset($settings['enabled']) ? $settings['enabled'] : '1';
        ?>
        <label>
            <input type="checkbox" name="building_designer_settings[enabled]" value="1" <?php checked($enabled, '1'); ?> />
            Enable building designer shortcode
        </label>
        <?php
    }

    public function render_page() {
        ?>
        <div class="wrap">
            <h1>Building Designer Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('building_designer_settings_group');
                do_settings_sections('building-designer-settings');
                submit_button();
                ?>
            </form>
            
            <div class="card">
                <h2>Managing Steps and Options</h2>
                <p>Steps are configured in: <code>includes/Config/Steps.php</code></p>
                <p>Options are configured in: <code>includes/Config/Options.php</code></p>
                
                <h3>How to Add a New Step:</h3>
                <pre><code>array(
    'id' => 'custom-step',
    'label' => 'Custom Step',
    'icon' => '',
    'order' => 8
)</code></pre>
                
                <h3>How to Add Options to a Step:</h3>
                <pre><code>'custom-step' => array(
    'custom-option' => array(
        'id' => 'custom-option',
        'label' => 'Custom Option',
        'question' => 'Choose your option',
        'type' => 'select',
        'options' => array(
            array(
                'id' => 'option1',
                'label' => 'Option 1',
                'image_url' => 'path/to/image.jpg',
                'description' => 'Description here'
            )
        )
    )
)</code></pre>

                <h3>Available Hooks:</h3>
                <ul>
                    <li><code>building_designer_register_steps</code> - Filter to modify steps</li>
                    <li><code>building_designer_register_options</code> - Filter to modify options</li>
                    <li><code>building_designer_selection_changed</code> - Action when selection changes</li>
                </ul>
            </div>
        </div>
        <?php
    }
}
