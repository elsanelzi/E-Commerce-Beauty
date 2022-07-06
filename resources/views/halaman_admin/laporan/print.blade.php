<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('halaman_admin.layouts.navbar')
</head>
@include('halaman_admin.layouts.script')

<body onload="print();">
    {{-- <section class="content"> --}}
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <h2> Laporan Akhir Penjualan</h2>
        </div>
        <div class="card-header">
            <div class="card-title">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama User</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Tipe Pembayaran</th>
                            <th scope="col">kota</th>
                            <th scope="col">Tanggal Bayar</th>
                            <th scope="col">Nama Kurir</th>
                            <th scope="col">Ongkir</th>
                            <th scope="col">Jumlah Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($print as $p)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $p->user_nama }}</td>
                                <td>{{ $p->nm_barang }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>{{ $p->tipe_pembayaran }}</td>
                                <td>{{ $p->kota }}</td>
                                <td>{{ $p->tanggal_pembayaran }}</td>
                                <td>{{ $p->nama_kurir }}</td>
                                <td>{{ number_format($p->harga_kurir) }}</td>
                                <td>{{ number_format($p->total_akhir) }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
                @php
                    $tgl = date('d-m-Y');
                @endphp

            </div>
        </div>
        {{-- </section> --}}
        <div class="d-flex justify-content-end">
            Padang, {{ $tgl }}
            <br> Hormat Kami
            <br> <br><br><br><br>
            Boogie Outdoor
        </div>
    </div>


</body>

</html>
