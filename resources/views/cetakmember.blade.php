<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Transaksi</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body onload="print()">
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-body">
                        <h4 class="card-title">Laporan Produk</h4>
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
            </div>
        </div>
    </div>
</body>

</html>
