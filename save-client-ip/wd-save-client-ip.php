<?php
/**
 * Plugin Name: Save client IP
 * Plugin URI: https://wilbrink.design
 * Description: Save client IP to the Wordpress database.
 * Version: 1.0
 * Author: Wilbrink Design
 * Author URI: https://wilbrink.design
 */

// Retrieving an option from the database
get_option('wd_ip_client', 'WD Client IP');

// Update a saved database option
update_option('wd_ip_client', $_SERVER['REMOTE_ADDR'], 'yes');

// Plugin menu
function wd_ip_client_menu()
{
    add_options_page('Client IP', 'Client IP', 'manage_options', 'wd-client-ip', 'wd_client_ip_page'); // Create menu option in Settings
    add_action('admin_init', 'wd_ip_client_db'); // Register input fields voor database
}

add_action('admin_menu', 'wd_ip_client_menu'); // Add to the menu

// Plugin settings for database
function wd_ip_client_db()
{
    register_setting( 'pluginPage', 'wd_ip_client' ); // Register input fields, only these fields you can use
}

// Settings page
function wd_client_ip_page()
{ 
    echo "Last known client IP: " . get_option('wd_ip_client');    
}

// Settings link
function wd_client_ip_link($links) 
{
    $links[] = '<a href="'.admin_url( 'options-general.php?page=wd-client-ip' ).'">'.__('Settings').'</a>';
    
    return $links;
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wd_client_ip_link');