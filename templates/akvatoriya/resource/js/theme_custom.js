$(document).ready(function(){
    var text;
    $('.help-icon').on('click', function(){
        text = $(this).data('original-title');
        $('.help-desc').text(text).toggleClass('show');
        //console.log(text);
    });
});
        