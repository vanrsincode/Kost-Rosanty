<div class="modal fade modal-roll" id="modalKamar" role="dialog" aria-labelledby="MHKamar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-sm" id="MHKamar">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FKamar" method="POST" enctype="multipart/form-data">
                <div class="modal-body pb-2">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="no_kamar">Nomor Kamar</label>
                            <input type="text" class="form-control" name="no_kamar" id="no_kamar"
                                value="{{ old('no_kamar') }}" placeholder="Masukan Nomor Kamar">
                            <div class="invalid-feedback msg-no_kamar"></div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="tipe">Tipe Kamar</label>
                            <select name="tipe" id="tipe" class="form-control select2">
                                {{-- Tipe A = Rp. 500.000 --}}
                                {{-- Tipe B = Rp. 400.000 --}}
                                <option value="">-- Pilih Tipe Kamar --</option>
                            </select>
                            <div class="invalid-feedback msg-tipe"></div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="harga">Harga Kamar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                </div>
                                <input type="text" class="form-control currency" placeholder="Masukan Harga Kamar"
                                    name="harga" id="harga" value="{{ old('harga') }}" readonly>
                                <div class="invalid-feedback msg-harga"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="selfasilitas">Fasilitas</label>
                            <select class="form-control"  id="selfasilitas" name="selfasilitas[]">

                            </select>
                            <div class="invalid-feedback msg-selfasilitas"></div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" style="height:100px;"></textarea>
                            <div class="invalid-feedback msg-keterangan"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between footerKamar">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
