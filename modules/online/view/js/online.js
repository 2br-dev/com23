$(document).ready(function(){    
    $('#user_online_status').on('click', function(){        
        $.ajax({           
            url: $(this).data('url'),
            type: 'POST',
            error: function(err){
                console.log(err);
            },
            success: function(res){
                window.location.reload();
            }
        });
    });
});