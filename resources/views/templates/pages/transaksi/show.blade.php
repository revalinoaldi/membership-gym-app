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
                            <h4 class="fw-medium mb-2">INVOICE NUMBER<br>#{{ $transaksi }}</h4>
                            <div class="mb-2 pt-1">
                                <span>Transaction Date:</span> <br>
                                <span class="fw-medium">{{ \Carbon\Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400))->format('l, d F Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row p-sm-3 p-0">
                        <div class="col-xl-7 col-md-12 col-sm-7 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                            <h6 class="mb-3">Invoice To:</h6>
                            <p class="mb-1">[{{ mt_rand(100000000,999999999) }}] - {{ fake()->unique()->name() }}</p>
                            <p class="mb-1">{{ fake()->address() }}</p>
                            <p class="mb-1">(+62) 815-1945-1708</p>
                            <p class="mb-0">{{ fake()->safeEmail() }}</p>
                        </div>
                        <div class="col-xl-5 col-md-12 col-sm-5 col-12">
                            <h6 class="mb-4">Bill To:</h6>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="pe-4">Total:</td>
                                        <td class="fw-medium">Rp2.450.000</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Metode Transfer:</td>
                                        <td>Bank Transfer</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Pembayaran:</td>
                                        <td>BCA VA</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Status:</td>
                                        <td>
                                            Paid
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
                            <tr>
                                <td class="text-nowrap">PAKET TAHUNAN</td>
                                <td>Paket Tahunan + Instruktur Gym + Soft Drink + Dessert</td>
                                <td>1 Year</td>
                                <td>1</td>
                                <td class="text-end">Rp2.450.000</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="align-top px-4 py-4">
                                    &nbsp;
                                </td>
                                <td class="text-end pe-3 py-4">
                                    <p class="mb-2 pt-3">Subtotal:</p>
                                    <p class="mb-2">Discount:</p>
                                    <p class="mb-0 pb-3">Total:</p>
                                </td>
                                <td class="ps-2 py-4 text-end">
                                    <p class="fw-medium mb-2 pt-3">Rp2.450.000</p>
                                    <p class="fw-medium mb-2">Rp.0</p>
                                    <p class="fw-medium mb-0 pb-3">Rp2.450.000</p>
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
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-printer ti-xs me-2"></i>Print</span>
                    </button>
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
