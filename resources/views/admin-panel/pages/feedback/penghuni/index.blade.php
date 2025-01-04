@extends('admin-panel.layouts.main')

@section('title', 'Feedback')

@push('css_vendor')
    @include('admin-panel.layouts.vendor-custom.cssVendor')
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Feedback</h1>
        </div>

        <div class="row">
            {{-- Tabel Feedback --}}
            <div class="col-12">
                <div class="card irounded-1 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="card-title font-weight-bold" style="white-space: nowrap;">Tabel Feedback</p>
                        <button type="button" class="Btn" id="createFeedback">
                            <div class="btn-ico-plus">
                                <span class="fas fa-plus"></span>
                            </div>
                            <div class="btn-text">Tambah Data</div>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="feedbackphn-tbl">
                                <thead class="bg-primary text-white">
                                    <tr style="text-align-last: center;">
                                        <th width="40px">#</th>
                                        <th width="250px">Tanggal</th>
                                        <th>Pesan</th>
                                        <th width="150px">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    @include('admin-panel.pages.feedback.penghuni.modal')
@endsection

@push('js_vendor')
    @include('admin-panel.layouts.vendor-custom.jsVendor')
@endpush

@push('js')
    <script src="{{ asset('js/custom/customIDPenghuni.js') }}"></script>
    <script defer src="{{ asset('js/custom/customAll.js') }}"></script>
    <script defer src="{{ asset('js/custom/customErrors.js') }}"></script>
    <script src="{{ asset('js/page/feedback/main.js') }}"></script>
@endpush
