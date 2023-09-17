<x-display-layout>

    @push('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <!-- Page CSS -->

    <link rel="stylesheet" href="/assets/vendor/css/pages/app-invoice.css" />
    @endpush


    <div class="row invoice-preview">
        <!-- Invoice -->
        <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                        <div class="mb-xl-0 mb-4">
                            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                <img src="/assets/img/logo/logo.png" class="app-brand-logo demo" style="width: 10vw">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                        <div class="mb-xl-0 mb-4">
                            <p class="mb-2">Natural Fitness Center</p>
                            <p class="mb-2">Jl. Pangeran Sogiri <br>Ruko No.488,
                                RT.001/RW.001, Tanah Baru,
                                <br>Kec. Bogor Utara, Kota Bogor, Jawa  Barat 16154
                            </p>
                            <p class="mb-0">(+62) 896-5452-7778</p>
                        </div>
                        <div>
                            <h5 class="fw-medium mb-2">INVOICE NUMBER<br>#{{ $transaksi['kode_transaksi'] }}</h5>
                            <div class="mb-2 pt-1">
                                <span>Transaction Date:</span> <br>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($transaksi['tgl_transaksi'])->format('l, d F Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row p-sm-3 p-0">
                        <div class="col-xl-7 col-md-12 col-sm-7 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                            <h6 class="mb-3">Invoice To:</h6>
                            <p class="mb-1">[{{ $transaksi['membership']['kode_member'] }}] - {{ $transaksi['membership']['nama_lengkap'] }}</p>
                            <p class="mb-1">{{ $transaksi['membership']['alamat'] }}</p>
                            <p class="mb-1">(+62) {{ $transaksi['membership']['no_telp'] }}</p>
                            <p class="mb-0">{{ $transaksi['membership']['email'] }}</p>
                        </div>
                        <div class="col-xl-5 col-md-12 col-sm-5 col-12">
                            <h6 class="mb-4">Bill Detail:</h6>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="pe-4">Total:</td>
                                        <td class="fw-medium">Rp{{ number_format($transaksi['total_biaya'], 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Metode Transfer:</td>
                                        <td>Bank Transfer, E-Money</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Tanggal Bayar:</td>
                                        <td>{{ @$transaksi['paid_date'] ? \Carbon\Carbon::parse($transaksi['paid_date'])->format('l, d F Y H:i') : "-" }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Status:</td>
                                        <td>
                                            <span class="badge bg-{{ $transaksi['paid_status'] == 1 ? "label-success" : "label-danger" }}" text-capitalized> {{ $transaksi['paid_status'] == 1 ? "Paid" : "Unpaid" }} </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive border-top">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Item</th>
                                <th class="text-nowrap">Description</th>
                                <th class="text-nowrap">Masa Aktif</th>
                                <th class="text-nowrap">Qty</th>
                                <th class="text-nowrap">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($hargaPaket = number_format($transaksi['paket']['harga'], 0, ',', '.'))
                            <tr>
                                <td class="text-nowrap">{{ $transaksi['paket']['nama_paket'] }}</td>
                                <td>{{ $transaksi['paket']['deskripsi'] }}</td>
                                <td>{{ $transaksi['paket']['masa_aktif'] }} {{ $transaksi['paket']['activation']['type'] }}</td>
                                <td>1</td>
                                <td class="text-end">Rp{{ $hargaPaket }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="align-top px-4 py-4">
                                    &nbsp;
                                </td>
                                <td class="text-end pe-3 py-4">
                                    <p class="mb-2 pt-3">Subtotal:</p>
                                    <p class="mb-2">Discount:</p>
                                    <p class="mb-0 pb-3 " style="font-weight: bold">Total:</p>
                                </td>
                                <td class="ps-2 py-4 text-end">
                                    <p class="fw-medium mb-2 pt-3">Rp{{ $hargaPaket }}</p>
                                    <p class="fw-medium mb-2">Rp.0</p>
                                    <p class="fw-medium mb-0 pb-3 text-bold" style="font-weight: bold">Rp{{ $hargaPaket }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- /Invoice -->

        <!-- Invoice Actions -->
        <div class="col-xl-3 col-md-4 col-12 invoice-actions">
            <div class="card">
                <div class="card-body">
                    <h5>Action :</h5>
                    <button class="btn btn-primary d-grid w-100 mb-2" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                        <a href="{{ route('transaksi.invoice.print', $transaksi['kode_transaksi']) }}" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center justify-content-center text-nowrap text-white"><i class="ti ti-printer ti-xs me-2"></i>Print</a>
                    </button>

                    @hasrole('MEMBERSHIP')
                        <button class="btn btn-primary d-grid w-100 mb-2" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                            <a href="{{ route('transaksi.payment.member', $transaksi['kode_transaksi']) }}" target="_blank" rel="noopener noreferrer" class="d-flex align-items-center justify-content-center text-nowrap text-white"><i class="ti ti-wallet ti-xs me-2"></i>Payment</a>
                        </button>
                    @endhasrole
                </div>
            </div>
        </div>
        <!-- /Invoice Actions -->
    </div>

    @push('scripts')
    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/moment/moment.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="/assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/assets/vendor/libs/cleavejs/cleave-phone.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/offcanvas-add-payment.js"></script>
    <script src="/assets/js/offcanvas-send-invoice.js"></script>
    @endpush
</x-display-layout>
