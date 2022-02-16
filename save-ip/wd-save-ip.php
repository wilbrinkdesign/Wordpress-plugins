<?php
/**
 * Plugin Name: Save client IP
 * Plugin URI: https://wilbrink.design
 * Description: Save client IP to the Wordpress database.
 * Version: 1.0
 * Author: Wilbrink Design
 * Author URI: https://wilbrink.design
 */

// Retrieving an Option from the Database using get_option
get_option('wd_ip_client', 'WD Client IP');

// Update a saved database option using the update_option routine
update_option('wd_ip_client', $_SERVER['REMOTE_ADDR'], 'yes');