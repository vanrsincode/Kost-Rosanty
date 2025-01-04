<div class="modal fade modal-roll" id="modalPenyewaKamar" role="dialog" aria-labelledby="MHPenyewaKamar" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-sm" id="MHPenyewaKamar">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FPenyewaKamar" method="POST" enctype="multipart/form-data">
                <div class="modal-body pb-2">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="nama">Nama Penghuni</label>
                                            <input type="text" class="form-control" name="nama" id="nama"
                                                value="{{ old('nama') }}" placeholder="Masukan Nama Penghuni">
                                            <div class="invalid-feedback msg-nama"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nik">NIK</label>
                                            <input type="number" class="form-control" name="nik" id="nik"
                                                value="{{ old('nik') }}" placeholder="Masukan NIK Penghuni">
                                            <div class="invalid-feedback msg-nik"></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                                value="{{ old('tempat_lahir') }}" placeholder="Masukan Tempat Lahir">
                                            <div class="invalid-feedback msg-tempat_lahir"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                                value="{{ old('tgl_lahir') }}">
                                            <div class="invalid-feedback msg-tgl_lahir"></div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ old('email') }}" placeholder="Masukan Email">
                                            <div class="invalid-feedback msg-email"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="no_wa">No. WhatsApp</label>
                                            <input type="number" class="form-control" name="no_wa" id="no_wa"
                                                value="{{ old('no_wa') }}" placeholder="Masukan No. WhatsApp">
                                            <div class="invalid-feedback msg-no_wa"></div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="alamat" style="height:100px;"></textarea>
                                            <div class="invalid-feedback msg-alamat"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kamar --}}
                        <div class="col-md-5">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="selkamar">Kamar</label>
                                            <select class="form-control" name="selkamar" id="selkamar">
                                                <option value="">-- Pilih Kamar --</option>
                                            </select>
                                            <div class="invalid-feedback msg-selkamar"></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Detail Kamar</label>
                                            <table class="table mt-2" id="kamarDetailTable" style="display:none;">
                                                <tbody id="kamarDetailBody">
                                                    <!-- Room details will be inserted here -->
                                                </tbody>
                                            </table>
                                            <p id="kamarDetailText">Pilih kamar untuk melihat detail</p>
                                            <p id="errorText" style="display: none; color: red;">Terjadi kesalahan saat mengambil data kamar.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between footerPenyewaKamar">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
