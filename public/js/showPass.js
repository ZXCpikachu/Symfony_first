$('.passw').click(function(){
    console.log('!!!!!!!!!!!!!!!!!!!!!!!!');
    $(this).is(':checked') ?
        $('#password').attr('type', 'text') : $('#password').attr('type', 'password')
});