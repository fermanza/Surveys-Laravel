function validateForm() {
    var submit = true;

    $('.validate-input').each(function(){

        if($(this).val() == '' || $(this).val() == 0) {
            submit = false;
            $(this).addClass('needs-validation');
        } else {
            $(this).removeClass('needs-validation');
        }

    });

    if(!submit) {
        $('#validation-error').fadeIn();
        $('html, body').animate( { scrollTop: $('#validation-error').offset().top }, 1000 );
    } else {
        $('#validation-error').fadeOut();
    }
    
    return submit;
}