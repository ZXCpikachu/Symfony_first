$(document).ready(function(){
    $("#send").click(function () {
        $("#form_edit").submit();
    });
    $("#form_edit").submit(function (event) {
        let olddata = $(this).serializeArray();
        let route = $("#send").data('route');
        let postKey = route.match(/(?<=\/)\w+/i)[0];
        console.log('Маршрут: ' + route);
        let newdata = {};
        $.each(olddata, function (_, v) {
            let key = v.name.match(/(?<=\[)\w+/i)[0];
            newdata[key] = v.value;
        });
        console.log(newdata);
        event.preventDefault();
        $.post(
            route,
            {[postKey]: newdata}
        )
            .done (function(obj){
                let nextRoute = route.match(/^\/\w+\//i)[0];
                console.log('Ответ получен');//, obj
                console.log('Маршрут: ' + nextRoute);
                window.location.href = nextRoute;
            })
            .fail(function(xhr, status, error){
                let errorMessage = '<div class="alert alert-danger">Ошибка: логин ' +
                    `"${newdata.login}"` + ' задействован.</div>';
                $('#unique_error').html(errorMessage);
                console.log('Ошибка соединения с сервером (POST)');
                console.log('ajaxError xhr:', xhr.responseText); // выводим значения переменных
                console.log('ajaxError status:', status);
                console.log('ajaxError error:', error);
            });
        return false;
    });

});