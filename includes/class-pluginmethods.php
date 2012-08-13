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
		 * @return array $activation_hook - Runs the deactivation hook
		 */
		public function bf_register_deactivation_hook($file, $function) {
			return register_deactivation_hook( $file, $function );
		}

		/* Callback to enqueue style
		 *
		 * @return array $style - Enqueues the stylesheet
		 */
		public function bf_enqueue_style($handle, $src = false, $deps = array(), $ver = false, $media = 'all') {
			return wp_enqueue_style($handle, $src, $deps, $ver, $media);
		}

		/* Callback for top menu page
		 *
		 * @return array $top_menu_page
		 */
		public function bf_plugins_url($path, $plugin) {
			return plugins_url($path, $plugin);
		}


		/* Dashboard admin page
		 *
		 * @return string $page - The dashboard admin page HTML
		 */
		public function dashboard() {
			$data = $this->GetOption('bf_account_settings');
			?>
				<div class="wrap">
					<div id="icon-index" class="icon32"></div>
					<h2>Dashboard</h2>
					<div id="bf_flash_message" style="display:none;"></div>
					<h3>BookFresh Account Settings</h3>
					<form action="" method="post" name="accountsettings" id="accountsettings">
						<table class="form-table">
							<tbody>
								<tr class="form-field">
									<th scope="row"><label for="email">E-mail: </label></th>
									<td><input name="email" type="text" id="email"></td>
								</tr>
								<tr class="form-field">
									<th scope="row"><label for="password">Password: </label></th>
									<td><input name="password" type="password" id="password"></td>
								</tr>
							</tbody>
						</table>
						<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="Login"></p>
					</form>
					<p id="service_id"><b>BookFresh Service ID:</b> <?php echo $data['service_id']; ?></p>
					<p id="bf_email"><b>BookFresh Email:</b> <?php echo $data['email']; ?><p> <br/>
					<p>Bookfresh Available Short Codes</p>
					<ul>
						<li>[bookfresh_widget_large]</li>
						<li>[bookfresh_booknow_button]</li>
					</ul>
				</div>
			<?php			
		}

		public function bf_widget_large(){
			global $ISDEV; 
			$url = $ISDEV === false ? BF_LIVE_URL : BF_DEV_URL;
			$data = $this->GetOption('bf_account_settings');
			return '<!-- Start BookFresh Embed code -->
					<div id="booking_widget_container" style="width: 490;">
					<iframe src="'.$url.'/index.html?view=booking_widget&id='.$data['service_id'].'" frameborder="0" 
					name="BookFresh" width="490px" height="590px" id="booking_widget" border="0" style="border: none;" marginwidth="0" scrolling="no"></iframe>
					<div><span style="font-size: 10px; color: #88888b; font-family: Lucida Grande, Lucida,sans-serif;">
					<a href="'.$url.'" target="_blank" style="color: #88888b; text-decoration: underline;">
					appointment scheduling software</a> - by BookFresh</span></div></div><!-- End BookFresh Embed code -->';
		}

		public function bf_booknow_button(){
			global $ISDEV; 
			$url = $ISDEV === false ? BF_LIVE_URL : BF_DEV_URL;
			$data = $this->GetOption('bf_account_settings');
			return '<a href="'.$url.'/index.html?id='.$data['service_id'].'&wi=3&view=button_dispatcher">
					<img src="'.$url.'/images/badge_ht_viewprofile.gif" border="0" alt="I offer online scheduling using BookFresh"></a>';
		}

		public function api_call() {
			return json_encode();
		}
	}
}
?>