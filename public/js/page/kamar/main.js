$(document).ready(function () {
    const gets = {
        dataKamar: `dataKamar`,
        formKamar: `kamar`,
    }

    const hargaKamar = new Cleave('#harga', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });

    let btnAll;
    const fmKamar = $('#FKamar');
    const selFasilitas = $('#selfasilitas');
    const selTipeKamar = $('#tipe');
    const dataTipeKamar = [
        { id: 'Tipe A', text: 'Tipe A' },
        { id: 'Tipe B', text: 'Tipe B' },
        { id: 'Custom', text: 'Custom' }
    ];

    function setupForm(form, mode, title, id) {
        selFasilitas.select2({
            placeholder: "-- Pilih Fasilitas --",
            allowClear: true,
            multiple: true,
            ajax: {
                url: `selectFasilitas`,
                dataType: 'json',
                delay: 100,
                cache: true,
                data: params => ({ term: params.term }),
                processResults: data => {
                    return { results: data.map(item => ({ id: item.id, text: item.nama_fasilitas })) };
                },
            },
            language: urlSelID
        });

        selTipeKamar.select2({
            placeholder: "-- Pilih Tipe Kamar --",
            data: dataTipeKamar
        })

        selTipeKamar.on('change', function () {
            const selectedValue = $(this).val();
            const hargaInput = $('#harga');

            hargaInput.val('');
            hargaInput.prop('readonly', true);

            if (selectedValue === 'Tipe A') {
                hargaKamar.setRawValue(500000);
                $.ajax({
                    url: `selectFasilitas`,
                    type: "GET",
                    cache: false,
                    success: function (response) {
                        selFasilitas.empty().append(
                            response
                                .filter(fasilitas => fasilitas.nama_fasilitas !== "Kamar Mandi Luar")
                                .map(fasilitas =>
                                    `<option value="${fasilitas.id}" selected>${fasilitas.nama_fasilitas}</option>`
                                )
                        ).trigger('change');
                    }
                });
            } else if (selectedValue === 'Tipe B') {
                hargaKamar.setRawValue(400000);
                $.ajax({
                    url: `selectFasilitas`,
                    type: "GET",
                    cache: false,
                    success: function (response) {
                        selFasilitas.empty().append(
                            response
                                .filter(fasilitas =>
                                    fasilitas.nama_fasilitas !== "Kamar Mandi Dalam" &&
                                    fasilitas.nama_fasilitas !== "AC"
                                )
                                .map(fasilitas =>
                                    `<option value="${fasilitas.id}" selected>${fasilitas.nama_fasilitas}</option>`
                                )
                        ).trigger('change');
                    }
                });
            } else if (selectedValue === 'Custom') {
                hargaInput.prop('readonly', false);
                selFasilitas.val([null]).trigger("change.select2");
            }
        });

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
        $('#no_kamar, #tipe, #harga, #fasilitas, #keterangan').removeClass('is-invalid');
    }

    // Datatables
    const customColumnDefs = [
        { targets: [4], className: 'datatable-column-ellipsis' },
        { targets: [3], className: 'text-center datatable-column-ellipsis' }
    ];
    const tblKamar = setupDataTables('#kamar-tbl', gets.dataKamar, [
        // { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'no_kamar', className: 'text-center' },
        { data: 'tipe', className: 'text-center', sortable: false },
        { data: 'harga', className: 'text-center', sortable: false },
        { data: 'fasilitas', sortable: false, render: function (data, type, row) { return data ? data.replace(/\\n/g, '<br>') : ''; } },
        { data: 'keterangan', sortable: false, render: function (data, type, row) { return data ? data.replace(/\n/g, '<br>') : ''; } },
        { data: 'status', className: 'text-center'},
        { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], true, [0, 'desc'], false, true, true, 5, true, customColumnDefs);
    // End Datatables

    // Create
    $('body').on('click touchstart', '#createKamar', function () {
        setupForm('Kamar', 'tambah', 'Tambah Kamar', '');
        selFasilitas.val([null]).trigger("change.select2");
        selTipeKamar.val([null]).trigger("change.select2");
    });

    // Edit
    $('body').on('click touchstart', '#editData', function () {
        const kmr_id = $(this).data('id');
        selFasilitas.val([null]).trigger("change");
        selTipeKamar.val([null]).trigger("change.select2");
        $.ajax({
            url: gets.formKamar + `/${kmr_id}`,
            type: "GET",
            cache: false,
            success: function (response) {
                const kamar = response.data;
                $('#no_kamar').val(kamar.no_kamar);
                $('#keterangan').val(kamar.keterangan);
                hargaKamar.setRawValue(kamar.harga);

                if (kamar.tipe == null) {
                    selTipeKamar.val([null]).trigger('change.select2');
                } else {
                    selTipeKamar.empty().append(`<option value="${kamar.tipe}">${kamar.tipe}</option>`).trigger('change.select2');
                }

                const fragment = document.createDocumentFragment();
                kamar.fasilitas.forEach(fasilitas => {
                    const option = document.createElement('option');
                    option.value = fasilitas.id;
                    option.textContent = fasilitas.nama_fasilitas;
                    option.selected = true;
                    fragment.appendChild(option);
                });
                selFasilitas.empty().append(fragment).trigger('change');

                setupForm('Kamar', 'ubah', 'Ubah Kamar', kmr_id);
            }
        });
    });

    // Action
    fmKamar.on('submit', function (e) {
        e.preventDefault();
        const submitButton = $(this).find('.btn-form');
        submitButton.addClass('btn-progress disabled');

        const kmr_id = $(this).find('.btn-form').data('number');
        const url = (kmr_id) ? `${gets.formKamar}/${kmr_id}` : gets.formKamar;
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
                    fmKamar[0].reset();
                    $('#modalKamar').modal('hide');
                    tblKamar.draw();
                    showNotif('success', 'topRight', 'Data Kamar', (kmr_id ? 'Berhasil diubah' : 'Berhasil ditambahkan'));
                } else {
                    errorMsg(data.errors, 'Form Kamar', 'Mohon periksa kembali! Terdapat kolom yang kosong');
                }
            },
            complete: function () {
                submitButton.removeClass('btn-progress disabled');
            }
        });
    });

    // Delete
    $('body').on('click touchstart', '#deleteData', function () {
        const kmr_id = $(this).data('id');
        const kms_nama = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `jika iya, akan menghapus semua yang berkaitan dengan Kamar ${kms_nama} secara permanen!`,
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
                            url: gets.formKamar + `/del/${kmr_id}`,
                            type: "POST",
                            data: { password: password },
                            cache: false,
                            success: function (response) {
                                if (response.success) {
                                    tblKamar.draw();
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
