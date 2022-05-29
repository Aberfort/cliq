<?php
/**
 * Plugin Name: Cliq test plugin
 * Description: Shortcode checker
 * Author:      Vasyliev Serhii
 * Version:     1.0.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

define('PR_PLUGIN_URL', plugin_dir_url(__FILE__));
define( 'PR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

spl_autoload_register( function ( $class ) {
  $cl = 'inc/class/' . $class . '.php';
  include $cl;
} );

$shortcode = new Shortcode();
$shortcode->init();