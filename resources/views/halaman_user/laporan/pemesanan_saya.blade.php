@extends('master_layouts.halaman_home')

@section('content')
	<header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url('{{asset('gambar/bg2.jpg')}}'); margin-bottom:100px">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<div class="display-t">
						<div class="display-tc animate-box" data-animate-effect="fadeIn">
							<h1>Pemesanan Saya</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
    <!-- Submit Ad -->
    <div class="submit-ad main-grid-border" style="margin-top: 80px; margin-bottom:30px">
        <div class="container">
            <h2 class="head">Pesanan Saya</h2>
            <div class="post-ad-form">
             
                <table class="table table-bordered">
                    <tr class="text-center" style="background-color:aquamarine; color:white;">
                        <th>Nomor</th>
                        <th>Nama Pemesan</th>
                        <th>Kota</th>
                        <th>Alamat</th>
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Jumlah Pembelian</th>
                        <th>Nama Kurir</th>
                        <th>Harga Ongkir</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Faktur</th>
                    </tr>
                    @foreach ($pembayaran as $p)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->detail->kota }}</td>
                            <td>{{ $p->detail->alamat }}</td>
                            <td>{{ $p->barang->nama_barang }}</td>
                            <td>{{ number_format($p->persediaan->harga) }}</td>
                            <td>{{ $p->detail->kuantiti }}</td>
                            @if($p->id_kurir != NULL)
                            <td>{{ $p->kurir->nama_kurir }}</td>
                            <td>{{ number_format($p->kurir->harga) }}</td>
                            @else 
                            <td>-</td>
                            <td>-</td>
                            @endif
                            <td>{{ number_format($p->detail->total_akhir) }}</td>
                            <td>
                                @if ($p->status == 'pending')
                                    Tunggu Konfirmasi Dari Admin
                                @elseif($p->status == 'sampai')
                                    {{ $p->status }}
                                @else
                                    <a href="{{ route('barang_sampai', $p->id_pembayaran) }}"
                                        class="btn btn-info">Barang
                                        Sampai</a>
                                @endif
                            </td>
                            <td>
                             <a href="{{ route('faktur') }}" class="btn btn-success mb-2" target="_blank">Faktur </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-- // Submit Ad -->
@endsection
