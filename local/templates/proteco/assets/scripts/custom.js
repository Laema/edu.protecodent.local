function doDownload(obj){
    let file = obj.files[0];
    var form_data = new FormData;
    form_data.append("file", file);
    $.ajax({
        url: "/local/templates/proteco/API/addFileToOrder.php",
        type: "POST",
        processData: false,
        contentType:false,
        async:false,
        data: form_data,
        success:function(data){
            $('#payment-check').val(data);
        }
    });
}

function doDownloadRegistered(obj){
    let file = obj.files[0];
    var form_data = new FormData;
    let iventId =
    form_data.append("file", file);
    $.ajax({
        url: "/local/templates/proteco/API/addFileToOrder.php",
        type: "POST",
        processData: false,
        contentType:false,
        async:false,
        data: form_data,
        success:function(data){
            console.log(data);
            $('#send-check-button').data('check-url', data);
            $('#send-check-button').attr('data-check-url', data);
        }
    });
}

$(function() {

    $('.show-add-check-popup').on('click',  function(event) {
        let eventId = $(this).data('event-id');
        $('#send-check-button').data('event-id', eventId);
        $('#send-check-button').attr('data-event-id', eventId);
    });


    $('.show-modal-with-check').on('click',  function(event) {
        let isCheckNeeded = $(this).data('is-chek-needed');

        if(isCheckNeeded == 'yes') {
            $('#register-new-user #download').show();
            $('#register-new-user #download input').prop('required', true);
            $('#register-new-user #download input').attr('required', true);
        } else{
            $('#register-new-user #download').hide();
            $('#register-new-user #download input').prop('required',false);
            $('#register-new-user #download input').attr('required',false);
        }
    });

    $('#register-form').on('submit',  function(event) {
        event.preventDefault();

        let error = false,
            registrateUser = $('#registrate-user').val(),
            url = '/local/templates/proteco/API/registration/autoriseUser.php',
            data = $(this).serialize();

        if(registrateUser == 1) {
            url = '/local/templates/proteco/API/registration/registrateUser.php';
        }

        $('#register-form-submit-button').addClass('button-spinner button-disabled').prop('disabled', true);

        if(!error) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(result) {
                    $('#register-form-submit-button').removeClass('button-spinner button-disabled').prop('disabled', false);

                    if(result.status == 'error') {
                        if(result.error_type == 'already registered') {
                            $('#registrate-user').val(0);
                            $('#register-form-password-input').show();
                            $('#register-form-submit-button').val('Вход');
                        }
                        if(result.error_type == 'not registered') {
                            $('#registrate-user').val(1);
                            $('#register-form-password-input').hide();
                            $('#register-form-not-registered').show();
                            $('#register-form-submit-button').val('Зарегистрироваться');
                        }
                    } else {
                        window.location.href = result.redirect_url;
                    }
                }
            });
        }
    });

});
