const urlTableID = 'admin/assets/js/language/datatables/idCustom-datatables.json'
const urlSelID = {
    errorLoading: function () {
        return "Gagal mengambil hasil";
    },
    inputTooLong: function (args) {
        var overChars = args.input.length - args.maximum;
        return "Silakan hapus " + overChars + " karakter";
    },
    inputTooShort: function (args) {
        var remainingChars = args.minimum - args.input.length;
        return "Silakan masukkan " + remainingChars + " karakter atau lebih";
    },
    loadingMore: function () {
        return "Mengambil lebih banyak hasil…";
    },
    maximumSelected: function (args) {
        return "Anda hanya dapat memilih " + args.maximum + " pilihan";
    },
    noResults: function () {
        return "Tidak ada hasil yang ditemukan";
    },
    searching: function () {
        return "Mencari…";
    },
    minimumInputLength: function (args) {
        return "Masukkan setidaknya " + args.minimum + " karakter";
    }
}

// Data Users
const urlDataUsers = `dataUsers`
const urlFormUsers = `kelola-pengguna`

// Profile
const urlProfile = `getDataProfile`
const urlFormProfile = `profile`

// Master
    // Outlet
    const urlDataOutlet = `dataOutlets`
    const urlFormOutlet = `outlet`
    // End Outlet

    // Paket
    const urlSelectPaket = `select-paket-outlet`
    const urlDataPaket = `dataPakets`
    const urlFormPaket = `paket`

    const urlDataJenisPaket = `dataJenisPakets`
    const urlFormJenisPaket = `jenis-paket`
    // End Paket

    // Layanan
    const urlDataLayanan = `dataLayanan`
    const urlFormLayanan = `layanan`

    const urlDataJenisLayanan = `dataJenisLayanan`
    const urlFormJenisLayanan = `jenis-layanan`
    // End Layanan

    // Pelanggan
    const urlDataPelanggan = `dataPelanggans`
    const urlFormPelanggan = `pelanggan`
    // End Pelanggan

    // Sumber
    const urlDataSumber = `dataSumbers`
    const urlFormSumber = `sumber-keuangan`
    // End Sumber
// End Master

// Pencatatan
// Pemasukan
const urlDataPemasukan = `dataPemasukans`
const urlFormPemasukan = `pemasukan`
// End Pemasukan

// Pengeluaran
const urlDataPengeluaran = `dataPengeluarans`
const urlFormPengeluaran = `pengeluaran`
// End Pengeluaran
// End Pencatatan

// Laundry
// Select2
const urlSearchPelanggan = `search-pelanggan`

// Get Data
const urlGetPelanggan = `get-dataPelanggan`
const urlGetLayanan = `get-dataLayanan`

const urlGetJenisLayananDataLayananID = `get-dataJenisLayananDataLayananID`
const urlGetJenisLayanan = `get-dataJenisLayanan`

// DataTables
const urlDataLaundryTuntas = `dataLaundryTuntas`
const urlDataLaundryPengambilan = `dataLaundryPengambilan`
const urlDataLaundryProses = `dataLaundryProses`

// CRUD
const urlFormLaundry = `laundry`
const urlFormLaundryPencucian = `status-pencucian`
const urlFormLaundryPengambilan = `status-pengambilan`
const urlFormLaundryPembayaran = `status-pembayaran`
// End Laundry
