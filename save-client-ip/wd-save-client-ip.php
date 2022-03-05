<?php
/**
 * Plugin Name: Save client IPs
 * Plugin URI: https://wilbrink.design
 * Description: Save client IPs to the Wordpress database.
 * Version: 1.0
 * Author: Wilbrink Design
 * Author URI: https://wilbrink.design
 */

// Create sql table
function wd_ip_install() 
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'ip_clients';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        datum datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        ip tinytext NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Add data to the sql table
function wd_ip_data() 
{
    global $wpdb;
    
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $table_name = $wpdb->prefix . 'ip_clients';
    
    $wpdb->insert( 
        $table_name, 
        array( 
            'datum' => current_time('mysql'), 
            'ip' => $ip, 
        ) 
    );
}

// Call functions
wd_ip_install();
wd_ip_data();

// Plugin menu
function wd_ips_client_menu()
{
    add_options_page('Client IPs', 'Client IPs', 'manage_options', 'wd-client-ips', 'wd_client_ips_page'); // Create menu option in Settings
}

add_action('admin_menu', 'wd_ips_client_menu'); // Add to the menu

// Settings page
function wd_client_ips_page()
{ 
    ?>

    <div class='wrap'>
        <!-- <h1><?php echo "Last known IP: ".get_option('wd_ip_client').""; ?></h1> -->
    </div>
    <?php
}

// Settings link
function wd_client_ips_link($links) 
{
    $links[] = '<a href="'.admin_url( 'options-general.php?page=wd-client-ips' ).'">'.__('Settings').'</a>';
    
    return $links;
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wd_client_ips_link');