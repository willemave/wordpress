<?php
/*
Plugin Name: BookFresh
Plugin URI: http://bookfresh.com
Description: 1. Click the "Activate" link to the left  2. Sign up for a <a href="https://www.bookfresh.com/pricing/" target="_blank">BookFresh Account</a> 3. Go to your Wordpress BookFresh Plugin configuration page, and save login information.
Version: 1.0
Author: BookFresh
Author URI: http://www.bookfresh.com
Text Domain: www.bookfresh.com
*/

/*  Copyright 2012  Willem Ave (email : support@bookfresh.com)
    Commercial license please review http://www.bookfresh.com/security/terms-of-use
*/



require_once( dirname(__FILE__) . '/includes/class-dbmethods.php' );
require_once( dirname(__FILE__) . '/includes/class-pluginmethods.php' );
require_once( dirname(__FILE__) . '/admin/settings.php' );
require_once( dirname(__FILE__) . '/bf-config.php' );

if(!class_exists('BookFresh')){

	class BookFresh extends BF_PluginMethods {

		public function __construct(){
			parent::__construct();
		}

		/* Runs plugin activation routines
		 *
		 */
		public function plugin_activation() {
			//$this->CreateBookfreshTables();
		}

		/* Runs plugin deactivation routines
		 *
		 */
		public function plugin_deactivation(){
			return; // Add some deactivation method
		}

		/* Builds the admin menus
		 *
		 */
		public function admin_menus() {
			$page = $this->bf_add_menu_page('BookFresh', 'BookFresh', 8, 'bookfresh', array($this, 'create_menus'), $this->bf_plugins_url('/images/logo-icon.png', __FILE__));
			$this->bf_add_action('admin_print_styles-' . $page, array($this, 'load_admin_styles'), 10, '');
		}

		public function create_menus(){
			$this->dashboard();
		}

		/* Loads the admin stylesheets
		 *
		 */
		public function load_admin_styles() {						
			$this->bf_enqueue_style('bf_admin', $this->bf_plugins_url('/css/admin-style.css', __FILE__));
		}

		public function add_widget_large(){
			return $this->bf_widget_large();
		}

		public function add_widget_small(){
			return $this->bf_widget_small();
		}

		public function add_button_booknow(){
			return $this->bf_booknow_button();
		}

		public function load_js() {
			if(is_admin()){
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-validate','http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js');
				wp_enqueue_script('bf_admin_js', $this->bf_plugins_url('/js/bf_admin.js', __FILE__));
				wp_localize_script('bf_admin_js', 'ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
				wp_localize_script('bf_admin_js', 'bf_nonce', array('nonce' => wp_create_nonce('bf_ajax-nonce')));
				wp_localize_script('bf_admin_js', 'bf_api_url', array('url' => BF_API_URL));
				
				// tempory path for jsonp sample call
				wp_localize_script('bf_admin_js', 'jsonp', array( 'url' => $this->bf_plugins_url('/includes/json.php', __FILE__)));
			}
		}

		public function bf_member(){
			$nonce = $_POST['bf_nonce'];
			// check to see if the submitted nonce matches with the
		    // generated nonce we created earlier
		    if (!wp_verify_nonce( $nonce, 'bf_ajax-nonce' )){
		        die();
			}

			$data['email'] = $_POST['email'];
			$data['service_id'] = $_POST['service_id'];
			
			$this->SaveOption('bf_account_settings', $data);
			die();
		}

		public function bf_delete(){
			$nonce = $_POST['bf_nonce'];
		    if (!wp_verify_nonce( $nonce, 'bf_ajax-nonce' )){
		        die();
			}
			$this->DeleteOption('bf_account_settings');
			die();
		}
	}

	$BFInstance = new Bookfresh();
	
	//Hooks
	$BFInstance->bf_register_activation_hook( __FILE__, array($BFInstance, 'plugin_activation' ));
	$BFInstance->bf_register_deactivation_hook( __FILE__, array($BFInstance, 'plugin_deactivation'));

	//Actions
	$BFInstance->bf_add_action('init', array($BFInstance, 'load_js'));
	$BFInstance->bf_add_action('wp_ajax_bf_member', array($BFInstance, 'bf_member'));
	$BFInstance->bf_add_action('wp_ajax_bf_delete', array($BFInstance, 'bf_delete'));
	$BFInstance->bf_add_action('admin_menu', array($BFInstance, 'admin_menus'), 10, '');


	//Shortcodes
	add_shortcode('bookfresh_widget_large', array($BFInstance, 'add_widget_large'));
	add_shortcode('bookfresh_widget_small', array($BFInstance, 'add_widget_small'));
	add_shortcode('bookfresh_booknow_button', array($BFInstance, 'add_button_booknow'));
	
}
?>
