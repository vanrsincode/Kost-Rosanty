$(document).ready(function () {
    const togglePassword1 = document.querySelector('#togglePassword1');
    const password1 = document.querySelector('.password1');

    togglePassword1.addEventListener('click', function (e) {
        const type1 = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type1);
        this.classList.toggle('fa-eye-slash');
    });

    const gets = {
        dataPengelola: `dataPengelola`,
        formPengelola: `hak-akses`
    }

    let btnAll;
    const fmPengelola = $('#FPengelola');

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
        $('#nama, #email, #password, #sebagai').removeClass('is-invalid');
    }

    // Datatables
    const tblPengelola = setupDataTables('#pengelola-tbl', gets.dataPengelola, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'nama', className: 'text-center' },
        { data: 'email', className: 'text-center' },
        { data: 'sebagai', className: 'text-center' },
        { data: 'last_login', className: 'text-center' },
        { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], false, [1, 'asc'], false, true, true, 10, true);
    // End Datatables

    // Create
    $('body').on('click touchstart', '#createPengelola', function () {
        setupForm('Pengelola', 'tambah', 'Tambah Pengelola', '');
    });

    // Edit
    $('body').on('click touchstart', '.editData', function () {
        const pengelola_id = $(this).data('id');
        $.ajax({
            url: gets.formPengelola + `/${pengelola_id}`,
            type: "GET",
            cache: false,
            success: function (response) {
                $('#nama').val(response.data.name);
                $('#email').val(response.data.email);
                $('#password').val(response.data.text);
                $('#sebagai').val(response.data.role);
                setupForm('Pengelola', 'ubah', 'Ubah Pengelola', pengelola_id);
            }
        });
    });

    // Action
    fmPengelola.on('submit', function (e) {
        e.preventDefault();
        const submitButton = $(this).find('.btn-form');
        submitButton.addClass('btn-progress disabled');

        const pengelola_id = $(this).find('.btn-form').data('number');
        const url = (pengelola_id) ? `${gets.formPengelola}/${pengelola_id}` : gets.formPengelola;
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
                    fmPengelola[0].reset();
                    $('#modalPengelola').modal('hide');
                    tblPengelola.draw();
                    showNotif('success', 'topRight', 'Data Pengelola', (pengelola_id ? 'Berhasil diubah' : 'Berhasil ditambahkan'));
                } else {
                    errorMsg(data.errors, 'Form Pengelola', 'Mohon periksa kembali! Terdapat kolom yang kosong');
                }
            },
            complete: function () {
                submitButton.removeClass('btn-progress disabled');
            }
        });
    });

    // Delete
    $('body').on('click touchstart', '.deleteData', function () {
        const pengelola_id = $(this).data('id');
        const pengelola_nama = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `jika iya, akan menghapus semua yang berkaitan dengan Nama ${pengelola_nama} secara permanen!`,
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
                            url: gets.formPengelola + `/del/${pengelola_id}`,
                            type: "POST",
                            data: { password: password },
                            cache: false,
                            success: function (response) {
                                if (response.success) {
                                    tblPengelola.draw();
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

    // Reset
    $('body').on('click touchstart', '.resetAkun', function () {
        const pengelola_id = $(this).data('id');
        const pengelola_nama = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `ingin mereset Akses Login Akun ${pengelola_nama}!`,
            icon: 'info',
            buttons: {
                cancel: {
                    text: 'Tidak',
                    value: null,
                    visible: true,
                    className: '',
                    closeModal: true
                },
                confirm: {
                    text: 'Reset',
                    value: true,
                    visible: true,
                    className: 'btn-info',
                },
            },
            dangerMode: false,
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `reset-pengelola/${pengelola_id}`,
                    type: "POST",
                    cache: false,
                    success: function () {
                        tblPengelola.draw();
                        swal('Data Berhasil Direset', {
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
