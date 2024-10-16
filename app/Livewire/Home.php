<?php

namespace App\Livewire;

use App\Livewire\Produk as LivewireProduk;
use Livewire\Component;
use App\Models\Produk;
use App\Models\Member;
use App\Models\User;

class Home extends Component
{
    public $jumlahProduk;
    public $jumlahMember;
    public $jumlahPetugas;

    public function mount()
    {
        $this->jumlahProduk = Produk::count();
        $this->jumlahMember = Member::count();
        $this->jumlahPetugas = User::where('role', 'kasir')->count();
    }

    public function render()
    {
        $Produk = $this->jumlahProduk;
        $Member = $this->jumlahMember;
        $Petugas = $this->jumlahPetugas;
        return view('livewire.home')->with([
            'jumlahProduk' => $Produk,
            'jumlahMember' => $Member,
            'jumlahPetugas' => $Petugas
        ]);
    }
}
