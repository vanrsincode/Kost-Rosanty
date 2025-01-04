@extends('admin-panel.layouts.main')

@section('title', 'Riwayat')

@push('css')
<link rel="stylesheet" href="{{ asset('admin') }}/assets/css/components/37-invoice.css" loading="lazy">
@endpush
@push('css_vendor')
    @include('admin-panel.layouts.vendor-custom.cssVendor')
@endpush

@section('content')
    <section class="section">
        <div class="section-header irounded-1 shadow">
            <h1>Riwayat</h1>
        </div>

        <div class="invoice irounded-1 shadow">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title mb-5">
                            <h4 style="white-space: nowrap;">Detail Riwayat</h4>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Data Pribadi :</strong><br>
                                    {{ $penghuni->nama_penghuni }}<br>
                                    {{ $penghuni->tempat_lahir . ', ' . \Carbon\Carbon::parse($penghuni->tanggal_lahir)->isoFormat('DD MMMM Y') }}<br>
                                    {{ $penghuni->telepon_penghuni }}<br>
                                    {!! nl2br(e($penghuni->alamat_penghuni)) !!}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Kamar :</strong><br>
                                    {{ $sewakamar->kamar->nomor_kamar . ' / ' . $sewakamar->kamar->tipe_kamar }}<br>
                                    <strong>Fasilitas :</strong><br>
                                    @foreach ($sewakamar->kamar->fasilitas as $index => $fasilitas)
                                        {{ $fasilitas->nama_fasilitas }}@if (!$loop->last),
                                        @endif
                                        @if (($index + 1) % 4 == 0)
                                            <br>
                                        @endif
                                    @endforeach
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Pembayaran :</strong><br>
                                    Per Bulan : Rp. {{ number_format($sewakamar->kamar->harga_kamar, 0, ',', '.') }}<br>
                                    Total Tagihan : Rp. {{ number_format($totalTagihan, 0, ',', '.') }}
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Tanggal Masuk Kos :</strong><br>
                                    {{ \Carbon\Carbon::parse($sewakamar->tgl_awal_sewa)->isoFormat('DD MMMM Y') }}
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">Detail Pembayaran</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th data-width="40">#</th>
                                    <th>Tagihan</th>
                                    <th class="text-center">Tarif</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                @foreach ($transaksis as $index => $transaksi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::createFromFormat('m', $transaksi->bulan_tagihan)->isoFormat('MMMM') }}
                                        </td>
                                        <td class="text-center">Rp.
                                            {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $transaksi->status_transaksi }}</td>
                                    </tr>
                                @endforeach
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
