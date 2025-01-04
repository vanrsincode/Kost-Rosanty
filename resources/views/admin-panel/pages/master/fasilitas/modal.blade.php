<div class="modal fade modal-roll" id="modalFasilitas" role="dialog" aria-labelledby="MHFasilitas" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-sm" id="MHFasilitas">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FFasilitas" method="POST" enctype="multipart/form-data">
                <div class="modal-body pb-2">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="fasilitas">Fasilitas</label>
                            <input type="text" class="form-control" name="fasilitas" id="fasilitas" value="{{ old('fasilitas') }}" placeholder="Masukan Fasilitas">
                            <div class="invalid-feedback msg-fasilitas"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between footerFasilitas">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
