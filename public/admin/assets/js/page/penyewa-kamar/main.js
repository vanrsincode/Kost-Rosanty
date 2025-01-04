$(document).ready(function () {
    const gets = {
        dataSewaKamar: `dataSewaKamar`,
        formSewaKamar: `penyewa-kamar`
    }

    let btnAll;
    const fmSewaKamar = $('#FPenyewaKamar');
    const selKamar = $('#selkamar');

    function setupForm(form, mode, title, id) {
        // select2
        selKamar.select2({
            placeholder: "-- Pilih Kamar --",
            ajax: {
                url: `selectKamar`,
                dataType: 'json',
                delay: 100,
                cache: true,
                data: params => ({ term: params.term }),
                processResults: data => {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.status_kamar == 'Terpakai' ? `${item.nomor_kamar} | ${item.sewa_kamar[0].penghuni.nama_penghuni}` : item.nomor_kamar,
                            disabled: item.status_kamar == 'Terpakai'
                        }))
                    };
                },
            },
            language: urlSelID
        });
        selKamar.on('change', function () {
            const kamarId = $(this).val();
            updateKamarDetail(kamarId);
        });
        // end

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
        $('#nama, #nik, #tempat_lahir, #tgl_lahir, #email, #no_wa, #alamat, #selkamar').removeClass('is-invalid');
    }

    // Datatables
    const tblSewaKamar = setupDataTables('#penyewa-kamar-tbl', gets.dataSewaKamar, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'nama', className: 'text-center' },
        { data: 'kamar_tipe', className: 'text-center' },
        { data: 'harga', className: 'text-center' },
        { data: 'tgl_sewa', className: 'text-center' },
        { data: 'no_wa', className: 'text-center' },
        { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], false, [1, 'asc'], false, true, true, 10, true);
    // End Datatables

    // Create
    $('body').on('click touchstart', '#createPenyewaKamar', function () {
        setupForm('PenyewaKamar', 'tambah', 'Tambah Penyewa Kamar', '');
        updateKamarDetail(0)
        selKamar.val([null]).trigger("change.select2");
    });

    // Edit
    $('body').on('click touchstart', '.editData', function () {
        const sewakamar_id = $(this).data('id');
        $.ajax({
            url: gets.formSewaKamar + `/${sewakamar_id}`,
            type: "GET",
            cache: false,
            success: function (response) {
                const data = response.data;
                $('#nama').val(data.penghuni.nama);
                $('#nik').val(data.penghuni.nik);
                $('#tempat_lahir').val(data.penghuni.tempat_lahir);
                $('#tgl_lahir').val(data.penghuni.tgl_lahir);
                $('#email').val(data.penghuni.user.email);
                $('#no_wa').val(data.penghuni.no_wa);
                $('#alamat').val(data.penghuni.alamat);

                selKamar.empty().append(`<option value="${data.kamar.id}">${data.kamar.nomor_kamar}</option>`).trigger('change.select2');

                updateKamarDetail(data.kamar.id)

                setupForm('PenyewaKamar', 'ubah', 'Ubah Penyewa Kamar', sewakamar_id);
            }
        });
    });

    // Action
    fmSewaKamar.on('submit', function (e) {
        e.preventDefault();
        const submitButton = $(this).find('.btn-form');
        submitButton.addClass('btn-progress disabled');

        const sewakamar_id = $(this).find('.btn-form').data('number');
        const url = (sewakamar_id) ? `${gets.formSewaKamar}/${sewakamar_id}` : gets.formSewaKamar;
        // const method = (sewakamar_id) ? 'PUT' : 'POST';
        const formData = new FormData(this);
        // const formData = $(this).serialize();

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
                    fmSewaKamar[0].reset();
                    $('#modalPenyewaKamar').modal('hide');
                    tblSewaKamar.draw();
                    showNotif('success', 'topRight', 'Data Penyewa Kamar', (sewakamar_id ? 'Berhasil diubah' : 'Berhasil ditambahkan'));
                } else {
                    errorMsg(data.errors, 'Form Penyewa Kamar', 'Mohon periksa kembali! Terdapat kolom yang kosong atau tidak sesuai');
                }
            },
            complete: function () {
                submitButton.removeClass('btn-progress disabled');
            }
        });
    });

    // Delete
    $('body').on('click touchstart', '.deleteData', function () {
        const sewakamar_id = $(this).data('id');
        const sewakamar_nama = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `jika iya, akan menghapus semua yang berkaitan dengan Penghuni ${sewakamar_nama} secara keseluruhan!`,
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
                    url: gets.formSewaKamar + `/${sewakamar_id}`,
                    type: "DELETE",
                    cache: false,
                    success: function () {
                        tblSewaKamar.draw();
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

    function updateKamarDetail(kamarId) {
        const kamarDetailTable = document.getElementById('kamarDetailTable');
        const kamarDetailBody = document.getElementById('kamarDetailBody');
        const kamarDetailText = document.getElementById('kamarDetailText');
        const errorText = document.getElementById('errorText');

        kamarDetailBody.innerHTML = '';
        errorText.style.display = 'none';

        if (kamarId) {
            $.ajax({
                url: `kamar/` + kamarId,
                method: 'GET',
                data: $(this).serialize(),
                success: function (response) {
                    if ($.isEmptyObject(response.errors)) {
                        const kamar = response.data;
                        const fasilitasList = kamar.fasilitas.length > 0
                            ? kamar.fasilitas.map(f => f.nama_fasilitas).join(', ')
                            : 'Tanpa Fasilitas';

                        const formattedHarga = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }).format(kamar.harga);

                        kamarDetailBody.innerHTML = `
                            <tr>
                                <th class="p-1 align-top h-25"><p class='font-weight-bold mb-1'>Nomor</p></th>
                                <td class="p-1 align-top h-25"><p class="mb-1">: ${kamar.no_kamar}</p></td>
                            </tr>
                            <tr>
                                <th class="p-1 align-top h-25"><p class='font-weight-bold mb-1'>Tipe</p></th>
                                <td class="p-1 align-top h-25"><p class="mb-1">: ${kamar.tipe}</p></td>
                            </tr>
                            <tr>
                                <th class="p-1 align-top h-25"><p class='font-weight-bold mb-1'>Harga</p></th>
                                <td class="p-1 align-top h-25"><p class="mb-1">: ${formattedHarga}</p></td>
                            </tr>
                            <tr>
                                <th class="p-1 align-top h-25"><p class='font-weight-bold mb-1'>Fasilitas</p></th>
                                <td class="p-1 align-top h-25"><p class="mb-1">: ${fasilitasList}</p></td>
                            </tr>
                            <tr>
                                <th class="p-1 align-top h-25"><p class='font-weight-bold mb-1'>Status</p></th>
                                <td class="p-1 align-top h-25"><p class="mb-1">: ${kamar.status_kamar}</p></td>
                            </tr>
                            <tr>
                                <th class="p-1 align-top h-25"><p class='font-weight-bold mb-1'>Keterangan</p></th>
                                <td class="p-1 align-top h-25"><p class="mb-1">: ${kamar.keterangan.replace(/\n/g, '<br>')}</p></td>
                            </tr>`;
                        kamarDetailTable.style.display = 'table';
                        kamarDetailText.style.display = 'none';
                    } else {
                        kamarDetailTable.style.display = 'none';
                        kamarDetailText.style.display = 'block';
                        errorText.style.display = 'block';
                        errorText.textContent = 'Data kamar tidak ditemukan.';
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    kamarDetailTable.style.display = 'none';
                    kamarDetailText.style.display = 'block';
                    errorText.style.display = 'block';
                    errorText.textContent = `Terjadi kesalahan: ${textStatus} - ${errorThrown}`;
                    console.error('Error fetching kamar detail:', textStatus, errorThrown);
                }
            });
        } else {
            kamarDetailTable.style.display = 'none';
            kamarDetailText.style.display = 'block';
        }
    }
});
