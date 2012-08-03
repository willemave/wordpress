
jQuery(document).ready(function($) {
	$("#accountsettings").validate({
		rules: {
            email: "required",
            password: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            },
            
        },
        messages: {
            password: {
                required: "Please provide a password",
            },
            email: "Please enter a valid email address"
        },
        submitHandler: function(form) {
	        var email = $("#email").val();
			var password = $("#password").val();
			var url = bf_api_url.url + '?callback=?';


			$.getJSON(url, { xaction: 'login', user_name: email, password: password }, function(service){

				var data = {
					action: 'bf_member',
					service_id: service.service_id, 
					email: email, 
					password: password,
					bf_nonce: bf_nonce.nonce
				};

				if(service.status) {
					$.post(ajax_script.ajaxurl, data, function(){
						flash_message('Account Info Saved!', 'sucess');
				    });
				} else {
					flash_message(service.message, 'eror');
				}
			})
			return false;    
        }
	});

	
    $("#api_url_action").click(function(){

    	var url = $("#api_url").val();
    	var data = {
    		action: 'bf_api_url', 
    		api_url: url,
    		bf_nonce: bf_nonce.nonce
    	};
    	$.post(ajax_script.ajaxurl, data, function(response){
    		if(response) {
    			flash_message('API URL Saved!', 'sucess');	
    		}
    		
    	});
    });

    var flash_message = function(message, type){
    	$("#bf_flash_message").show().fadeIn('slow', function(){
    		$(this).empty();
    		$(this).append(message);
    		if(type == 'sucess') {
    			$(this).css('background-color', '#FFFBCC');
				$(this).css('color', '#000');
    		} else {
    			$(this).css('background-color', '#DD4B39');
				$(this).css('color', '#ffffff');
    		}
	    }).fadeOut(3000);;
    }
});