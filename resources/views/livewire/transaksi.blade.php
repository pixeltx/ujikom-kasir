<div>
    <div class="px-2 mt-2">
        <h1>Transaksi</h1>
        <div class="container">
            <div class="row mt-2">
                <div class="col-12">
                    @if (!$activeTransaksi)
                        <button class="btn btn-primary" wire:click='newTransaksi'>New Transaction</button>
                    @else
                        <button class="btn btn-danger" wire:click='cancelTransaksi'>Cancel</button>
                    @endif
                    <button class="btn btn-info" wire:loading>...</button>
                </div>
            </div>
            @if ($activeTransaksi)
                <div style="width: 75rem;">
                    <div class="row mt-3">
                        <div class="card border-primary mb-2" style="width: 40vw;">
                            <h4>Member</h4>
                            @if (!$member)
                                <input type="text" class="my-2" placeholder="Nomor Telepon"
                                    wire:model.lazy="no_hp">
                                <button class="btn btn-secondary" wire:click='checkMember'>Cek</button>
                            @endif
                            @if (session()->has('member_error'))
                                <div class="alert alert-danger mt-2" role="alert">{{ session('member_error') }}</div>
                            @endif
                            @if ($member)
                                <div class="alert alert-success mt-2" role="alert">Member:
                                    {{ $member->nama_member }}</div>
                            @endif
                        </div>
                        <div class="col-8">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h4 class="card-title">Invoice : {{ $activeTransaksi->kode }}</h4>
                                    <input type="text" class="form-control my-2" placeholder="Kode Barang"
                                        wire:model.live='kode'>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                                <th>Control</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($semuaProduk as $produk)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $produk->produk ? $produk->produk->kode : '' }}</td>
                                                    <td>{{ $produk->produk ? $produk->produk->nama : '' }}</td>
                                                    <td>{{ $produk->produk ? number_format($produk->produk->harga, 2, '.', ',') : '' }}
                                                    </td>
                                                    <td>
                                                        {{ $produk->jumlah_produk }}
                                                    </td>
                                                    <td>{{ $produk->produk ? number_format($produk->produk->harga * $produk->jumlah_produk, 2, '.', ',') : '' }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success sm"
                                                            wire:click='plusQty({{ $produk->id }})'>+</button>
                                                        <button class="btn btn-warning sm"
                                                            wire:click='minQty({{ $produk->id }})'>-</button>
                                                        <button class="btn btn-danger"
                                                            wire:click='hapusProduk({{ $produk->id }})'>Hapus</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h4 class="card-title">Total</h4>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp. </span>
                                        <span>{{ number_format($totalBelanja, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-primary mt-2">
                                <div class="card-body">
                                    <h4 class="card-title">Bayar</h4>
                                    <input type="number" class="form-control" placeholder="Nominal"
                                        wire:model.live='bayar'>
                                </div>
                            </div>
                            <div class="card border-primary mt-2">
                                <div class="card-body">
                                    <h4 class="card-title">Kembalian</h4>
                                    <div class="d-flex justify-content-between">
                                        <span>Rp. </span>
                                        <span>{{ number_format($kembalian, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            @if ($bayar)
                                @if ($kembalian < 0)
                                    <div class="alert alert-danger mt-2" role="alert">Uang Kurang</div>
                                @else
                                    <button class="btn btn-success mt-2 w-100"
                                        wire:click='processTransaksi'>Bayar</button>
                                @endif
                            @endif
                    </div>
                </div>
            </div>
        </div>
        @if($receipt)
        <div id="printArea" class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                        <button type="button" id="btn-done" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='closeReceipt()'></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h4>Invoice: {{ $activeTransaksi->kode }}</h4>
                                    <p>Date: {{ date('Y-m-d H:i:s') }}</p>
                                    @if ($member)
                                    <p>Member: {{ $member->nama_member }}</p>    
                                    @endif
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($semuaProduk as $produk)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $produk->produk->nama }}</td>
                                                    <td>{{ $produk->jumlah_produk }}</td>
                                                    <td>{{ number_format($produk->produk->harga, 2, ',', '.') }}</td>
                                                    <td>{{ number_format($produk->produk->harga * $produk->jumlah_produk, 2, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-between">
                                        <span>Total:</span>
                                        <span>{{ number_format($totalBelanja, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Diskon:</span>
                                        <span>{{ number_format($diskon, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Bayar:</span>
                                        <span>{{ number_format($bayar, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Kembalian:</span>
                                        <span>{{ number_format($kembalian, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="printReceipt()" id="btn-print" class="btn btn-primary">Print</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>

<script>
    function printReceipt() {
        var printContents = document.getElementById('printArea').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        document.getElementById('btn-done').style.display = 'none';
        document.getElementById('btn-print').style.display = 'none';

        window.onafterprint = function() {
            document.getElementById('btn-done').style.display = 'inline-block';
            document.getElementById('btn-print').style.display = 'inline-block';
            document.body.innerHTML = originalContents;
            location.reload();
        };

        window.print();
    }
</script>
