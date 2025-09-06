<?php
// Admin settings page (stub for future extension)
function wpai_admin_menu() {
    add_options_page(
        'WP-AI Settings',
        'WP-AI',
        'manage_options',
        'wpai-settings',
        'wpai_settings_page'
    );
}
add_action('admin_menu', 'wpai_admin_menu');

function wpai_settings_page() {
    ?>
    <div class="wrap">
        <h1>WP-AI Settings</h1>
        <p>Initial version—settings coming soon.</p>
    </div>
    <?php
}
