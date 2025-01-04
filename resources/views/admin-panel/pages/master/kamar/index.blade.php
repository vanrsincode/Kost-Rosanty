@extends('admin-panel.layouts.main')

@section('title', 'Kamar')

@push('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/components/18-select2.css" loading="lazy">
@endpush

@push('css_vendor')
    @include('admin-panel.layouts.vendor-custom.cssVendor')

    <link rel="stylesheet" href="{{ asset('admin/vendor') }}/select2/dist/css/select2.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Kamar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Kelola Data</div>
                <div class="breadcrumb-item text-primary active">Kamar</div>
            </div>
        </div>

        <div class="row">
            {{-- Tabel Kamar --}}
            <div class="col-12">
                <div class="card irounded-1 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="card-title font-weight-bold" style="white-space: nowrap;">Tabel Kamar</p>
                        <button type="button" class="Btn" id="createKamar">
                            <div class="btn-ico-plus">
                                <span class="fas fa-plus"></span>
                            </div>
                            <div class="btn-text">Tambah Data</div>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="kamar-tbl">
                                <thead class="bg-primary text-white">
                                    <tr style="text-align-last: center;">
                                        {{-- <th width="10px">#</th> --}}
                                        <th>No. Kamar</th>
                                        <th>Tipe Kamar</th>
                                        <th>Tarif</th>
                                        <th width="100px">Fasilitas</th>
                                        <th width="100px">Keterangan</th>
                                        <th>Status</th>
                                        <th width="60px">Aksi</th>
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
    @include('admin-panel.pages.master.kamar.modal')
@endsection

@push('js_vendor')
    @include('admin-panel.layouts.vendor-custom.jsVendor')

    <script src="{{ asset('admin/vendor') }}/select2/dist/js/select2.full.min.js"></script>

    <script src="{{ asset('admin/vendor') }}/cleave.js/dist/cleave.min.js"></script>
@endpush

@push('js')
    @include('admin-panel.layouts.vendor-custom.jsCustom')
    <script src="{{ asset('js/page/kamar/main.js') }}"></script>
@endpush
