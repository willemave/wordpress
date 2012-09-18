<?php
if (!class_exists('BF_PluginMethods')) {

	class BF_PluginMethods extends BF_DBMethods {

		private $settings;

		public function __construct(){
			parent::__construct();
			$this->settings = $this->GetOption('bf_account_settings');
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
				<div id="icon-index" class="icon32"></div>
				<h2>BookFresh</h2>
				<div id="bf-container">
					<div id="bf_flash_message" style="display:none;"></div>
					<div id="bf-left-container">
						<fieldset id="bf-fieldset">
							<legend>BookFresh Account Login</legend>
							<form action="" method="post" name="accountsettings" id="accountsettings">
								<ul>
									<li>
										<label for="email">E-mail: </label>
										<input name="email" type="text" id="email"/>
									</li>
									<li>
										<label for="password">Password: </label>
										<input name="password" type="password" id="password"/>
									</li>
									<li>
										<button type="submit" name="createuser" id="createusersub" class="button-primary">Login</button>
									</li>
								</ul>
							</form>
							<h3>Linked Account Info</h3>
							<div id="bf-shortcodes">
								<p id="service_id"><b>BookFresh Service ID:</b> <?php echo $data['service_id']; ?></p>
								<p id="bf_email"><b>BookFresh Email:</b> <?php echo $data['email']; ?></p>
								<button type="button" name="unlink_account" id="unlink_account" class="button-primary">Unlink Account</button><br/><br/><br/>
								<b>Bookfresh Available Short Codes</b>
								<ul>
									<li>[bookfresh_widget_large]</li>
									<li>[bookfresh_widget_small]</li>
									<li>[bookfresh_booknow_button]</li>
								</ul>
							</div>
						</fieldset>
					</div>
					<div id="bf-side">
						<ul>
							<li><span>Step 1:</span> <a href="http://www.bookfresh.com/pricing/" target="_blank">Signup with Bookfresh!</a></li>
							<li><span>Step 2:</span> Type your Email and Password into the WordPress Plugin to the left</li>
							<li><span>Step 3:</span> Pick and use a ShortCode anywhere in your Site!</li>
							<li><span>Step 4:</span> Log in to <a href="http://www.bookfresh.com/index.html?view=login" target="_blank">Bookfresh</a> and customize the look and feel of your widget!</li>
						</ul>
						<div id="widget_large" class="widgets_info">
							<span>[bookfresh_widget_large]</span>
							<img src="<?php echo $this->bf_plugins_url('/images/widget.png', dirname(__FILE__)); ?>" alt="bookfresh_widget_large"/>
						</div>
						<div id="mini_widget" class="widgets_info">
							<span>[bookfresh_widget_small]</span>
							<img height="150" src="<?php echo $this->bf_plugins_url('/images/mini_widget.png', dirname(__FILE__)); ?>" alt="bookfresh_widget_small"/>
						</div>
						<div id="button_widget" class="widgets_info">
							<span>[bookfresh_booknow_button]</span>
							<img src="<?php echo $this->bf_plugins_url('/images/booknow_button.gif', dirname(__FILE__)); ?>" alt="bookfresh_booknow_button"/>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			<?php			
		}

		public function bf_widget_large(){
			return '<!-- Start BookFresh Embed code -->
					<div id="booking_widget_container" style="width: 490;">
					<iframe src="'.BF_API_URL.'/index.html?view=booking_widget&id='.$this->settings['service_id'].'" frameborder="0" 
					name="BookFresh" width="490px" height="590px" id="booking_widget" border="0" style="border: none;" marginwidth="0" scrolling="no"></iframe>
					</div><!-- End BookFresh Embed code -->';
		}

		public function bf_booknow_button(){
			return '<a href="'.BF_API_URL.'/index.html?id='.$this->settings['service_id'].'&wi=3&view=button_dispatcher">
					<img src="'.BF_API_URL.'/images/badge_ht_viewprofile.gif" border="0" alt="I offer online scheduling using BookFresh"></a>';
		}

		public function bf_widget_small() {
			return '<!-- Start BookFresh Embed code -->
					<div id="mini_widget_container" style="width: 160;">
					<iframe src="'.BF_API_URL.'/index.html?view=mini_widget&id='.$this->settings['service_id'].'" frameborder="0" name="BookFresh" width="160px" height="300px" id="mini_widget" border="0" scrolling="no" style="border: none;" marginwidth="0">
					</iframe></div><!-- End BookFresh Embed code -->';
		}

		public function api_call() {
			return json_encode();
		}
	}
}
?>