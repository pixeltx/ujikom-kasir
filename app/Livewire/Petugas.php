<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as ModelUser;

class Petugas extends Component
{
    public $selectedMenu = 'lihat';
    public $nama;
    public $email;
    public $password;
    public $role;
    public $selectedPetugas;
    public $search = '';

    public function searchPetugas()
    {
        return ModelUser::where('name', 'like', '%' . $this->search . '%')->where('role', 'kasir')->get();
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required'
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Harus format email',
            'email.unique' => 'Email Telah Digunakan',
            'password.required' => 'Password harus diisi'
        ]);

        $simpan = new ModelUser();
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->password = bcrypt($this->password);
        $simpan->role = 'kasir';
        $simpan->save();

        $this->reset(['nama', 'email', 'password']);
        $this->selectedMenu = 'lihat';
    }

    public function selectEdit($id)
    {
        $this->selectedPetugas = ModelUser::findOrFail($id);
        $this->nama = $this->selectedPetugas->name;
        $this->email = $this->selectedPetugas->email;
        $this->selectedMenu = 'edit';
    }

    public function saveEdit()
    {
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email,' . $this->selectedPetugas->id]
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Harus Format Email!',
            'email.unique' => 'Email Telah Digunakan'
        ]);

        $simpan = $this->selectedPetugas;
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        if ($this->password) {
            $simpan->password = bcrypt($this->password);
        }
        $simpan->save();

        $this->reset(['nama', 'email', 'password', 'selectedPetugas']);
        $this->selectedMenu = 'lihat';
    }

    public function selectHapus($id)
    {
        $this->selectedPetugas = ModelUser::findOrFail($id);
        $this->selectedMenu = 'hapus';
    }

    public function hapus()
    {
        $this->selectedProduk->delete();
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
        $hasilPetugas = $this->searchPetugas();
        return view('livewire.petugas')->with([
            'users' => $hasilPetugas
        ]);
    }
}
