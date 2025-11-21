<?php
namespace BuildingDesigner\Frontend;

class FormRenderer {
    
    public function render($atts) {
        ob_start();
        ?>
        <div id="building-designer-container" class="building-designer">
            <div class="bd-header">
                <div class="bd-branding">
                    <span class="bd-brand">Design&Buy</span>
                    <span class="bd-location">at SERVTECH</span>
                </div>
                <div class="bd-steps-nav">
                    <button class="bd-step-btn" data-step="store-select">Store Select</button>
                    <button class="bd-step-btn active" data-step="building-size">Building Size</button>
                    <button class="bd-step-btn" data-step="building-info">Building Info</button>
                    <button class="bd-step-btn" data-step="accessories">Accessories</button>
                    <button class="bd-step-btn" data-step="leans-openings">Leans & Openings</button>
                    <button class="bd-step-btn" data-step="summary">Summary</button>
                    <button class="bd-step-btn" data-step="delivery">Delivery</button>
                </div>
                <div class="bd-header-actions">
                    <button class="bd-faq-btn">FAQ</button>
                    <button class="bd-login-btn">
                        <span class="dashicons dashicons-admin-users"></span> Log In
                    </button>
                </div>
            </div>

            <div class="bd-content">
                <div class="bd-sidebar">
                    <div id="bd-options-container">
                    </div>
                </div>

                <div class="bd-main">
                    <div class="bd-info-notice">
                        <p>Please fill in Width, Truss Spacing, Length, and Height to get a price.</p>
                    </div>

                    <div class="bd-tabs">
                        <button class="bd-tab-btn active" data-tab="information">Information</button>
                        <button class="bd-tab-btn" data-tab="3d-scene">3D Scene</button>
                    </div>

                    <div class="bd-tab-content">
                        <div id="bd-info-display" class="bd-info-display">
                            <h2 id="bd-current-title">Select an option to see details</h2>
                            <div id="bd-images-container" class="bd-images-container">
                            </div>
                            <div id="bd-description-container" class="bd-description-container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bd-footer">
                <button id="bd-back-btn" class="bd-btn bd-btn-back">Back</button>
                <div class="bd-footer-info">
                    <small>CFFrameType - v4.9.92-SNAPSHOT<br>&copy;2004-2025 Menards Inc/wright.Rights Reserved</small>
                </div>
                <button id="bd-continue-btn" class="bd-btn bd-btn-continue">Continue</button>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function ajax_save_selection() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'building_designer_nonce')) {
            wp_send_json_error(array('message' => 'Invalid security token'), 403);
            return;
        }
        
        if (!isset($_POST['selections'])) {
            wp_send_json_error(array('message' => 'No selections provided'), 400);
            return;
        }
        
        $selections = json_decode(stripslashes($_POST['selections']), true);
        
        if (!is_array($selections)) {
            wp_send_json_error(array('message' => 'Invalid selections format'), 400);
            return;
        }
        
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            update_user_meta($user_id, 'building_designer_selections', $selections);
        } else {
            if (!session_id()) {
                session_start();
            }
            $_SESSION['building_designer_selections'] = $selections;
        }
        
        do_action('building_designer_selection_changed', $selections);
        
        wp_send_json_success(array(
            'message' => 'Selections saved successfully',
            'selections' => $selections
        ));
    }
}
