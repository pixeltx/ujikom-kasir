<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi as ModelTransaksi;
use App\Models\Produk;
use App\Models\Member;
use App\Models\DetailTransaksi;

class Transaksi extends Component
{
    public $kode, $total, $kembalian, $totalBelanja, $diskon;
    public $nama;
    public $bayar = 0;
    public $no_hp;
    public $member;
    public $activeTransaksi;
    public $receipt = false;

    public function checkMember()
    {
        $no_hp = $this->no_hp;
        $member = Member::where('no_hp', $no_hp)->first();

        if (!$member) {
            session()->flash('member_error', 'Member tidak ditemukan');
        } else {
            $this->member = $member;
            $this->activeTransaksi->id_member = $member->id;
            $this->activeTransaksi->save();
            $this->activeTransaksi->load('member');
        }
    }

    public function newTransaksi()
    {
        $this->reset();
        $this->activeTransaksi = new ModelTransaksi();
        $this->activeTransaksi->kode = 'TRX/' . date('YmdHis');
        $this->activeTransaksi->total = 0;
        $this->activeTransaksi->status = 'pending';
        $this->activeTransaksi->save();
    }

    public function cancelTransaksi()
    {
        if ($this->activeTransaksi) {
            $detailTransaksi = DetailTransaksi::where('id_transaksi', $this->activeTransaksi->id)->get();
            foreach ($detailTransaksi as $detail) {
                $produk = Produk::find($detail->id_produk);
                $produk->stok += $detail->jumlah_produk;
                $produk->save();
                $detail->delete();
            }
            $this->activeTransaksi->delete();
        }
        $this->reset();
    }

    public function updatedKode()
    {
        $produk = Produk::Where('kode', $this->kode)->first();
        if ($produk && $produk->stok > 0) {
            $detail = DetailTransaksi::firstOrNew([
                'id_transaksi' => $this->activeTransaksi->id,
                'id_produk' => $produk->id
            ], [
                'jumlah_produk' => 0,
            ]);
            $detail->jumlah_produk += 1;
            $detail->save();
            $this->reset('kode');
        }
    }

    public function updatedNama()
    {
        $produk = Produk::Where('nama', $this->nama)->first();
        if ($produk && $produk->stok > 0) {
            $detail = DetailTransaksi::firstOrNew([
                'id_transaksi' => $this->activeTransaksi->id,
                'id_produk' => $produk->id
            ], [
                'jumlah_produk' => 0,
            ]);
            $detail->jumlah_produk += 1;
            $detail->save();
            $this->reset('nama');
        }
    }

    public function processTransaksi()
    {
        $this->activeTransaksi->total = $this->totalBelanja;
        $this->activeTransaksi->status = 'selesai';
        $this->activeTransaksi->save();
        $this->receipt = true;
    }

    public function updatedBayar()
    {
        if ($this->bayar > 0) {
            $this->kembalian = $this->bayar - $this->totalBelanja;
        }
    }

    public function minQty($id)
    {
        $detail = DetailTransaksi::find($id);
        if ($detail && $detail->jumlah_produk > 1) {
            $detail->jumlah_produk -= 1;
            $detail->save();
            $produk = Produk::find($detail->id_produk);
            $produk->stok += 1;
            $produk->save();
        }
    }

    public function plusQty($id)
    {
        $detail = DetailTransaksi::find($id);
        if ($detail && $detail->produk->stok > 0) {
            $detail->jumlah_produk += 1;
            $detail->save();
            $produk = Produk::find($detail->id_produk);
            $produk->stok -= 1;
            $produk->save();
        }
    }

    public function hapusProduk($id)
    {
        $detail = DetailTransaksi::find($id);
        if ($detail) {
            $produk = Produk::find($detail->id_produk);
            $produk->stok += $detail->jumlah_produk;
            $produk->save();
        }
        $detail->delete();
    }

    public function hitungDiskon()
    {
        if ($this->member && $this->totalBelanja >= 100000) {
            $this->diskon = $this->totalBelanja * 0.05; // 5% Disc
            $this->totalBelanja -= $this->diskon;
        } else {
            $this->diskon = 0;
        }
    }

    public function closeReceipt()
    {
        $this->reset();
    }

    public function render()
    {
        if ($this->activeTransaksi) {
            $semuaProduk = DetailTransaksi::where('id_transaksi', $this->activeTransaksi->id)->get();
            $this->totalBelanja = $semuaProduk->sum(function ($detail) {
                return $detail->produk->harga * $detail->jumlah_produk;
            });

            $this->hitungDiskon();
        } else {
            $semuaProduk = [];
        }
        return view('livewire.transaksi')->with([
            'semuaProduk' => $semuaProduk,
            'receipt' => $this->receipt
        ]);
    }
}
