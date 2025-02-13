$(function(){

    console.log('Привет, это страый js ))');
    init_get();
    init_post();
});

function init_get()
{
    $('a.ajaxArticleBodyByGet').one('click', function(){
        var contentId = $(this).attr('data-contentId');
        console.log('ID статьи = ', contentId);
        showLoaderIdentity();
        $.get(
            '/get/' + contentId
        )
            .done (function(obj){
                hideLoaderIdentity();
                console.log('Ответ получен',obj);
                $('.summary' + contentId).replaceWith(obj);
            })
            .fail(function(xhr, status, error){
                hideLoaderIdentity();

                console.log('ajaxError xhr:', xhr);
                console.log('ajaxError status:', status);
                console.log('ajaxError error:', error);

                console.log('Ошибка соединения при получении данных (GET)');
            });

        return false;

    });
}

function init_post()
{
    $('a.ajaxArticleBodyByPost').one('click', function(){
        var content = $(this).attr('data-contentId');
        console.log(content+'21111111111111111111111111111111111');
        showLoaderIdentity();
        $.post(
            '/post',
            {id: content}
        )
            .done (function(obj){
                hideLoaderIdentity();
                console.log('Ответ получен', obj);
                $('.summary' + content).replaceWith(obj);
            })
            .fail(function(xhr, status, error){
                hideLoaderIdentity();


                console.log('Ошибка соединения с сервером (POST)');
                console.log('ajaxError xhr:', xhr);
                console.log('ajaxError status:', status);
                console.log('ajaxError error:', error);
            });

        return false;

    });
}