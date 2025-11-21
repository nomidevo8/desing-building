=== Building Designer Plugin ===
Contributors: buildingdesignerteam
Tags: building, designer, configurator, multi-step, form
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Multi-step building configuration UI with image-based option selection

== Description ==

Building Designer Plugin provides a comprehensive multi-step building configuration interface that allows users to customize and visualize building options in real-time.

**Features:**

* Multi-step configuration flow (7 steps)
* Image-based option selection
* Real-time visual updates
* Responsive design matching Menards theme
* PSR-4 compliant OOP architecture
* Extensible via hooks and filters
* Easy configuration through PHP config files

**Steps Included:**

1. Store Select
2. Building Size
3. Building Info
4. Accessories
5. Leans & Openings
6. Summary
7. Delivery

== Installation ==

1. Upload the `building-designer-plugin` folder to the `/wp-content/plugins/` directory
2. Run `composer install` in the plugin directory to generate autoloader
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Add the `[building_designer]` shortcode to any page or post

== Usage ==

**Basic Shortcode:**

`[building_designer]`

Simply add this shortcode to any page or post to display the building designer interface.

**Admin Settings:**

Navigate to "Building Designer" → "Settings" in the WordPress admin menu to configure plugin options.

== Customization ==

**Adding New Steps:**

Edit `includes/Config/Steps.php` and add a new step array:

```php
array(
    'id' => 'custom-step',
    'label' => 'Custom Step',
    'icon' => '',
    'order' => 8
)
```

**Adding Options to Steps:**

Edit `includes/Config/Options.php` and add options for your step:

```php
'custom-step' => array(
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
)
```

**Available Hooks:**

* `building_designer_register_steps` - Filter to modify steps array
* `building_designer_register_options` - Filter to modify options array
* `building_designer_selection_changed` - Action triggered when selection changes

**Example Usage:**

```php
add_filter('building_designer_register_steps', function($steps) {
    $steps[] = array(
        'id' => 'my-step',
        'label' => 'My Custom Step',
        'icon' => '',
        'order' => 10
    );
    return $steps;
});
```

**Changing Images:**

Replace the placeholder images in `assets/images/` with your own images, or update the image URLs in `includes/Config/Options.php`.

== Frequently Asked Questions ==

= How do I add the building designer to my site? =

Simply add the `[building_designer]` shortcode to any page or post.

= Can I customize the steps and options? =

Yes! Edit the files in `includes/Config/` to add or modify steps and options.

= How do I add my own images? =

Place your images in `assets/images/` and update the paths in `includes/Config/Options.php`.

= Is this plugin extensible? =

Absolutely! The plugin provides hooks and filters for developers to extend functionality.

== Screenshots ==

1. Multi-step building configuration interface
2. Image-based option selection
3. Admin settings page

== Changelog ==

= 1.0.0 =
* Initial release
* Multi-step configuration flow
* Image-based option selection
* PSR-4 compliant architecture
* Extensible hooks and filters

== Upgrade Notice ==

= 1.0.0 =
Initial release

== Developer Information ==

**Architecture:**

The plugin follows PSR-4 autoloading standards and uses an Object-Oriented Programming (OOP) structure.

**Directory Structure:**

* `includes/Core/` - Core plugin classes (Plugin, Loader, Activator, Deactivator)
* `includes/Admin/` - Admin interface classes (MenuManager, Settings)
* `includes/Frontend/` - Frontend classes (ShortcodeHandler, FormRenderer)
* `includes/Models/` - Data models (Step, Option)
* `includes/Config/` - Configuration files (Steps, Options)
* `assets/` - CSS, JavaScript, and image files

**Key Classes:**

* `BuildingDesigner\Core\Plugin` - Main plugin bootstrap class
* `BuildingDesigner\Frontend\ShortcodeHandler` - Handles shortcode registration
* `BuildingDesigner\Frontend\FormRenderer` - Renders the multi-step form

**Frontend JavaScript:**

The `assets/js/frontend.js` file contains modular functions:

* `initSteps()` - Initializes step navigation
* `bindEvents()` - Binds click and change events
* `updateRightPanel()` - Updates the image and description display
* `saveSelections()` - Persists user selections

All configuration is passed from PHP to JavaScript via `wp_localize_script()`.

== Support ==

For support, feature requests, or bug reports, please contact the plugin author.
