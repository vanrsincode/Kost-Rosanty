@extends('admin-panel.layouts.main')

@section('title', 'Tagihan')

@push('css_vendor')
    @include('admin-panel.layouts.vendor-custom.cssVendor')
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('admin') }}/assets/css/checkbox.css" loading="lazy">
<style>
#loading-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 9999;
}
.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #b7b7b7;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Tagihan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Transaksi</div>
                <div class="breadcrumb-item text-primary active">Tagihan</div>
            </div>
        </div>

        <div class="row">
            {{-- Tabel Tagihan --}}
            <div class="col-12">
                <div class="card irounded-1 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="card-title font-weight-bold" style="white-space: nowrap;">Tabel Tagihan</p>
                        <button type="button" class="Btn" id="createTagihan">
                            <div class="btn-ico-plus">
                                <span class="fas fa-plus"></span>
                            </div>

                            <div class="btn-text">Tambah Data</div>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="tagihan-tbl">
                                <thead class="bg-primary text-white">
                                    <tr style="text-align-last: center;">
                                        <th width="20px">#</th>
                                        <th>Nama Penghuni</th>
                                        <th>Kamar</th>
                                        <th>Harga</th>
                                        <th>Bulan</th>
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
    @include('admin-panel.pages.transaksi.tagihan.modal')
@endsection

@push('js_vendor')
    @include('admin-panel.layouts.vendor-custom.jsVendor')
@endpush

@push('js')
    @include('admin-panel.layouts.vendor-custom.jsCustom')
    <script src="{{ asset('js/page/tagihan/main.js') }}"></script>
@endpush
