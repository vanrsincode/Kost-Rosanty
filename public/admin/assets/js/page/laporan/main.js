$(document).ready(function () {
    const gets = {
        laporanFilter: 'laporan/filter',
        cetakLaporan: 'laporan/cetak',
    }

    // Datatables
    const tblLaporan = setupDataTables('#laporan-tbl', gets.laporanFilter, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'nama', className: 'text-center' },
        { data: 'kamar', className: 'text-center' },
        { data: 'tagihan', className: 'text-center' },
        { data: 'tarif', className: 'text-center' },
        { data: 'status_pembayaran', className: 'text-center' },
        { data: 'metode_pembayaran', className: 'text-center' },
    ], false, [1, 'asc'], false, true, true, 10, true);
    // End Datatables

    $('#filter-form').submit(function(e) {
        e.preventDefault();
        const startMonth = $('#start-month').val();
        const endMonth = $('#end-month').val();

        $('#cetak-pdf').show();

        // Kirim permintaan AJAX untuk memperbarui data tabel
        tblLaporan.ajax.url(gets.laporanFilter + "?start_month=" + startMonth + "&end_month=" + endMonth).load();
    });

    $('#cetak-pdf').on('click', function() {
        const startMonth = $('#start-month').val();
        const endMonth = $('#end-month').val();
        const url = new URL(gets.cetakLaporan, window.location.origin);
        url.searchParams.append('start_month', startMonth);
        url.searchParams.append('end_month', endMonth);
        window.location.href = url.toString();
    });
});
