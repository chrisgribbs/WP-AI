<?php
/*
Plugin Name: WP-AI
Description: Basic AI-powered file upload plugin for WordPress. Initial version scaffold.
Version: 0.1.0
Author: chrisgribbs
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin constants
define( 'WPAI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Include admin settings
require_once WPAI_PLUGIN_DIR . 'includes/wpai-admin.php';

// Shortcode for upload form
function wpai_upload_form_shortcode() {
    if ( ! is_user_logged_in() ) {
        return '<p>You must be logged in to upload files.</p>';
    }

    ob_start();
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="wpai_file" required>
        <?php wp_nonce_field('wpai_upload_action', 'wpai_nonce'); ?>
        <input type="submit" name="wpai_upload_submit" value="Upload File">
    </form>
    <?php

    // Handle form submission
    if ( isset($_POST['wpai_upload_submit']) && isset($_FILES['wpai_file']) ) {
        if ( ! wp_verify_nonce( $_POST['wpai_nonce'], 'wpai_upload_action' ) ) {
            echo '<p>Security check failed.</p>';
            return ob_get_clean();
        }

        $file = $_FILES['wpai_file'];
        $upload = wp_handle_upload( $file, array('test_form' => false) );
        if ( isset($upload['url']) ) {
            echo '<p>File uploaded: <a href="' . esc_url($upload['url']) . '">' . esc_html($file['name']) . '</a></p>';
        } else {
            echo '<p>Upload failed.</p>';
        }
    }

    return ob_get_clean();
}
add_shortcode('wpai_upload_form', 'wpai_upload_form_shortcode');

// Activation hook
function wpai_activate() { /* Future: setup options, DB */ }
register_activation_hook(__FILE__, 'wpai_activate');
