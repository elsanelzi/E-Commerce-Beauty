<?php

namespace App\Http\Controllers;

use App\Models\Detail_Pembayaran;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function pemesanan_saya()
    {
        $pembayaran = Pembayaran::all()->where('id_user', Auth::user()->id);
        return view('halaman_user.laporan.pemesanan_saya', compact('pembayaran'));
    }

    public function barang_sampai($id)
    {
        $sampai = Pembayaran::find($id);
        $sampai->status = 'sampai';
        $sampai->save();
        return redirect()->route('pemesanan_saya');
    }

    public function laporan_admin()
    {
        $pay = DB::table('pembayaran')->leftjoin('persediaan', 'pembayaran.id_persediaan', '=', 'persediaan.id_persediaan')->leftjoin('users', 'pembayaran.id_user', '=', 'users.id')->join('barang', 'pembayaran.kode_barang', '=', 'barang.kode_barang')
            ->leftjoin('kurir', 'pembayaran.id_kurir', '=', 'kurir.id_kurir')->leftjoin('detail_pembayaran', 'pembayaran.id_pembayaran', '=', 'detail_pembayaran.id_pembayaran')
            ->where('pembayaran.status', 'sampai')
            ->select(
                'pembayaran.*',
                'detail_pembayaran.*',
                'barang.nama_barang as nm_barang',
                'barang.gambar as p_barang',
                'users.name as user_nama',
                'kurir.nama_kurir',
                'kurir.harga as harga_kurir'
            )
            ->get();
        // dd($pay);
        return view('halaman_admin.laporan.laporan_admin', compact('pay'));
    }

    public function faktur()
    {
        $faktur = Detail_Pembayaran::join('pembayaran', 'detail_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')->join('persediaan', 'pembayaran.id_persediaan', '=', 'persediaan.id_persediaan')
            ->join('barang', 'pembayaran.kode_barang', '=', 'barang.kode_barang')->join('users', 'pembayaran.id_user', '=', 'users.id')
            ->join('alamat', 'users.username', '=', 'alamat.username')->join('kurir', 'pembayaran.id_kurir', '=', 'kurir.id_kurir')
            ->select('kurir.nama_kurir', 'kurir.harga as harga_kurir', 'barang.nama_barang', 'persediaan.harga', 'detail_pembayaran.kuantiti', 'persediaan.diskon')
            ->where('pembayaran.id_user', Auth::user()->id)
            ->get();

        $nama = Detail_Pembayaran::join('pembayaran', 'detail_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')->join('persediaan', 'pembayaran.id_persediaan', '=', 'persediaan.id_persediaan')
            ->join('barang', 'pembayaran.kode_barang', '=', 'barang.kode_barang')->join('users', 'pembayaran.id_user', '=', 'users.id')
            ->join('alamat', 'users.username', '=', 'alamat.username')->join('kurir', 'pembayaran.id_kurir', '=', 'kurir.id_kurir')
            ->select('users.name', 'alamat.no_hp', 'detail_pembayaran.tipe_pembayaran')->where('pembayaran.id_user', Auth::user()->id)
            ->first();
        return view('halaman_user.laporan.faktur', compact('faktur', 'nama'));
    }

    public function cari(Request $request)
    {
        $periode = $request->periode;
        $cari = DB::table('pembayaran')->leftjoin('persediaan', 'pembayaran.id_persediaan', '=', 'persediaan.id_persediaan')->leftjoin('users', 'pembayaran.id_user', '=', 'users.id')->join('barang', 'pembayaran.kode_barang', '=', 'barang.kode_barang')
            ->leftjoin('kurir', 'pembayaran.id_kurir', '=', 'kurir.id_kurir')->leftjoin('detail_pembayaran', 'pembayaran.id_pembayaran', '=', 'detail_pembayaran.id_pembayaran')
            ->where('pembayaran.status', 'sampai')
            ->select(
                'pembayaran.*',
                'detail_pembayaran.*',
                'barang.nama_barang as nm_barang',
                'barang.gambar as p_barang',
                'users.name as user_nama',
                'kurir.nama_kurir',
                'kurir.harga as harga_kurir'
            );
        if ($request->periode) {
            $data = $cari->whereMonth('detail_pembayaran.tanggal_pembayaran', [$request->periode]);
        } else {
            $data = $cari;
        };
        $pay = $data->get();
        return view('halaman_admin.laporan.laporan_admin', compact('pay', 'periode'));
    }

    public function print1()
    {
        $print = DB::table('pembayaran')->leftjoin('persediaan', 'pembayaran.id_persediaan', '=', 'persediaan.id_persediaan')->leftjoin('users', 'pembayaran.id_user', '=', 'users.id')->join('barang', 'pembayaran.kode_barang', '=', 'barang.kode_barang')
            ->leftjoin('kurir', 'pembayaran.id_kurir', '=', 'kurir.id_kurir')->leftjoin('detail_pembayaran', 'pembayaran.id_pembayaran', '=', 'detail_pembayaran.id_pembayaran')
            ->where('pembayaran.status', 'sampai')
            ->select(
                'pembayaran.*',
                'detail_pembayaran.*',
                'barang.nama_barang as nm_barang',
                'barang.gambar as p_barang',
                'users.name as user_nama',
                'kurir.nama_kurir',
                'kurir.harga as harga_kurir'
            )
            ->get();
        return view('halaman_admin.laporan.print', compact('print'));
    }

    public function print($periode)
    {
        $print = DB::table('pembayaran')->leftjoin('persediaan', 'pembayaran.id_persediaan', '=', 'persediaan.id_persediaan')->leftjoin('users', 'pembayaran.id_user', '=', 'users.id')->join('barang', 'pembayaran.kode_barang', '=', 'barang.kode_barang')
            ->leftjoin('kurir', 'pembayaran.id_kurir', '=', 'kurir.id_kurir')->leftjoin('detail_pembayaran', 'pembayaran.id_pembayaran', '=', 'detail_pembayaran.id_pembayaran')
            ->where('pembayaran.status', 'sampai')
            ->select(
                'pembayaran.*',
                'detail_pembayaran.*',
                'barang.nama_barang as nm_barang',
                'barang.gambar as p_barang',
                'users.name as user_nama',
                'kurir.nama_kurir',
                'kurir.harga as harga_kurir'
            )->whereMonth('detail_pembayaran.tanggal_pembayaran', '=', $periode)->get();
        return view('halaman_admin.laporan.print', compact('print'));
    }
}
