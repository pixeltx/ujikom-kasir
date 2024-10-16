<div>
    <div class="container">
        <h4 class="text-info">Home</h4>
        <div class="row">
            <div class="col-12">
                <div class="d-flex my-4" style="gap: 1rem;">
                    <div class="card bg-info" style="width: 10rem; height: 5rem; position: relative;">
                        <span class="fw-bold"
                            style="position: absolute; top: 0.5rem; font-size: 25px">{{ $jumlahMember }}</span>
                        <span class="fw-bold" style="position: absolute; top: 2.5rem; font-size: 25px">Member</span>
                        <img src="{{ asset('svg/groupuser.svg') }}" alt=""
                            style="width: 25px; position: absolute; left: 8rem; top: 1.5rem;">
                    </div>
                    <div class="card bg-info" style="width: 10rem; height: 5rem;">
                        <span class="fw-bold"
                            style="position: absolute; top: 0.5rem; font-size: 25px">{{ $jumlahProduk }}</span>
                        <span class="fw-bold" style="position: absolute; top: 2.5rem; font-size: 25px">Barang</span>
                        <img src="{{ asset('svg/box.svg') }}" alt=""
                            style="width: 25px; position: absolute; left: 8rem; top: 1.5rem;">
                    </div>
                    <div class="card bg-info" style="width: 10rem; height: 5rem;">
                        <span class="fw-bold"
                            style="position: absolute; top: 0.5rem; font-size: 25px">{{ $jumlahPetugas }}</span>
                        <span class="fw-bold" style="position: absolute; top: 2.5rem; font-size: 25px">Petugas</span>
                        <img src="{{ asset('svg/usersolo.svg') }}" alt=""
                            style="width: 25px; position: absolute; left: 8rem; top: 1.5rem;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
