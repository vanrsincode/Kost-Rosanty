function errorMsg(msg, formTitle, generalErrorMessage) {
    $.each(msg, function (key, value) {
        // let newKey = key.replace(".", "");
        const inputElement = $('#' + key);
        const divElement = $('.msg-' + key)
        const errorMessage = value[0];

        inputElement.addClass('is-invalid');
        divElement.text(errorMessage);
    });

    $('input').each(function() {
        const inputId = $(this).attr('id');
        if (!msg[inputId] || !msg[inputId][0]) {
            $(this).removeClass('is-invalid');
        }
    });

    $('select').each(function() {
        const selectId = $(this).attr('id');
        if (!msg[selectId] || !msg[selectId][0]) {
            $(this).removeClass('is-invalid');
        }
    });

    // showNotif('error', 'topRight', formTitle, generalErrorMessage);
}
