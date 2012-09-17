
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
            var url = bf_api_url.url + '/cindex.php/account/ajax?callback=?';
            
            $.getJSON(url, { xaction: 'login', email: email, password: password }, function(service){
                var data = {
                    action: 'bf_member',
                    service_id: service.service_id, 
                    email: email,
                    bf_nonce: bf_nonce.nonce
                };

                if(service.status) {
                    $.post(ajax_script.ajaxurl, data, function(){
                        $("#service_id").html("<b>BookFresh Service ID:</b> " + service.service_id);
                        $("#bf_email").html("<b>BookFresh Email:</b> " + email);
                        flash_message('Account Info Saved!', 'success');
                    });
                } else {
                    flash_message(service.message, 'error');
                }
            })
            .error(function() { flash_message('Something went wrong, Can\'t connect to Server. Please try again', 'error'); })
            return false;
        }
    });

    $("#unlink_account").click(function(){
        var data = {
                action: 'bf_delete',
                bf_nonce: bf_nonce.nonce
            };
        $.post(ajax_script.ajaxurl, data, function(){
            $("#email, #password").val('');
        })
        .success(function() { flash_message('Account details deleted', 'success'); })
        .error(function() { flash_message('Something went wrong. Please try again', 'error'); })
    })

    var flash_message = function(message, type){
        $("#bf_flash_message").show().fadeIn('slow', function(){
            $(this).empty();
            $(this).append(message);
            $(this).css('font-size', '14px');
            $(this).css('padding', '5px 10px');
            if(type == 'success') {
                $(this).css('background-color', '#FFFBCC');
                $(this).css('color', '#000');
            } else {
                $(this).css('background-color', '#DD4B39');
                $(this).css('color', '#ffffff');
            }
        })
        .fadeOut(3000, function(){
             location.reload();
        });
    }
});