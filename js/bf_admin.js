var bf_store_info = function(email, user_key) {
	var data = {
		action: 'bf_store',
		email: email,
		user_key: user_key, 
		bf_nonce: bf_nonce.nonce
	};
	jQuery.post(ajax_script.ajaxurl, data, function(){
		window.location.reload();
	});
}

var bf_delete_info = function() {
	var data = {
		action: 'bf_delete',
		bf_nonce: bf_nonce.nonce
	};
	jQuery.post(ajax_script.ajaxurl, data, function(){
		window.location.reload();
	})
}

var bf_reload_page = function() {
	window.location.reload();
}

var bf_decode_params = function(params) {
	var urlParams = {},
		match,
		pattern = /([^&=]+)=?([^&]*)/g,
		decode = function (s) { return decodeURIComponent(s.replace(/\+/g, " ")); };
	while ( ( match = pattern.exec(params) ) !== null ) {
		urlParams[decode(match[1])] = decode(match[2]); 
	}
	return urlParams;
}

jQuery(document).ready(function() {

	jQuery.receiveMessage(function(e) {
		var data = bf_decode_params(e.data);
		if(data.method == 'bf_store_info') {
			bf_store_info(data.email, data.user_key);
		}
		else if(eval('typeof ' + data.method) == 'function') {
			eval(data.method + '()');
		}
	});
	
});