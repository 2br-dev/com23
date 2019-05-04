$(document).ready(function(){
    /**
     * Отправка формы
     */
   $("body").on('submit', "#ajaxpromo", function(){
       var $this = $(this);
       $.ajax({
           type: 'POST',
           url: $(this).attr('action'),
           data: $(this).serialize(),
           dataType: 'json',
           success: function(response){
               console.log(response);
               var html = response['html'];
               $this.replaceWith(html);
               $this.trigger('new-content');
           }
       });
       return false;
   });
});