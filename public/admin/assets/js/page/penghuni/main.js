$(document).ready(function () {
    const gets = {
        dataPenghuni: `dataPenghuni`
    }

    // Datatables
    const tblPenghuni = setupDataTables('#penghuni-tbl', gets.dataPenghuni, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'email', className: 'text-center' },
        { data: 'nama', className: 'text-center' },
        { data: 'nik', className: 'text-center' },
        { data: 'no_wa', className: 'text-center' },
        { data: 'last_login', className: 'text-center' },
        { data: 'action', searchable: false, sortable: false, className: 'text-center' }
    ], false, [0, 'asc'], false, true, true, 10, true);
    // End Datatables
    
    // Reset Akun
    $('body').on('click touchstart', '.resetAkun', function () {
        const penghuni_id = $(this).data('id');
        const penghuni_nama = $(this).data('nama');
        const $button = $(this);
        $button.prop('disabled', true);
        swal({
            title: `Apakah kamu yakin?`,
            text: `ingin mereset Akses Login Akun ${penghuni_nama}!`,
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
                    url: `reset-penghuni/${penghuni_id}`,
                    type: "POST",
                    cache: false,
                    success: function () {
                        tblPenghuni.draw();
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
