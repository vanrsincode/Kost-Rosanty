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
