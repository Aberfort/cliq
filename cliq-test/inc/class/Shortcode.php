<?php
/**
 * The plugin's main class
 *
 */

// Exits if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}


class Shortcode {

  /**
   * Initializes our plugin
   */
  public function init() {
    $this->load_hooks();
  }

  /**
   * Adds in any plugin-wide hooks
   *
   */
  public function load_hooks() {
    add_action( 'init', array( $this, 'shortcode_set' ) );
    add_action( 'admin_init', array( $this, 'settings_page' ) );
    add_action( "admin_menu", array( $this, 'menu_item' ) );
    add_action( 'wp_footer', array( $this, 'reports_admin_scripts' ) );
  }

  /**
   * Sets up our page in the admin menu
   *
   */
  public function menu_item() {
    add_submenu_page(
      'options-general.php',
      'Shortcode checker',
      'Shortcode checker',
      'manage_options',
      'shortcode-checker',
      array(
        $this,
        'generate_admin_page'
      ) );
  }

  /**
   * Generates our admin page
   *
   */
  public function generate_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }

    require_once PR_PLUGIN_DIR . 'views/form.php';
  }

  public function settings_page() {

    add_settings_section( "section", "Checkbox", null, "shortcode-checker" );

    $option_name = 'true_option';

    register_setting(
      'section',
      $option_name,
      array( 'sanitize_callback' => array( $this, 'true_sanitize_checkbox' ) )
    );

    add_settings_field(
      $option_name,
      'Enable shortcode',
      array( $this, 'true_option_callback' ),
      'shortcode-checker',
      'section',
      array(
        'name'       => $option_name,
        'label_text' => 'Enable this option'
      )
    );
  }

  public function true_sanitize_checkbox( $value ) {
    return ( 'on' == $value ) ? 'yes' : 'no';
  }

  public function true_option_callback( $args ) {

    printf(
      '<label for="%s-id"><input type="checkbox" name="%s" id="%s-id" %s> %s</label>',
      $args['name'],
      $args['name'],
      $args['name'],
      checked( get_option( $args['name'] ), 'yes', false ),
      $args['label_text']
    );
  }

  /**
   * Add css and scripts
   *
   */
  public function reports_admin_scripts() {
    // # load style
    wp_enqueue_style( 'styles', PR_PLUGIN_URL . 'assets/dist/css/main.min.css' );

    // # load scripts
    wp_enqueue_script( 'scripts', PR_PLUGIN_URL . 'assets/dist/js/main.min.js' );
  }

  function wp_demo_shortcode() {
    require_once PR_PLUGIN_DIR . 'views/shortcode.php';
  }

  function shortcode_set() {
    if ( get_option( 'true_option' ) == 'yes' ) {
      add_shortcode( 'tbare-plugin-demo', array( $this, 'wp_demo_shortcode' ) );
    }
  }
}
