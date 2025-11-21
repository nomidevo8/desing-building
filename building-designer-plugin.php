<?php
/**
 * Plugin Name: Building Designer Plugin
 * Plugin URI: https://example.com/building-designer
 * Description: Multi-step building configuration UI with image-based option selection
 * Version: 1.0.0
 * Author: Building Designer Team
 * Author URI: https://example.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: building-designer
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BUILDING_DESIGNER_VERSION', '1.0.0');
define('BUILDING_DESIGNER_PLUGIN_FILE', __FILE__);
define('BUILDING_DESIGNER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BUILDING_DESIGNER_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once BUILDING_DESIGNER_PLUGIN_DIR . 'vendor/autoload.php';

use BuildingDesigner\Core\Plugin;
use BuildingDesigner\Core\Activator;
use BuildingDesigner\Core\Deactivator;

function activate_building_designer() {
    Activator::activate();
}

function deactivate_building_designer() {
    Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_building_designer');
register_deactivation_hook(__FILE__, 'deactivate_building_designer');

function run_building_designer() {
    $plugin = new Plugin();
    $plugin->run();
}

run_building_designer();
