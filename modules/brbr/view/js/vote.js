$(document).ready(function(){
    let $lightbox = $('.vote-item a').simpleLightbox();
    
    $(".make-vote").click(function() {
        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: {
                id : $(this).data('id'),
                category: $(this).data('category')
            },
            dataType: 'JSON',
            success: function(res){
                if(res.success) {
                    $('.vote-modal-wrapper').fadeOut();
                    $('.vote-success-wrapper').fadeIn();
                }
               else{
                    $('.vote-modal-wrapper').fadeOut();
                    $('.vote-error-wrapper').fadeIn();
                }
            },
            error: function(res){
               // console.log(res);
            },
        });
    });




    $(".vote-open").click(function() {
        $(".vote-wrapper").fadeIn();
        $(".vote-modal-wrapper").fadeIn();
        $('#makeVote').data('id', $(this).data('id'));
        $('#makeVote').data('category', $(this).data('category'));
        console.log($(this).data('category'));
    });

    //$(".vote-old").hide();
    /*
    $(".vote-container-header-button").click(function() {
        $(".vote-old").toggle();
        $(".vote-young").toggle();
        $('.vote-container-header-text').html() == "РАБОТЫ ТВОРЦОВ 3-7 ЛЕТ" ? $('.vote-container-header-text').text('РАБОТЫ ТВОРЦОВ 8-14 ЛЕТ') : $('.vote-container-header-text').text('РАБОТЫ ТВОРЦОВ 3-7 ЛЕТ');
        $('.vote-container-header-button').html() == "РАБОТЫ ТВОРЦОВ 8-14 ЛЕТ" ? $('.vote-container-header-button').text('РАБОТЫ ТВОРЦОВ 3-7 ЛЕТ') : $('.vote-container-header-button').text('РАБОТЫ ТВОРЦОВ 8-14 ЛЕТ') ;
    }); */

    $(".vote-modal-no").click(function() {
        $(".vote-wrapper").fadeOut();
        $(".vote-modal-wrapper").fadeOut();
    });

    $(".close-button").click(function() {
        $(".vote-wrapper").fadeOut();
        $(".vote-error-wrapper").fadeOut();
        $(".vote-modal-wrapper").fadeOut();
        $(".vote-success-wrapper").fadeOut();
    });

    $(".vote-check-result").click(function() {
        setTimeout(function(){
            location.reload();
        }(1000));
    });
});
