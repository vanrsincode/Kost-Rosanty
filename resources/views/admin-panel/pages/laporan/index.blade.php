@extends('admin-panel.layouts.main')

@section('title', 'Laporan')

@push('css_vendor')
    @include('admin-panel.layouts.vendor-custom.cssVendor')
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Laporan</h1>

            <div class="section-header-breadcrumb">
                <form id="filter-form">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-5 p-0 mr-1">
                                <input type="month" class="form-control rounded-pill" name="start_month" id="start-month" required>
                            </div>
                            <div class="col-5 p-0 mr-2">
                                <input type="month" class="form-control rounded-pill" name="end_month" id="end-month">
                            </div>
                            <div class="col-1 p-0">
                                <button type="submit" class="btn btn-primary rounded-circle" title="Cari">
                                    <i class="fas fa-search" style="font-size: 10px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card irounded-1 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="card-title font-weight-bold" style="white-space: nowrap;">Tabel Laporan Transaksi</p>
                        <button type="button" class="btn btn-primary" id="cetak-pdf" style="display: none;" title="Generate PDF"><i class="fas fa-print"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="laporan-tbl">
                                <thead class="bg-primary text-white">
                                    <tr style="text-align-last: center;">
                                        <th width="20px">#</th>
                                        <th>Nama Penghuni</th>
                                        <th>Kamar</th>
                                        <th>Tagihan</th>
                                        <th>Tarif</th>
                                        <th>Status Pembayaran</th>
                                        <th>Metode Pembayaran</th>
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

@push('js_vendor')
    @include('admin-panel.layouts.vendor-custom.jsVendor')
@endpush

@push('js')
    @include('admin-panel.layouts.vendor-custom.jsCustom')
    <script src="{{ asset('js/page/laporan/main.js') }}"></script>
@endpush
