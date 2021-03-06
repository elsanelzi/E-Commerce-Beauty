<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Persediaan;
use Illuminate\Http\Request;
use App\Models\Histori_Persediaan;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PemesananController extends Controller
{
    public function proses_pemesanan(Request $request)
    {
        date_default_timezone_set("Asia/jakarta");
        $tgl = date('Y-m-d');

        // insert data ke table pemesanan
        $pesan = new Pemesanan;
        $pesan->id_user = $request->id_user;
        $pesan->id_persediaan = $request->id_persediaan;
        $pesan->kode_barang = $request->kode_barang;
        $pesan->kuantiti = $request->kuantiti;
        $pesan->status = 'konfirmasi';
        $pesan->save();

        // update data stok ketika melakuka penjualan
        $persediaan = Persediaan::find($request->id_persediaan);
        $persediaan->persediaan -= $request->kuantiti;
        $persediaan->save();

        return redirect()->route('/');
    }
    public function kelola_pemesanan()
    {
        $pemesanan = Pemesanan::all();
        return view('halaman_admin.pemesanan.pemesanan', compact('pemesanan'));
    }


    public function pesanan_user()
    {
        $pesan = Pemesanan::join('users', 'pemesanan.id_user', '=', 'users.id')->join('persediaan', 'pemesanan.id_persediaan', '=', 'persediaan.id_persediaan')
            ->join('barang', 'pemesanan.kode_barang', '=', 'barang.kode_barang')
            ->select('users.name', 'persediaan.harga', 'persediaan.diskon', 'pemesanan.*')
            ->where('pemesanan.id_user', Auth::user()->id)->get();
        return view('halaman_user.pemesanan.pesanan_user', compact('pesan'));
    }

    public function hapus($id_pemesaan)
    {
        $hapus = Pemesanan::find($id_pemesaan);
        $hapus->delete();
        Alert::error('Data Berhasil', 'Data Berhasil dihapus');
        return redirect()->route('pesanan_user');
    }
}
