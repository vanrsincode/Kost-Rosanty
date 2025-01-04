<div class="modal fade modal-roll" id="modalFeedback" role="dialog" aria-labelledby="MHFeedback" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-sm" id="MHFeedback">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FFeedback" method="POST" enctype="multipart/form-data">
                <div class="modal-body pb-2">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="pesan">Pesan</label>
                            <textarea class="form-control" name="pesan" id="pesan" style="height:100px;"></textarea>
                            <div class="invalid-feedback msg-pesan"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between footerFeedback">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
