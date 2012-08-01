jQuery(document).ready(function($) {
	$("#accountsettings").submit(function(e){
		e.preventDefault();
		var email = $(this).find( 'input[name="email"]').val();
		var password = $(this).find( 'input[name="password"]').val();
		var url = 'http://peter.sandbox.boofresh.com/cindex.php/account/ajax?callback=?'; 
		var service_id;

		if(email.length == 0 || password.length == 0) {
			$("#bf_flash_message").show().fadeIn('slow', function(){
				$(this).empty();
				$(this).append('Email and Password is Required!');
				$(this).css('background-color', '#DD4B39');
				$(this).css('color', '#ffffff');
	        });
		} else {
			$.getJSON(url, { xaction: 'login', user_name: email, password: password }, function(service){
				var data = {
					action: 'bf_member',
					service_id: service.service_id, 
					email: email, 
					password: password,
					bf_nonce: bf_nonce.nonce
				};
				$.post(ajax_script.ajaxurl, data, function(response){
					$("#bf_flash_message").show().fadeIn('slow', function(){
						$(this).empty();
						$(this).css('background-color', '#FFFBCC');
						$(this).css('color', '#000');
						$(this).append('Account Info Saved!');
						$("#service_id").empty().append('<b>BookFresh Service ID:</b> ' + data.service_id);
						$("#bf_email").empty().append('<b>BookFresh Email:</b> ' + data.email);

						$(this).fadeOut(3000);
			        });
			    });
			});
			return false;
		}
	});
});