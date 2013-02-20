<?php
/*
Plugin Name: BookFresh
Plugin URI: http://bookfresh.com
Description: 1. Click the "Activate" link to the left  2. Sign up for a <a href="https://www.bookfresh.com/pricing/" target="_blank">BookFresh Account</a> 3. Go to your Wordpress BookFresh Plugin configuration page, and save login information.
Version: 1.1
Author: BookFresh
Author URI: http://www.bookfresh.com
Text Domain: www.bookfresh.com
License: http://www.bookfresh.com/security/terms-of-use
*/

require_once( dirname(__FILE__) . '/bf-config.php' );

if(!class_exists('BookFresh')){

	class BookFresh {
	
		//Runs plugin deactivation routines
		public function plugin_deactivation(){
			delete_option('bf_account_settings');
		}

		//Builds the admin menus
		public function admin_menus() {
			$page = add_menu_page('BookFresh', 'BookFresh', 8, 'bookfresh', array($this, 'create_menus'), plugins_url('/images/logo-icon.png', __FILE__));
			add_action('admin_print_styles-' . $page, array($this, 'load_admin_styles'), 10, '');
			add_action('admin_print_scripts-' . $page, array($this, 'load_admin_scripts'), 10, '');
		}
		
		//Builds admin page
		public function create_menus(){
			$data = get_option('bf_account_settings');
			require( dirname(__FILE__) . '/includes/view-adminpage.php' );
		}

		//Loads the admin stylesheets
		public function load_admin_styles() {						
			wp_enqueue_style('bf_admin', plugins_url('/css/admin-style.css', __FILE__));
		}
		
		//Loads the admin scripts
		public function load_admin_scripts() {	
			wp_enqueue_script("jquery");
			wp_enqueue_script('bf_admin_js', plugins_url('/js/bf_admin.js', __FILE__));
			wp_enqueue_script('jquery_postmessage', plugins_url('/js/jquery.postmessage.js', __FILE__));
			wp_localize_script('bf_admin_js', 'ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ));
			wp_localize_script('bf_admin_js', 'bf_nonce', array('nonce' => wp_create_nonce('bf_ajax-nonce')));
		}

		//Creates the iframe with widget
		public function add_widget_large(){
			return '<!-- Start BookFresh Embed code -->
					<div id="booking_widget_container" style="width: 490;">
					<iframe src="'.BF_API_URL.'/index.html?view=booking_widget&id='.$this->settings['service_id'].'" frameborder="0" 
					name="BookFresh" width="490px" height="590px" id="booking_widget" border="0" style="border: none;" marginwidth="0" scrolling="no"></iframe>
					</div><!-- End BookFresh Embed code -->';
		}

		public function add_widget_small(){
			return '<!-- Start BookFresh Embed code -->
					<div id="mini_widget_container" style="width: 160;">
					<iframe src="'.BF_API_URL.'/index.html?view=mini_widget&id='.$this->settings['service_id'].'" frameborder="0" name="BookFresh" width="160px" height="300px" id="mini_widget" border="0" scrolling="no" style="border: none;" marginwidth="0">
					</iframe></div><!-- End BookFresh Embed code -->';
		}

		public function add_button_booknow(){
			return '<a href="'.BF_API_URL.'/index.html?id='.$this->settings['service_id'].'&wi=3&view=button_dispatcher">
					<img src="'.BF_API_URL.'/images/badge_ht_viewprofile.gif" border="0" alt="I offer online scheduling using BookFresh"></a>';
		}

		//Ajax call to save user info
		public function bf_store(){
			$nonce = $_POST['bf_nonce'];
		    if (wp_verify_nonce( $nonce, 'bf_ajax-nonce' )) {	
				$data = array(
					'email' => $_POST['email'],
					'user_key' => $_POST['user_key']
				);
				update_option('bf_account_settings', $data);
			}
			exit;
		}

		//Ajax call to remove user info
		public function bf_delete(){
			$nonce = $_POST['bf_nonce'];
		    if (wp_verify_nonce( $nonce, 'bf_ajax-nonce' )) {	
				delete_option('bf_account_settings');
			}
			exit;
		}
	}

	$BFInstance = new Bookfresh();
	
	//Hooks
	register_activation_hook( __FILE__, array($BFInstance, 'plugin_activation' ));
	register_deactivation_hook( __FILE__, array($BFInstance, 'plugin_deactivation'));

	//Actions
	add_action('wp_ajax_bf_store', array($BFInstance, 'bf_store'));
	add_action('wp_ajax_bf_delete', array($BFInstance, 'bf_delete'));
	add_action('admin_menu', array($BFInstance, 'admin_menus'), 10, '');

	//Shortcodes
	add_shortcode('bookfresh_widget_large', array($BFInstance, 'add_widget_large'));
	add_shortcode('bookfresh_widget_small', array($BFInstance, 'add_widget_small'));
	add_shortcode('bookfresh_booknow_button', array($BFInstance, 'add_button_booknow'));
	
}
?>
