<div class="modal fade modal-roll" id="modalPengelola" role="dialog" aria-labelledby="MHPengelola" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-sm" id="MHPengelola">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FPengelola" method="POST" enctype="multipart/form-data">
                <div class="modal-body pb-2">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Masukan Nama">
                            <div class="invalid-feedback msg-nama"></div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="Masukan Email" name="email" id="email" value="{{ old('email') }}" autocomplete="off">
                            <div class="invalid-feedback msg-email"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control password1" placeholder="Masukan Password" name="password" id="password">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="far fa-eye" id="togglePassword1"></i></span>
                                </div>
                                <div class="invalid-feedback msg-password"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="sebagai">Sebagai</label>
                            <select class="custom-select" name="sebagai" id="sebagai" value="{{ old('sebagai') }}">
                                <option value="1">Administrator</option>
                                <option value="3">Pemilik</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between footerPengelola">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
