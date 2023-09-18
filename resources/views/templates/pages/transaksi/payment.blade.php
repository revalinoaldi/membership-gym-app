<x-display-layout>

    @push('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    @endpush

    @if (session('success'))
    <div class="alert alert-success alert-dismissible shadow" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-3">
        <div class="alert alert-danger alert-dismissible alert-solid alert-label-icon shadow fade show mb-xl-0" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>{{ __('Whoops! Something went wrong.') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div class="card px-3">
        <div class="row">
            <div class="col-lg-7 card-body border-end">
                <h4 class="mt-2 mb-4">Billing Details</h4>
                <div class="row">
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="kode_member" class="form-label">Kode Member<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode_member" name="kode_member" value="{{ $transaksi->membership->kode_member }}" placeholder="Kode Member" readonly autofocus required>
                        <input type="text" name="isMember" value="1" hidden required>
                    </div>
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="name" class="form-label">Full Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $transaksi->membership->nama_lengkap }}" placeholder="Enter your Full Name" autofocus required readonly>
                    </div>
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $transaksi->membership->email }}" placeholder="Enter your Email" required readonly>
                    </div>
                    <div class="mb-3 col-12 col-xl-6">
                        <label for="no_telp" class="form-label">Phone Number<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">(+62)</span>
                            <input type="text" id="no_telp" name="no_telp" class="form-control multi-steps-mobile" value="{{ $transaksi->membership->no_telp }}" placeholder="202 555 0111" required readonly />
                        </div>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label" for="alamat">Alamat Lengkap<span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <textarea id="alamat" name="alamat" class="form-control dt-address" placeholder="alamat" aria-label="alamat" aria-describedby="alamat" required readonly style="resize: none">{{ $transaksi->membership->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 col-xl-6 col-12">
                        <label class="form-label" for="nama_paket">Nama Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="nama_paket2" class="input-group-text"><i class='ti ti-briefcase'></i></span>
                            <input type="text" id="nama_paket" class="form-control dt-paket-name" value="{{ $transaksi->paket->nama_paket }}" name="nama_paket" placeholder="Nama Paket" aria-label="Nama Paket" aria-describedby="nama_paket2" readonly required />
                        </div>
                    </div>
                    <div class="mb-3 col-xl-6 col-12">
                        <label class="form-label" for="harga">Harga Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="harga2" class="input-group-text">Rp</span>
                            <input type="number" id="harga" value="{{ $transaksi->paket->harga }}" name="harga" class="form-control dt-salary" placeholder="12000" aria-label="12000" aria-describedby="harga2" required readonly />
                        </div>
                    </div>
                    <div class="mb-3 col-xl-12 col-12">
                        <label class="form-label" for="masa_aktif">Masa Aktif Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="masa_aktif2" class="input-group-text"><i class='ti ti-briefcase'></i></span>
                            <input type="text" id="masa_aktif" class="form-control dt-paket-name" value="{{ $transaksi->paket->masa_aktif." ".$transaksi->paket->activation->type }}" name="nama_paket" placeholder="Nama Paket" aria-label="Nama Paket" aria-describedby="nama_paket2" readonly required />
                        </div>
                    </div>
                    <div class="mb-3 col-12">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <div class="input-group input-group-merge">
                            <textarea id="deskripsi" name="deskripsi" class="form-control dt-description" placeholder="Deskrkipsi Paket" aria-label="Deskrkipsi Paket" aria-describedby="deskripsi2" readonly required style="resize: none">{{ $transaksi->paket->deskripsi }}</textarea>
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
                        <h1 class="text-heading display-5 mb-1">Rp{{ number_format($transaksi->paket->harga, 0, ',', '.') }}</h1>
                        {{-- <sub>/one time payment</sub> --}}
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0">Jenis Paket</p>
                        <h6 class="mb-0">{{ $transaksi->paket->nama_paket }}</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0">Masa Aktif</p>
                        <h6 class="mb-0">{{ $transaksi->paket->masa_aktif." ".$transaksi->paket->activation->type }}</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="mb-0">Harga</p>
                        <h6 class="mb-0">Rp{{ number_format($transaksi->paket->harga, 0, ',', '.') }}</h6>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mt-3 pb-1">
                        <p class="mb-0">Total</p>
                        <h6 class="mb-0">Rp{{ number_format($transaksi->paket->harga, 0, ',', '.') }}</h6>
                    </div>
                    <div class="d-grid mt-3">
                        {{-- <a href="{{ $transaksi->payment_url }}" class="btn btn-success" target="_blank" rel="noopener noreferrer">
                            <span class="me-2">Proceed with Payment</span>
                            <i class="ti ti-arrow-right scaleX-n1-rtl"></i>
                        </a> --}}
                        {{-- @if ($status['transaction_status'] == 'pending')
                            <a href="javascript:void(0);" class="btn btn-secondary" >
                                <span class="me-2">Waiting Payment still Pending</span>
                                <i class="ti ti-circle-x scaleX-n1-rtl"></i>
                            </a> --}}
                        {{-- @if (in_array($status['transaction_status'], ['expire', 'cancel', 'deny']))
                            <a href="javascript:void(0);" class="btn btn-danger" >
                                <span class="me-2">Can't Process Payment</span>
                                <i class="ti ti-circle-x scaleX-n1-rtl"></i>
                            </a>
                        @else
                        @endif --}}
                        <a href="javascript:void(0);" class="btn btn-success" id="btn-pay">
                            <span class="me-2">Proceed with Payment</span>
                            <i class="ti ti-arrow-right scaleX-n1-rtl"></i>
                        </a>
                    </div>

                    <p class="mt-4 pt-2">By continuing, you accept to our Terms of Services and Privacy Policy. Please note that payments are non-refundable.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        const btnPay = document.querySelector('#btn-pay')
        btnPay && btnPay.addEventListener('click', function(){
            let token = `{!! $transaksi->payment_url !!}`;
            let _token = $('meta[name="csrf-token"]').attr("content");
            let trans_code = `{{ $transaksi->kode_transaksi }}`
            snap.pay(token, {
                onSuccess: function(result){
                    let orderID = result.order_id;
                    window.location.href = `{{ route('transaksi.payment.setcallback') }}?order_id=${orderID}`
                },
                onPending: function(result){
                    alert('Payment On Pending')
                    window.location.reload();
                    /* You may add your own js here, this is just example */
                    // window.location.href = window.location.href+"&check=true"
                },
                // Optional
                onError: function(result){
                    alert('Failed! Something when wrong, try again!')
                    window.location.reload();
                    /* You may add your own js here, this is just example */
                    // window.location.href = window.location.href+"&check=true"
                }
            });
        })
    </script>
    @push('scripts')

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/cleavejs/cleave.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/front-main.js"></script>


    <!-- Page JS -->
    <script src="/assets/js/front-page-payment.js"></script>

    @endpush
</x-display-layout>
