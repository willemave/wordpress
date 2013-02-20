<div id="icon-index" class="icon32"></div>
<h2>BookFresh</h2>
<div id="bf-container">
	<div id="bf_flash_message" style="display:none;"></div>
	<div id="bf-left-container">
		<iframe id="bf-adminpage" 
				src="<?= BF_API_URL ?>/cindex.php/partners/wordpress/settings?id=<?= urlencode($data['email']) ?>&key=<?= $data['user_key'] ?>&parent_url=<?= urlencode('http' . ($_SERVER["HTTPS"] == "on" ? 's' : '') . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]) ?>" 
				scrolling="no" frameborder="0" 
				marginheight="0" marginwidth="0" 
				height="600" width="100%">
		</iframe>
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
			<img src="<?php echo plugins_url('/images/widget.png', dirname(__FILE__)); ?>" alt="bookfresh_widget_large"/>
		</div>
		<div id="mini_widget" class="widgets_info">
			<span>[bookfresh_widget_small]</span>
			<img height="150" src="<?php echo plugins_url('/images/mini_widget.png', dirname(__FILE__)); ?>" alt="bookfresh_widget_small"/>
		</div>
		<div id="button_widget" class="widgets_info">
			<span>[bookfresh_booknow_button]</span>
			<img src="<?php echo plugins_url('/images/booknow_button.gif', dirname(__FILE__)); ?>" alt="bookfresh_booknow_button"/>
		</div>
	</div>
	<div class="clear"></div>
</div>