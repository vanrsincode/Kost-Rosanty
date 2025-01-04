const urlTableID = 'admin/assets/js/language/datatables/idCustom-datatables.json';
const urlSelID = {
    errorLoading: () => "Gagal mengambil hasil",
    inputTooLong: args => `Silakan hapus ${args.input.length - args.maximum} karakter`,
    inputTooShort: args => `Silakan masukkan ${args.minimum - args.input.length} karakter atau lebih`,
    loadingMore: () => "Mengambil lebih banyak hasil…",
    maximumSelected: args => `Anda hanya dapat memilih ${args.maximum} pilihan`,
    noResults: () => "Tidak ada hasil yang ditemukan",
    searching: () => "Mencari…",
    minimumInputLength: args => `Masukkan setidaknya ${args.minimum} karakter`,
};
