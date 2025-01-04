$(document).ready(function () {
    const gets = {
        dataTagihan: `dataTagihan`,
        formTagihan: `tagihan`
    }

    let btnAll;
    const fmTagihan = $('#FTagihan');

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
        $('#bulan').removeClass('is-invalid');
        $('.checklist').remove();
        $('.info-penghuni').remove();
        $('#error-message').hide();
    }

    // Datatables
    const tblTagihan = setupDataTables('#tagihan-tbl', gets.dataTagihan, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'nama', className: 'text-center' },
        { data: 'kamar', className: 'text-center' },
        { data: 'tarif', className: 'text-center' },
        { data: 'bulan_tahun', className: 'text-center' },
        { data: 'status_transaksi', className: 'text-center' },
        { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], false, [1, 'asc'], false, true, true, 10, true);
    // End Datatables

    // Create
    $('body').on('click touchstart', '#createTagihan', function () {
        setupForm('Tagihan', 'tambah', 'Tambah Tagihan', '');

        $('#bulan').on('change', function () {
            var bulan = $(this).val();
            $('#loading-indicator').show();
            $('#data-penghuni').html('');
            
            if (bulan) {
                $('#error-message').hide();
                $.ajax({
                    url: `/tagihan/penghuni-belum-ada`,
                    type: 'GET',
                    data: { bulan: bulan },
                    success: function (response) {
                        var html = '';
                        if (response.data.length > 0) {
                            response.data.forEach(function (penghuni) {
                                html += `
                                    <div id="checklist" class="checklist col-md-4">
                                        <input class="penghuni-checkbox" type="checkbox" name="penghuni_ids[]" value="${penghuni.id}" id="${penghuni.id}">
                                        <label for="${penghuni.id}">${penghuni.nama_penghuni}</label>
                                    </div>`;
                            });
                        } else {
                            html = '<p class="text-danger m-0 info-penghuni">Semua penghuni sudah memiliki tagihan untuk bulan ini.</p>';
                        }
                        $('#data-penghuni').html(html);
                        validateCheckbox();
                    },
                    error: function () {
                        alert('Gagal memuat data penghuni.');
                    },
                    complete: function () {
                        $('#loading-indicator').hide();
                    }
                });
            }
        });
    });

    function validateCheckbox() {
        $('#tambahTagihan').on('click', function (e) {
            var checkboxes = $('.penghuni-checkbox');
            var isChecked = checkboxes.is(':checked');
            if (!isChecked) {
                e.preventDefault();
                $('#error-message').show();
                $('#bulan').removeClass('is-invalid');
            } else {
                $('#error-message').hide();
            }
        });
    }

    // Action
    fmTagihan.on('submit', function (e) {
        e.preventDefault();
        const submitButton = $(this).find('.btn-form');
        submitButton.addClass('btn-progress disabled');

        const tagihan_id = $(this).find('.btn-form').data('number');
        const url = (tagihan_id) ? `${gets.formTagihan}/${tagihan_id}` : gets.formTagihan;
        const method = (tagihan_id) ? 'PUT' : 'POST';

        $.ajax({
            data: $(this).serialize(),
            url: url,
            type: method,
            dataType: 'json',
            success: function (data) {
                if ($.isEmptyObject(data.errors)) {
                    fmTagihan[0].reset();
                    $('#modalTagihan').modal('hide');
                    tblTagihan.draw();
                    showNotif('success', 'topRight', 'Data Tagihan', (tagihan_id ? 'Berhasil diubah' : 'Berhasil ditambahkan'));
                } else {
                    errorMsg(data.errors, 'Form Tagihan', 'Mohon periksa kembali! Terdapat kolom yang kosong');
                }
            },
            complete: function () {
                submitButton.removeClass('btn-progress disabled');
            }
        });
    });

    // Delete
    $('body').on('click touchstart', '.deleteData', function () {
        const tagihan_id = $(this).data('id');
        const tagihan_nama = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `jika iya, akan menghapus Tagihan Penghuni ${tagihan_nama} secara permanen!`,
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
                    url: gets.formTagihan + `/del/${tagihan_id}`,
                    type: "POST",
                    cache: false,
                    success: function () {
                        tblTagihan.draw();
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

    // payment
    $('body').on('click touchstart', '.payCash', function () {
        const pay_id = $(this).data('id');
        const pay_name = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `ingin melanjutkan pembayaran tunai a.n Penghuni ${pay_name}!`,
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
                    text: 'Iya, bayar',
                    value: true,
                    visible: true,
                    className: 'btn-info',
                },
            },
            dangerMode: false,
            closeOnClickOutside: false,
            closeOnEsc: false
        }).then((willPay) => {
            if (willPay) {
                $.ajax({
                    url: `cash-tagihan/${pay_id}`,
                    type: "POST",
                    cache: false,
                    success: function () {
                        tblTagihan.draw();
                        swal('Pembayaran Berhasil', {
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
