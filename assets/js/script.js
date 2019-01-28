jQuery(function() {

    jQuery("#formPost").validate({
        submitHandler:function() {
            jQuery.post(ajaxurl,{action:"employee_portal_ajax_req",
                                 username:$("#username").val(),
                                 pass:$("#pass").val(),
                                 sign:$("#sign").val()
                                },
                                function(response) {
                console.log(response);
            });
        }
    });

    jQuery(document).on("click",".btnClick",function() {
        
        var post_data = "action=employee_portal_library&param=get_message";
        $.post(ajaxurl,post_data,function(response) {
            console.log(response);
        });

    });

});