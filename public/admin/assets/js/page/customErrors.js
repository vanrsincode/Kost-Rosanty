// Error Message
function errorMsg(msg, formTitle, generalErrorMessage) {

    $.each(msg, function (key, value) {
        // let newKey = key.replace(".", "");
        const inputElement = $('#' + key);
        const divElement = $('.msg-' + key)
        const errorMessage = value[0];

        inputElement.addClass('is-invalid');
        divElement.text(errorMessage);
        // if (errorMessage) {
        //     inputElement.addClass('is-invalid');
        //     divElement.text(errorMessage);
        // } else {
        //     inputElement.removeClass('is-invalid');
        //     divElement.text('');
        // }

        // console.log(key);
        // console.log(errorMessage);
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

    // $("input.is-invalid, select.is-invalid, textarea.is-invalid").each(function () {
    //     const currentValue = $(this).val().trim();

    //     // console.log(currentValue);

    //     // if (currentValue !== '') {
    //     //     $(this).removeClass("is-invalid");

    //     //     if ($(this).hasClass("select2")) {
    //     //         $(this).next(".select2-container").removeClass("is-invalid");
    //     //     }

    //     //     // const newKey = $(this).attr("id");
    //     //     // const divElement = $(".msg-" + newKey);
    //     //     // divElement.text("");
    //     // }
    // });

}
