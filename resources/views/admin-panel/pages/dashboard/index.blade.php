@extends('admin-panel.layouts.main')

@section('title', 'Dashboard')

@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('admin/vendor') }}/owl/owl.carousel.min.css">
@endpush

@push('css')
    <style>
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .btn-bayar{
            width: 38%; 
            left:30%;
        }
        .btn-change{
            width: 38%; 
            left:72%;
        }

        @media (max-width: 600px) {
            .hide-on-small {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <section class="section">
        {{-- <div class="section-header">
            <h1>Dashboard</h1>
        </div> --}}

        <div class="row mt-2">
            {{-- Role Admin --}}
            @if (auth()->user()->role === 1 || auth()->user()->role === 3)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 irounded-1 shadow">
                        <div class="card-icon bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap mt-2">
                            <div class="card-header">
                                <h4>Penghuni</h4>
                            </div>
                            <div class="card-body">
                                {{ $jumlah_penghuni[0]->total }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 irounded-1 shadow">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="card-wrap mt-2">
                            <div class="card-header">
                                <h4>Kamar</h4>
                            </div>
                            <div class="card-body">
                                {{ $jumlah_kamar[0]->total }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 irounded-1 shadow">
                        <div class="card-icon bg-info">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="card-wrap mt-2">
                            <div class="card-header">
                                <h4>Fasilitas</h4>
                            </div>
                            <div class="card-body">
                                {{ $jumlah_fasilitas[0]->total }}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 irounded-1 shadow">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-assistive-listening-systems"></i>
                        </div>
                        <div class="card-wrap mt-2">
                            <div class="card-header">
                                <h4>Feedback</h4>
                            </div>
                            <div class="card-body">
                                {{ $jumlah_feedback[0]->total }}
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- Bar Chart --}}
                <div class="col-12 hide-on-small"">
                    <div class="card irounded-1 shadow">
                        <div class="card-header">
                            <h4>Grafik Jumlah Transaksi pada {{ $currentYear }}</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartTransaksi" height="150px"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Role Penghuni --}}
            @elseif(auth()->user()->role === 2)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 irounded-1 shadow">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="card-wrap mt-2">
                            <div class="card-header">
                                <h4>Kamar</h4>
                            </div>
                            <div class="card-body">
                                {{ $dashKamarPenghuni }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 irounded-1 shadow">
                        <div class="card-icon bg-warning">
                            <b class="text-white font-weight-bold" style="font-size: 22px; line-height:0px;">Rp</b>
                        </div>
                        <div class="card-wrap mt-2">
                            <div class="card-header">
                                <h4>Tagihan per Bulan</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($dashTarifPenghuni, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 irounded-1 shadow">
                        <div class="card-icon bg-danger">
                            {{-- <i class="fas fa-dollar-sign"></i> --}}
                            <b class="text-white font-weight-bold" style="font-size: 22px; line-height:0px;">Rp</b>
                        </div>
                        <div class="card-wrap mt-2">
                            <div class="card-header">
                                <h4>Total Tagihan</h4>
                            </div>
                            <div class="card-body">
                                Rp. {{ number_format($dashTotalBelumDibayar, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- card slider --}}
                <div class="col-12">
                    <div class="site-section bg-left-half mb-5">
                        <div class="owl-2-style">
                            <div class="owl-carousel owl-2">
                                @foreach ($transaksi as $trx)
                                    <div class="media-29101">
                                        <div
                                            class="card-pay {{ $trx->status_transaksi == 'Lunas' ? 'bg-success' : 'bg-danger' }}">
                                            <div class="card-details-pay text-white-all">
                                                <p class="text-title-pay">
                                                    {{ \Carbon\Carbon::createFromDate($trx->tahun_tagihan, $trx->bulan_tagihan)->isoFormat('MMMM Y') }}
                                                </p>
                                                <p class="text-body-pay mb-0">Tagihan : Rp.
                                                    {{ number_format($trx->total_bayar, 0, ',', '.') }}</p>
                                                <p class="text-body-pay mb-0">Tanggal Bayar :
                                                    {{ $trx->tgl_pembayaran ? \Carbon\Carbon::parse($trx->tgl_pembayaran)->isoFormat('DD MMM Y') : 'N/A' }}
                                                </p>
                                                <p class="text-body-pay mb-0">Status : {{ $trx->status_transaksi }}</p>
                                            </div>
                                            @if ($trx->status_transaksi != 'Lunas')
                                                <button class="card-button-pay pay-button"
                                                    data-idt="{{ $trx->snap_token }}">
                                                    Bayar
                                                </button>
                                            {{-- @elseif ($trx->status_transaksi == 'Pending')
                                                <div class="button-container">
                                                    <button class="card-button-pay pay-button btn-bayar"
                                                        data-idt="{{ $trx->snap_token }}">
                                                        Bayar
                                                    </button>
                                                    <button class="card-button-pay btn-change"
                                                        data-idt="{{ $trx->snap_token }}">
                                                        Change
                                                    </button>
                                                </div> --}}
                                            @else
                                                <button class="card-button-pay" disabled>
                                                    Lunas
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('js_vendor')
    @if (auth()->user()->role === 1 || auth()->user()->role === 3)
        <script src="{{ asset('admin/vendor') }}/chart.js/dist/Chart.min.js"></script>
    @elseif (auth()->user()->role === 2)
        <script src="{{ asset('admin/vendor') }}/owl/owl.carousel.min.js"></script>
    @endif
@endpush

@push('js')
    @include('admin-panel.pages.dashboard.js')
@endpush
