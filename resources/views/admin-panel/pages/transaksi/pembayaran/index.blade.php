@extends('admin-panel.layouts.main')

@section('title', 'Pembayaran')

@push('css_vendor')
    @include('admin-panel.layouts.vendor-custom.cssVendor')
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Pembayaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Transaksi</div>
                <div class="breadcrumb-item text-primary active">Pembayaran</div>
            </div>
        </div>

        <div class="row">
            {{-- Tabel Pembayaran --}}
            <div class="col-12">
                <div class="card irounded-1 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="card-title font-weight-bold" style="white-space: nowrap;">Tabel Pembayaran</p>
                        {{-- <button type="button" class="Btn" id="createPembayaran">
                            <div class="btn-ico-plus">
                                <span class="fas fa-plus"></span>
                            </div>

                            <div class="btn-text">Tambah Data</div>
                        </button> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="pembayaran-tbl">
                                <thead class="bg-primary text-white">
                                    <tr style="text-align-last: center;">
                                        <th width="20px">#</th>
                                        <th>Nama Penghuni</th>
                                        <th>Kamar</th>
                                        <th>Tagihan</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Status</th>
                                        {{-- <th width="60px">Aksi</th> --}}
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
    {{-- @include('admin-panel.transaksi.pembayaran.modal') --}}
@endsection

@push('js_vendor')
    @include('admin-panel.layouts.vendor-custom.jsVendor')
@endpush

@push('js')
    @include('admin-panel.layouts.vendor-custom.jsCustom')
    <script src="{{ asset('js/page/pembayaran/main.js') }}"></script>
@endpush
