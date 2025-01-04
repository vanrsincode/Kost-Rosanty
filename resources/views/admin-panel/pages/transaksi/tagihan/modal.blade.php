<div class="modal fade modal-roll" id="modalTagihan" role="dialog" aria-labelledby="MHTagihan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-sm" id="MHTagihan">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FTagihan" method="POST" enctype="multipart/form-data">
                <div class="modal-body pb-2">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="bulan">Bulan</label>
                            <input type="month" class="form-control" name="bulan" id="bulan"
                                value="{{ old('bulan') }}">
                            <div class="invalid-feedback msg-bulan"></div>
                        </div>
                        <div id="loading-indicator" style="display: none;">
                            <div class="spinner"></div>
                        </div> 
                        <div id="data-penghuni" class="row form-group col-md-12 ml-1 mb-1"></div>
                        <div id="error-message" class="form-group col-md-12 ml-2 mb-2 text-danger"
                            style="display: none;">Harap pilih setidaknya satu penghuni!</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between footerTagihan">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>
