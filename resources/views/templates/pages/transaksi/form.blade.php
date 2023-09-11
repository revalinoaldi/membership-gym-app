<x-display-layout>

    @push('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    @endpush

    <form>

        <div class="row">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Transaksi /</span> {{ @$isExtends == 99 ? "Perpanjangan Memberships" : "Memberships Baru" }}
            </h4>
            <!-- Basic Layout -->
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
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
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Paket Member</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($pakets as $paket)
                            <div class="col-lg-4 col-12 mb-md-0 mb-2">
                                <div class="form-check custom-option custom-option-basic">
                                    <label class="form-check-label custom-option-content" for="{{ $paket->slug }}">
                                        <input name="paket_id" class="form-check-input" type="radio" onclick="insertHarga({{ $paket->harga }})" value="" id="{{ $paket->slug }}" />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0"><b>{{ $paket->nama_paket }}</b></span>
                                            <span>{{ $paket->masa_aktif }} {{ $paket->activation->description }}</span>
                                        </span>
                                        <span class="custom-option-body">
                                            <small>Harga : <strong>Rp{{ number_format($paket->harga, 0, ',', '.') }}</strong> <br> {{ $paket->deskripsi }}</small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col">
                                <input type="number" name="total_biaya" id="total_biaya" readonly hidden required>
                                <input type="number" name="type" id="type" value="{{ $isExtends }}" readonly hidden required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <a href="" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Create Transaction</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

    @push('scripts')
    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="/assets/vendor/libs/moment/moment.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <!-- Page JS -->
    <script src="/assets/js/form-layouts.js"></script>

    <script>
        function insertHarga(harga){
            $('#total_biaya').val(parseInt(harga))
        }
    </script>
    @endpush
</x-display-layout>
