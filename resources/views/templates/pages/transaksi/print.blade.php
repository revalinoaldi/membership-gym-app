<!DOCTYPE html>

<html lang="en" class="light-style layout-wide " dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Natural Finess Center Apps') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/tabler-icons.css"/>
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />


    <!-- Page CSS -->

    <link rel="stylesheet" href="/assets/vendor/css/pages/app-invoice-print.css" />

    <!-- Styles -->
    @livewireStyles

    <body>
        <!-- Content -->

        <div class="invoice-print p-5">
            <div class="d-flex justify-content-between flex-row">
                <div class="mb-4">
                    <div class="d-flex svg-illustration mb-3 gap-2">
                        <div class="mb-xl-0 mb-4">
                            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                <img src="/assets/img/logo/logo.png" class="app-brand-logo demo" style="width: 15vw">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-row gap-4">
                <div class="mb-4">
                    <p class="mb-1">Natural Fitness Center</p>
                    <p class="mb-1">Jl. Pangeran Sogiri <br>Ruko No.488,
                        RT.001/RW.001, Tanah Baru,
                        <br>Kec. Bogor Utara, Kota Bogor, Jawa  Barat 16154</p>
                    <p class="mb-0">(+62) 896-5452-7778</p>
                </div>
                <div>
                    <h5 class="fw-medium">INVOICE <br>#{{ $transaksi['kode_transaksi'] }}</h5>
                    <div>
                        <span class="text-muted">Transaction Date:</span> <br>
                        <span class="fw-medium">{{ \Carbon\Carbon::parse($transaksi['tgl_transaksi'])->format('l, d F Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row d-flex justify-content-between mb-4">
                <div class="col-sm-6 w-50">
                    <h6>Invoice To:</h6>
                    <p class="mb-1">[{{ $transaksi['membership']['kode_member'] }}] - {{ $transaksi['membership']['nama_lengkap'] }}</p>
                    <p class="mb-1">{{ $transaksi['membership']['alamat'] }}</p>
                    <p class="mb-1">(+62) {{ $transaksi['membership']['no_telp'] }}</p>
                    <p class="mb-0">{{ $transaksi['membership']['email'] }}</p>
                </div>
                <div class="col-sm-6 w-50">
                    <h6>Bill Detail:</h6>
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

            <div class="table-responsive">
                <table class="table m-0">
                    <thead class="table-light">
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


            <!-- Core JS -->
            <!-- build:js assets/vendor/js/core.js -->

            <script src="/assets/vendor/libs/jquery/jquery.js"></script>
            <script src="/assets/vendor/libs/popper/popper.js"></script>
            <script src="/assets/vendor/js/bootstrap.js"></script>
            <script src="/assets/vendor/libs/node-waves/node-waves.js"></script>
            <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
            <script src="/assets/vendor/libs/hammer/hammer.js"></script>
            <script src="/assets/vendor/libs/i18n/i18n.js"></script>
            <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>
            <script src="/assets/vendor/js/menu.js"></script>

            <!-- endbuild -->

            <!-- Vendors JS -->



            <!-- Main JS -->
            <script src="/assets/js/main.js"></script>


            <!-- Page JS -->
            <script src="/assets/js/app-invoice-print.js"></script>

        </body>

        </html>

        <!-- beautify ignore:end -->

