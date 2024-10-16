<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Produk;
use App\Models\Member;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function cetakTransaksi()
    {
        $semuaTransaksi = Transaksi::where('status', 'selesai')->get();
        return view('cetaktransaksi')->with([
            'semuaTransaksi' => $semuaTransaksi
        ]);
    }

    public function cetakPetugas()
    {
        $semuaPetugas = User::where('role', 'kasir')->get();
        return view('cetakpetugas')->with([
            'semuaPetugas' => $semuaPetugas
        ]);
    }

    public function cetakProduk()
    {
        $semuaProduk = Produk::all();
        return view('cetakproduk')->with([
            'semuaProduk' => $semuaProduk
        ]);
    }

    public function cetakMember()
    {
        $semuaMember = Member::all();
        return view('cetakmember')->with([
            'semuaMember' => $semuaMember
        ]);
    }
}
