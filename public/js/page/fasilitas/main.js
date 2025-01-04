$(document).ready(function () {
    const gets = {
        dataFasilitas: `dataFasilitas`,
        formFasilitas: `fasilitas`
    }

    let btnAll;
    const fmFasilitas = $('#FFasilitas');

    function setupForm(form, mode, title, id) {
        // modal
        $('#modal' + form).off('hidden.bs.modal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
        $('#modal' + form).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        $('#MH' + form).html(title);

        // btn
        if (btnAll) {
            btnAll.remove();
        }
        const btnID = mode.toLowerCase() + form;
        const btnFm = $(`<button type="submit" class="btn btn-primary btn-form" id="${btnID}" data-number="${id}">${mode.charAt(0).toUpperCase() + mode.slice(1)}</button>`);
        btnAll = btnFm;
        btnFm.appendTo('.footer' + form);

        // reset all
        $('.invalid-feedback').text('');
        $('#fasilitas').removeClass('is-invalid');
    }

    // Datatables
    const customColumnDefs = [
        { targets: [0], className: 'text-left pl-3 datatable-column-ellipsis' }
    ];
    const tblFasilitas = setupDataTables('#fasilitas-tbl', gets.dataFasilitas, [
        // { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'nama_fasilitas'},
        { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], false, [1, 'asc'], false, true, true, 5, true, customColumnDefs);
    // End Datatables

    // Create
    $('body').on('click touchstart', '#createFasilitas', function () {
        setupForm('Fasilitas', 'tambah', 'Tambah Fasilitas', '');
    });

    // Edit
    $('body').on('click touchstart', '#editData', function () {
        const fasilitas_id = $(this).data('id');
        $.ajax({
            url: gets.formFasilitas + `/${fasilitas_id}`,
            type: "GET",
            cache: false,
            success: function (response) {
                $('#fasilitas').val(response.data.nama_fasilitas);
                setupForm('Fasilitas', 'ubah', 'Ubah Fasilitas', fasilitas_id);
            }
        });
    });

    // Action
    fmFasilitas.on('submit', function (e) {
        e.preventDefault();
        const submitButton = $(this).find('.btn-form');
        submitButton.addClass('btn-progress disabled');

        const fasilitas_id = $(this).find('.btn-form').data('number');
        const url = (fasilitas_id) ? `${gets.formFasilitas}/${fasilitas_id}` : gets.formFasilitas;
        // const method = (fasilitas_id) ? 'PUT' : 'POST';
        const formData = new FormData(this);

        $.ajax({
            data: formData,
            url: url,
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if ($.isEmptyObject(data.errors)) {
                    fmFasilitas[0].reset();
                    $('#modalFasilitas').modal('hide');
                    tblFasilitas.draw();
                    showNotif('success', 'topRight', 'Data Fasilitas', (fasilitas_id ? 'Berhasil diubah' : 'Berhasil ditambahkan'));
                } else {
                    errorMsg(data.errors, 'Form Fasilitas', 'Mohon periksa kembali! Terdapat kolom yang kosong');
                }
            },
            complete: function () {
                submitButton.removeClass('btn-progress disabled');
            }
        });
    });

    // Delete
    $('body').on('click touchstart', '#deleteData', function () {
        const fasilitas_id = $(this).data('id');
        const fasilitas_nama = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
    
        swal({
            title: `Apakah kamu yakin?`,
            text: `Jika iya, akan menghapus semua yang berkaitan dengan Fasilitas ${fasilitas_nama} secara permanen!`,
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
                    text: 'Ya, lanjutkan!',
                    value: true,
                    visible: true,
                    className: 'btn-danger',
                },
            },
            dangerMode: true,
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then((willContinue) => {
            if (willContinue) {
                swal({
                    title: 'Masukkan Password Anda',
                    content: {
                        element: 'input',
                        attributes: {
                            placeholder: 'Masukkan password',
                            type: 'password',
                        },
                    },
                    buttons: {
                        cancel: {
                            text: 'Batal',
                            value: null,
                            visible: true,
                            className: '',
                            closeModal: true
                        },
                        confirm: {
                            text: 'Hapus',
                            value: true,
                            visible: true,
                            className: 'btn-danger',
                        },
                    },
                    dangerMode: true,
                }).then((password) => {
                    if (password) {
                        $.ajax({
                            url: gets.formFasilitas + `/del/${fasilitas_id}`,
                            type: "POST",
                            data: { password: password },
                            cache: false,
                            success: function (response) {
                                if (response.success) {
                                    tblFasilitas.draw();
                                    swal('Data Berhasil Dihapus', {
                                        icon: 'success',
                                    });
                                } else {
                                    swal('Gagal Menghapus Data', response.message, {
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function () {
                                swal('Terjadi Kesalahan', 'Coba lagi nanti.', {
                                    icon: 'error',
                                });
                            },
                            complete: function () {
                                $button.prop('disabled', false);
                            }
                        });
                    } else {
                        swal('Password Tidak Diisi', 'Penghapusan dibatalkan karena password tidak diisi.', {
                            icon: 'error',
                        });
                        $button.prop('disabled', false);
                    }
                });
            } else {
                $button.prop('disabled', false);
            }
        });
    });
    
});
