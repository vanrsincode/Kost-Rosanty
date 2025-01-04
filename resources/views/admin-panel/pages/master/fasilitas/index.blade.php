@extends('admin-panel.layouts.main')

@section('title', 'Fasilitas')

@push('css_vendor')
    @include('admin-panel.layouts.vendor-custom.cssVendor')
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Fasilitas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Kelola Data</div>
                <div class="breadcrumb-item text-primary active">Fasilitas</div>
            </div>
        </div>

        <div class="row">
            {{-- Tabel Fasilitas --}}
            <div class="col-12">
                <div class="card irounded-1 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="card-title font-weight-bold" style="white-space: nowrap;">Tabel Fasilitas</p>
                        <button type="button" class="Btn" id="createFasilitas">
                            <div class="btn-ico-plus">
                                <span class="fas fa-plus"></span>
                            </div>
                            <div class="btn-text">Tambah Data</div>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="fasilitas-tbl">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        {{-- <th width="50px">No</th> --}}
                                        <th>Fasilitas</th>
                                        <th class="text-center" width="13%">Aksi</th>
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
    @include('admin-panel.pages.master.fasilitas.modal')
@endsection

@push('js_vendor')
    @include('admin-panel.layouts.vendor-custom.jsVendor')
@endpush

@push('js')
    @include('admin-panel.layouts.vendor-custom.jsCustom')
    <script src="{{ asset('js/page/fasilitas/main.js') }}"></script>
@endpush
