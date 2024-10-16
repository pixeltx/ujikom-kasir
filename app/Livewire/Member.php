<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member as ModelMember;

class Member extends Component
{
    public $selectedMenu = 'lihat';
    public $nama;
    public $alamat;
    public $no_hp;
    public $selectedMember;
    public $search = '';

    public function searchMember()
    {
        return ModelMember::where('nama_member', 'like', '%' . $this->search . '%')->get();
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => ['required', 'unique:members,no_hp']
        ], [
            'nama.required' => 'Nama harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'no_hp.required' => 'Nomor Telepon harus diisi',
            'no_hp.unique' => 'Nomor Telepon Telah Digunakan'
        ]);

        $simpan = new ModelMember();
        $simpan->nama_member = $this->nama;
        $simpan->alamat = $this->alamat;
        $simpan->no_hp = $this->no_hp;
        $simpan->save();

        $this->reset(['nama', 'alamat', 'no_hp']);
        $this->selectedMenu = 'lihat';
    }

    public function selectHapus($id)
    {
        $this->selectedMember = ModelMember::findOrFail($id);
        $this->selectedMenu = 'hapus';
    }

    public function hapus()
    {
        $this->selectedMember->delete();
        $this->selectedMenu = 'lihat';
    }

    public function batal()
    {
        $this->reset();
    }

    public function selectMenu($menu)
    {
        $this->selectedMenu = $menu;
    }

    public function render()
    {
        $hasilMember = $this->searchMember();
        return view('livewire.member')->with([
            'members' => $hasilMember
        ]);
    }
}
