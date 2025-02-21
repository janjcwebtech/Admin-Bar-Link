<?php
/**
 * Plugin Name: Admin Bar Link
 * Description: Adds a link to the Theme Editor (global CSS) in the WordPress admin bar and removes specific links like Comments and Rank Math.
 * Version: 1.1
 * Author: JC
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class AdminBarLink {

    public function __construct() {
        add_action('admin_bar_menu', [$this, 'add_theme_editor_link'], 100);
        add_action('admin_bar_menu', [$this, 'remove_unwanted_links'], 99);
        add_action('wp_enqueue_scripts', [$this, 'ensure_admin_bar_shows'], 1);
    }

    public function add_theme_editor_link($wp_admin_bar) {
        // Add a new link to the admin bar
        $wp_admin_bar->add_node([
            'id'    => 'theme-editor-link',
            'title' => 'Global CSS',
            'href'  => admin_url('theme-editor.php'),
        ]);
    }

    public function remove_unwanted_links($wp_admin_bar) {
        // Remove Comments link
        $wp_admin_bar->remove_node('comments');

        // Remove Rank Math link if present
        $wp_admin_bar->remove_node('rank-math');
    }

    public function ensure_admin_bar_shows() {
        if (is_user_logged_in() && current_user_can('edit_theme_options')) {
            show_admin_bar(true);
        }
    }
}

new AdminBarLink();
