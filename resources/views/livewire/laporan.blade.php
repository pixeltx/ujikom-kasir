<div>
    <div class="container">
        <h1>Laporan</h1>
        <div class="row my-2">
            <div class="col-12">
                <button wire:click="selectLaporan('transaksi')"
                    class="btn {{ $selectedLaporan == 'transaksi' ? 'btn-primary' : 'btn-outline-primary' }}">Laporan
                    Transaksi</button>
                @if (Auth::user()->role == 'admin')
                    <button wire:click="selectLaporan('petugas')"
                        class="btn {{ $selectedLaporan == 'petugas' ? 'btn-primary' : 'btn-outline-primary' }}">Laporan
                        Petugas</button>
                @endif
                <button wire:click="selectLaporan('produk')"
                    class="btn {{ $selectedLaporan == 'produk' ? 'btn-primary' : 'btn-outline-primary' }}">Laporan
                    Produk</button>
                <button wire:click="selectLaporan('member')"
                    class="btn {{ $selectedLaporan == 'member' ? 'btn-primary' : 'btn-outline-primary' }}">Laporan
                    Member</button>
                <button class="btn btn-info" wire:loading>...</button>
                @if ($selectedLaporan == 'transaksi')
                    <div class="card border-primary my-2">
                        <h2>Transaksi</h2>
                        <a href="{{ url('/cetaktransaksi') }}" target="_blank">Cetak</a>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Kode</td>
                                        <td>Total</td>
                                        <td>Tanggal</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semuaTransaksi as $transaksi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $transaksi->kode }}</td>
                                            <td>{{ number_format($transaksi->total, 2, ',', '.') }}</td>
                                            <td>{{ $transaksi->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif ($selectedLaporan == 'petugas')
                    <div class="card border-primary my-2">
                        <h2>Petugas</h2>
                        <a href="{{ url('/cetakpetugas') }}" target="_blank">Cetak</a>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Nama</td>
                                        <td>Email</td>
                                        <td>Tanggal Dibuat</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semuaPetugas as $petugas)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $petugas->name }}</td>
                                            <td>{{ $petugas->email }}</td>
                                            <td>{{ $petugas->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif ($selectedLaporan == 'produk')
                    <div class="card border-primary my-2">
                        <h2>Produk</h2>
                        <a href="{{ url('/cetakproduk') }}" target="_blank">Cetak</a>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Kode</td>
                                        <td>Nama</td>
                                        <td>Harga</td>
                                        <td>Stok</td>
                                        <td>Tanggal Dibuat</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semuaProduk as $produk)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $produk->kode }}</td>
                                            <td>{{ $produk->nama }}</td>
                                            <td>{{ $produk->harga }}</td>
                                            <td>{{ $produk->stok }}</td>
                                            <td>{{ $produk->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif ($selectedLaporan == 'member')
                    <div class="card border-primary my-2">
                        <h2>Member</h2>
                        <a href="{{ url('/cetakmember') }}" target="_blank">Cetak</a>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Nama</td>
                                        <td>Alamat</td>
                                        <td>Nomor Telepon</td>
                                        <td>Tanggal Dibuat</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($semuaMember as $member)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $member->nama_member }}</td>
                                            <td>{{ $member->alamat }}</td>
                                            <td>{{ $member->no_hp }}</td>
                                            <td>{{ $member->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
