<?php
if (!class_exists('BF_PluginMethods')) {

	class BF_PluginMethods extends BF_DBMethods {

		public function __construct(){
			parent::__construct();
		}

		/* Callback to add_action function
		 *
		 * @return array $callback_data
		 */
		public function bf_add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
			return add_action($tag, $function_to_add, $priority, $accepted_args);		
		}

		/* Callback to add_menu_page function
		 *
		 * @return array $top_menu_page
		 */
		public function bf_add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url = '', $position = 1000) {
			return add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
		}

		/* Callback to activation hook
		 *
		 * @return array $activation_hook - Runs the activation hook
		 */
		public function bf_register_activation_hook($file, $function) {
			return register_activation_hook( $file, $function );
		}

		/* Callback to activation hook
		 *
		 * @return array $activation_hook - Runs the activation hook
		 */
		public function bf_register_deactivation_hook($file, $function) {
			return register_deactivation_hook( $file, $function );
		}

		/* Third-party enqueue style buffer
		 *
		 * @return array $style - Enqueues the stylesheet
		 */
		public function bf_enqueue_style($handle, $src = false, $deps = array(), $ver = false, $media = 'all') {
			return wp_enqueue_style($handle, $src, $deps, $ver, $media);
		}

		/* Third-party top menu page buffer
		 *
		 * @return array $top_menu_page - Creates the top menu page for the correct application
		 */
		public function bf_plugins_url($path, $plugin) {
			return plugins_url($path, $plugin);
		}


		/* Dashboard admin page
		 *
		 * @return string $page - The dashboard adming page HTML
		 */
		public function dashboard() {
			$data = $this->GetOption('bf_account_settings');
			?>
				<div class="wrap">
					<div id="icon-index" class="icon32"></div>
					<h2>Dashboard</h2>
					<p>BookFresh Account Settings</p>
					<form action="" method="post" name="accountsettings" id="accountsettings">
						<table class="form-table">
							<tbody>
								<tr class="form-field">
									<th scope="row"><label for="email">E-mail: </label></th>
									<td><input name="email" type="text" id="email" value="<?php echo $data['email']; ?>"></td>
								</tr>
								<tr class="form-field">
									<th scope="row"><label for="password">Password: </label></th>
									<td><input name="password" type="text" id="password" value="<?php echo $data['password']; ?>"></td>
								</tr>
							</tbody>
						</table>
						<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="Save"></p>
					</form>
				</div>
			<?php			
		}
	}
}
?>