/**
* Инициализирует работу филиалов в городах
* Зависит от jquery.searchAffiliates
*/
$(function() {
    //Активируем переход по ссылкам
    $('body').on('click', '.affiliates [data-href]', function() {
        location.href = $(this).data('href');
    });
    
    //Активируем поиск по городам во всплывающем окне
    $('body').on('new-content', function() {    
        $('.fastSearch', this).searchAffiliates();    
    });    
    
    //Активируем кнопку "Выбрать другой город"
    $('.otherCity').click(function() {
        $('.affiliatesContacts .affiliates').toggleClass('visible');
    });
    
    //Активируем поиск по городам на странице контактов
    $('.fastSearch', this).searchAffiliates();
    
    //Активируем возможность уточнения города
    $('.cityLink:first').each(function() {
        if ($(this).data('needRecheck')) {
            $.openDialog({
                url: $(this).data('href')
            });
        }
    });    
});