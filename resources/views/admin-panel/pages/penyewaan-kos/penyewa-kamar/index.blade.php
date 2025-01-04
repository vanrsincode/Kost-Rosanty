@extends('admin-panel.layouts.main')

@section('title', 'Penyewa Kamar')

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
            <h1>Penyewa Kamar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Penyewaan Kos</div>
                <div class="breadcrumb-item text-primary active">Penyewa Kamar</div>
            </div>
        </div>

        <div class="row">
            {{-- Tabel Penyewa Kamar --}}
            <div class="col-12">
                <div class="card irounded-1 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p class="card-title font-weight-bold" style="white-space: nowrap;">Tabel Penyewa Kamar</p>
                        <button type="button" class="Btn" id="createPenyewaKamar">
                            <div class="btn-ico-plus">
                                <span class="fas fa-plus"></span>
                            </div>

                            <div class="btn-text">Tambah Data</div>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap" id="penyewa-kamar-tbl">
                                <thead class="bg-primary text-white">
                                    <tr style="text-align-last: center;">
                                        <th width="20px">#</th>
                                        <th>Nama Penghuni</th>
                                        <th>Kamar</th>
                                        <th>Harga</th>
                                        <th>Tanggal Sewa</th>
                                        <th>No. WhatsApp</th>
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
    @include('admin-panel.pages.penyewaan-kos.penyewa-kamar.modal')
@endsection

@push('js_vendor')
    @include('admin-panel.layouts.vendor-custom.jsVendor')

    <script src="{{ asset('admin/vendor') }}/select2/dist/js/select2.full.min.js"></script>
@endpush

@push('js')
    @include('admin-panel.layouts.vendor-custom.jsCustom')
    <script src="{{ asset('js/page/penyewa-kamar/main.js') }}"></script>
@endpush
