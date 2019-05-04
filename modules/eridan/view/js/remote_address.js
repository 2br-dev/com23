$(document).ready(function(){
    var wrapper = $("#eridanUserAdress");
    $("input[type='checkbox']", wrapper).on('change', function(){
        $.ajax({
            type: 'POST',
            data: {
                name: $(this).attr('name'),
                id : $(this).val()
            },
            url: wrapper.data('url')
        });
    });
});