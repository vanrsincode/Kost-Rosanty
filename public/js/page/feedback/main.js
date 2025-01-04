$(document).ready(function () {
    const gets = {
        dataFeedbackADM: `dataFeedbackADM`,
        dataFeedbackPHN: `../dataFeedbackPHN`,
        formPHNFeedback: `../user/feedback`
    }

    let btnAll;
    const fmFeedback = $('#FFeedback');

    function setupForm(form, mode, title, id) {
        $('#modal' + form).off('hidden.bs.modal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
        $('#modal' + form).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        $('#MH' + form).html(title);

        if (btnAll) {
            btnAll.remove();
        }
        const btnID = mode.toLowerCase() + form;
        const btnFm = $(`<button type="submit" class="btn btn-primary btn-form" id="${btnID}" data-number="${id}">${mode.charAt(0).toUpperCase() + mode.slice(1)}</button>`);
        btnAll = btnFm;
        btnFm.appendTo('.footer' + form);

        // reset all
        $('.invalid-feedback').text('');
        $('#pesan').removeClass('is-invalid');
    }

    // Datatables
    const customColumnDefsADM = [
        {targets: [3], className: 'datatable-column-ellipsis'}
    ];
    const customColumnDefsPHN = [
        {targets: [2], className: 'datatable-column-ellipsis'}
    ];
    const tblFeedbackADM = setupDataTables('#feedback-tbl', gets.dataFeedbackADM, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'nama', className: 'text-center' },
        { data: 'tanggal', className: 'text-center' },
        { data: 'pesan', sortable: false, render: function (data, type, row) { return data ? data.replace(/\n/g, '<br>') : ''; } },
        // { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], false, [1, 'asc'], false, true, true, 10, true, customColumnDefsADM);
    const tblFeedbackPHN = setupDataTables('#feedbackphn-tbl', gets.dataFeedbackPHN, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        // { data: 'nama', className: 'text-center' },
        { data: 'tanggal', className: 'text-center' },
        { data: 'pesan', sortable: false, render: function (data, type, row) { return data ? data.replace(/\n/g, '<br>') : ''; } },
        { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], false, [1, 'asc'], false, true, true, 10, true, customColumnDefsPHN);
    // End Datatables

    // Create
    $('body').on('click touchstart', '#createFeedback', function () {
        setupForm('Feedback', 'tambah', 'Tambah Feedback', '');
    });

    // Edit
    $('body').on('click touchstart', '.editData', function () {
        const feedback_id = $(this).data('id');
        $.ajax({
            url: gets.formPHNFeedback + `/${feedback_id}`,
            type: "GET",
            cache: false,
            success: function (response) {
                $('#pesan').val(response.data.pesan);
                setupForm('Feedback', 'ubah', 'Ubah Feedback', feedback_id);
            }
        });
    });

    // Action
    fmFeedback.on('submit', function (e) {
        e.preventDefault();
        const submitButton = $(this).find('.btn-form');
        submitButton.addClass('btn-progress disabled');

        const feedback_id = $(this).find('.btn-form').data('number');
        const url = (feedback_id) ? `${gets.formPHNFeedback}/${feedback_id}` : gets.formPHNFeedback;
        // const method = (kmr_id) ? 'PUT' : 'POST';
        const formData = new FormData(this);

        $.ajax({
            data: formData,
            url: url,
            type: 'POST',
            // dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if ($.isEmptyObject(data.errors)) {
                    fmFeedback[0].reset();
                    $('#modalFeedback').modal('hide');
                    tblFeedbackADM.draw();
                    tblFeedbackPHN.draw();
                    showNotif('success', 'topRight', 'Data Feedback', (feedback_id ? 'Berhasil diubah' : 'Berhasil ditambahkan'));
                } else {
                    errorMsg(data.errors, 'Form Feedback', 'Mohon periksa kembali! Terdapat kolom yang kosong');
                }
            },
            complete: function () {
                submitButton.removeClass('btn-progress disabled');
            }
        });
    });

    // Delete
    $('body').on('click touchstart', '.deleteData', function () {
        const feedback_id = $(this).data('id');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `ingin menghapus pesan ini!`,
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Tidak',
                    value: null,
                    visible: true,
                    className: '',
                    closeModal: true
                },
                confirm: {
                    text: 'Ya, hapus!',
                    value: true,
                    visible: true,
                    className: 'btn-danger',
                },
            },
            dangerMode: true,
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: gets.formPHNFeedback + `/del/${feedback_id}`,
                    type: "POST",
                    cache: false,
                    success: function () {
                        tblFeedbackADM.draw();
                        tblFeedbackPHN.draw();
                        swal('Data Berhasil Dihapus', {
                            icon: 'success',
                        });
                    },
                    complete: function () {
                        $button.prop('disabled', false);
                    }
                });
            } else {
                $button.prop('disabled', false);
            }
        });
    });
});
