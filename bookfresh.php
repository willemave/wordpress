<?php
/*
Plugin Name: BookFresh
Plugin URI: http://bookfresh.com
Description: BookFresh plugin for Wordpress
Version: 1.0
Author: BookFresh
Author URI: http://bookfresh.com
Text Domain: bookfresh.com
*/


require_once( dirname(__FILE__) . '/includes/class-dbmethods.php' );
require_once( dirname(__FILE__) . '/includes/class-pluginmethods.php' );
require_once( dirname(__FILE__) . '/admin/settings.php' );

if(!class_exists('BookFresh')){

	class BookFresh extends BF_PluginMethods {

		public function __construct(){
			parent::__construct();
		}

		/* Runs plugin activation routines
		 *
		 */
		public function plugin_activation() {
			$this->CreateBookfreshTables();
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
			$page = $this->bf_add_menu_page('BookFresh', 'BookFresh', 8, 'bookfresh', array($this, 'create_menus'), '');
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
		

	}

	$BFInstance = new Bookfresh();
	
	//Hooks
	$BFInstance->bf_register_activation_hook( __FILE__, array( $BFInstance, 'plugin_activation' ) );
	$BFInstance->bf_register_deactivation_hook( __FILE__, array( $BFInstance, 'plugin_deactivation' ) );

	//Actions
	$BFInstance->bf_add_action('admin_menu', array($BFInstance, 'admin_menus'), 10, '');

	//Maybe put this into the plugin methods and add validation checking.
	if($_POST['createuser'] == 'Save') {
		$data['email'] = $_POST['email'];
		$data['password'] = $_POST['password'];

		$BFInstance->SaveOption('bf_account_settings', $data);
	}
}
?>