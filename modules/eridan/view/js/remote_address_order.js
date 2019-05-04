$(document).ready(function(){
    $("body").on('change', ".is_remote_region", function(){
        $.ajax({
            type: 'POST',
            data: {
                name: $(this).attr('name'),
                id : $(this).val()
            },
            url: $(this).data('url')
        });
    });
});