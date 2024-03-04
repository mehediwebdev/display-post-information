<?php
/*
 * Plugin Name:       WP Post Information
 * Plugin URI:        
 * Description:       WP Post Information is an essential plugin for website owner, it shows word count, characters and the reading time.
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      7.2
 * Author:            Mehedi Hasan
 * Author URI:        
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        
 * Text Domain:       wp-post-information
 * Domain Path:       /languages
 */

 if( ! defined('ABSPATH') ){
    die;
}

if( ! class_exists( 'WPI_WP_Post_Information' ) ){
  class WPI_WP_Post_Information{
    function __construct(){
        $this->define_constant();
        $this->load_textdomain();
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

        require_once( WP_POST_INFORMATION_PATH . 'class.wp-post-info-settings.php' );
        $wpi_wp_post_info_settings = new WPI_WP_Post_Info_Settings();

        require_once( WP_POST_INFORMATION_PATH . 'public/class.wp-post-info-views.php' );
        $wpi_wp_post_info_views = new WPI_WP_Post_Info_Views();
    }
    public function define_constant(){
       define( 'WP_POST_INFORMATION_PATH', plugin_dir_path( __FILE__ ) );
       define( 'WP_POST_INFORMATION_URL', plugin_dir_url( __FILE__ ) );
       define( 'WP_POST_INFORMATION_VERSION', '1.0.0' );
    }
    public static function activate(){
		update_option( 'rewrite_rules', '' );
    }

    public static function deactivate(){
      flush_rewrite_rules();
    }
   public static function uninstall(){
      delete_option( 'wp_post_information_options');
   }
   public function load_textdomain(){
     load_plugin_textdomain(
      'wp-post-information',
      false,
      dirname( plugin_basename( __FILE__ ) ) . '/languages/'
     );
   }
   public function admin_menu(){
      add_options_page(
         'WP Post Information Settings',   // Page title
         'WP Post Information',            // Menu title
         'manage_options',                 // Capability
         'wp-post-information-settings',   // Menu slug
         array($this, 'create_admin_settings') // Callback function to render the settings page
     );
   }

   public function create_admin_settings(){
    require( WP_POST_INFORMATION_PATH . 'views/settings-page.php' );
   }

  }
}

if( class_exists( 'WPI_WP_Post_Information' ) ){

   register_activation_hook( __FILE__, array( 'WPI_WP_Post_Information', 'activate') );
   register_deactivation_hook( __FILE__, array( 'WPI_WP_Post_Information', 'deactivate') );
   register_uninstall_hook( __FILE__, array( 'WPI_WP_Post_Information', 'uninstall') );

   $wpi_wp_post_information = new WPI_WP_Post_Information();
}