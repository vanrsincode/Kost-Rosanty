$(document).ready(function () {
    const gets = {
        dataPembayaran: `dataPembayaran`,
        formPembayaran: `pembayaran`
    }

    // Datatables
    const customColumnDefs = [
        {targets: [1], className: 'text-center datatable-column-ellipsis'},
        {targets: [6], className: 'text-center datatable-column-ellipsis'}
    ];
    const tblPembayaran = setupDataTables('#pembayaran-tbl', gets.dataPembayaran, [
        { data: 'DT_RowIndex', className: 'text-center', sortable: false },
        { data: 'nama'},
        { data: 'kamar', className: 'text-center' },
        { data: 'tagihan', className: 'text-center' },
        { data: 'tarif', className: 'text-center' },
        { data: 'metode', className: 'text-center' },
        { data: 'tanggal'},
        { data: 'status_transaksi', className: 'text-center' },
    ], false, [1, 'asc'], false, true, true, 10, true, customColumnDefs);
    // End Datatables
});
