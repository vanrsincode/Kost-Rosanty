<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        /* table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        } */

        body {
            font: normal normal Verdana, Arial, Sans-Serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font: normal normal 12px Verdana, Arial, Sans-Serif;
            color: #333333;
        }

        table th {
            background: #d5d5d5!important;
            color: #333333;
            font-weight: bold;
            font-size: 13px;
            height: 45px;
        }

        table th,
        table td {
            vertical-align: middle;
            padding: 5px 10px;
            text-align: center;
            border: 1px solid #696969;
        }

        table tr {
            background: #F5FFFA;
        }

        table tr:nth-child(even) {
            background: #F0F8FF;
        }
    </style>
</head>
<body>
    <h1 align="center" style="font-size: 18px; margin: 0px 0px 5px;">KOST ROSANTY</h1>
    <h1 align="center" style="font-size: 17px; margin: 0px 0px 25px;">LAPORAN TRANSAKSI</h1>
    {{-- <h2>Laporan Transaksi</h2> --}}
    @if($startMonth && $endMonth)
        <p>Periode: {{ $startMonth->isoFormat('MMMM YYYY') }} - {{ $endMonth->isoFormat('MMMM YYYY') }}</p>
    @elseif($startMonth)
        <p>Periode: {{ $startMonth->isoFormat('MMMM YYYY') }}</p>
    @elseif($endMonth)
        <p>Periode: {{ $endMonth->isoFormat('MMMM YYYY') }}</p>
    @else
        <p>Periode: Semua</p>
    @endif
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama<br>Penghuni</th>
                <th>Kamar</th>
                <th>Tagihan</th>
                <th>Tarif</th>
                <th>Status<br>Pembayaran</th>
                <th>Metode<br>Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @if($data->isEmpty())
                <tr align="center">
                    <td colspan="7">Data tidak ada</td>
                </tr>
            @endif
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->penghuni->nama_penghuni }}</td>
                    <td>{{ $item->penghuni->sewaKamar->kamar->nomor_kamar }} <br> {{ $item->penghuni->sewaKamar->kamar->tipe_kamar }}</td>
                    <td>{{ Carbon\Carbon::create($item->tahun_tagihan, $item->bulan_tagihan, 1)->isoFormat('MMMM YYYY') }}</td>
                    <td>Rp. {{ number_format($item->penghuni->sewaKamar->kamar->harga_kamar, 0, ',', '.') }}</td>
                    <td>{{ $item->status_transaksi }}</td>
                    <td>{{ $item->metode_pembayaran ?? 'Belum ada' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
