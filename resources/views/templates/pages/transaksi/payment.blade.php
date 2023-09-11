<x-display-layout>

    @push('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    @endpush

    <div class="card px-3">
        <div class="row">
            <div class="col-lg-7 card-body border-end">
                <h4 class="mt-2 mb-4">Billing Details</h4>
                <div class="row">
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="kode_member" class="form-label">Kode Member<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode_member" name="kode_member" value="{{ old('kode_member', '178063665') }}" placeholder="Kode Member" readonly autofocus required>
                        <input type="text" name="isMember" value="1" hidden required>
                    </div>
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="name" class="form-label">Full Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', 'Dr. Onie Wolff PhD') }}" placeholder="Enter your Full Name" autofocus required readonly>
                    </div>
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', 'bmonahan@example.net') }}" placeholder="Enter your Email" required readonly>
                    </div>
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="no_telp" class="form-label">Phone Number<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">(+62)</span>
                            <input type="text" id="no_telp" name="no_telp" class="form-control multi-steps-mobile" value="{{ old('no_telp','81519451708') }}" placeholder="202 555 0111" required readonly />
                        </div>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label" for="alamat">Alamat Lengkap<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <textarea id="alamat" name="alamat" class="form-control dt-address" placeholder="alamat" aria-label="alamat" aria-describedby="alamat" required readonly style="resize: none">{{ old('alamat', 'Williamson Divide Apt. 522 Port Watson, MA 10650') }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 col-xl-6 col-12">
                        <label class="form-label" for="nama_paket">Nama Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="nama_paket2" class="input-group-text"><i class='ti ti-briefcase'></i></span>
                            <input type="text" id="nama_paket" class="form-control dt-paket-name" value="Paket Bulanan" name="nama_paket" placeholder="Nama Paket" aria-label="Nama Paket" aria-describedby="nama_paket2" />
                        </div>
                    </div>
                    <div class="mb-3 col-xl-6 col-12">
                        <label class="form-label" for="harga">Harga Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="harga2" class="input-group-text">Rp</span>
                            <input type="number" id="harga" value="400000" name="harga" class="form-control dt-salary" placeholder="12000" aria-label="12000" aria-describedby="harga2" />
                        </div>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <div class="input-group input-group-merge">
                            <textarea id="deskripsi" name="deskripsi" class="form-control dt-description" placeholder="Deskrkipsi Paket" aria-label="Deskrkipsi Paket" aria-describedby="deskripsi2">Paket Bulanan Member + Free Soft Drink</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 card-body">
                <h4 class="mb-2">Order Summary</h4>
                {{-- <p class="pb-2 mb-0">It can help you manage and service orders before,<br> during and after fulfilment.</p> --}}
                <div class="bg-lighter p-4 rounded mt-4">
                    <p class="mb-1">Total Harga yang harus di bayar</p>
                    <div class="d-flex align-items-center">
                        <h1 class="text-heading display-5 mb-1">Rp400.000</h1>
                        {{-- <sub>/one time payment</sub> --}}
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0">Jenis Paket</p>
                        <h6 class="mb-0">Paket Bulanan</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0">Masa Aktif</p>
                        <h6 class="mb-0">1 Month</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0">Harga</p>
                        <h6 class="mb-0">Rp400.000</h6>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mt-3 pb-1">
                        <p class="mb-0">Total</p>
                        <h6 class="mb-0">Rp400.000</h6>
                    </div>
                    <div class="d-grid mt-3">
                        <button class="btn btn-success">
                            <span class="me-2">Proceed with Payment</span>
                            <i class="ti ti-arrow-right scaleX-n1-rtl"></i>
                        </button>
                    </div>

                    <p class="mt-4 pt-2">By continuing, you accept to our Terms of Services and Privacy Policy. Please note that payments are non-refundable.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/cleavejs/cleave.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/front-main.js"></script>


    <!-- Page JS -->
    <script src="/assets/js/front-page-payment.js"></script>
    @endpush
</x-display-layout>
