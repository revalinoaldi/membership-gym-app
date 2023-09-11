<x-display-layout>

    @push('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
    @endpush


    <div class="row">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Invoice /</span> List
        </h4>

        <!-- Invoice List Widget -->

        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-1">24</h3>
                                    <p class="mb-0">Members</p>
                                </div>
                                <span class="avatar me-sm-4">
                                    <span class="avatar-initial bg-label-primary rounded"><i class="ti ti-user ti-md"></i></span>
                                </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                <div>
                                    <h3 class="mb-1">4</h3>
                                    <p class="mb-0">Invoices</p>
                                </div>
                                <span class="avatar me-lg-4">
                                    <span class="avatar-initial bg-label-info rounded"><i class="ti ti-file-invoice ti-md"></i></span>
                                </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                <div>
                                    <h3 class="mb-1">Rp3.700.000</h3>
                                    <p class="mb-0">Paid</p>
                                </div>
                                <span class="avatar me-sm-4">
                                    <span class="avatar-initial bg-label-success rounded"><i class="ti ti-checks ti-md"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="mb-1">Rp70.000</h3>
                                    <p class="mb-0">Unpaid</p>
                                </div>
                                <span class="avatar">
                                    <span class="avatar-initial bg-label-danger rounded"><i class="ti ti-circle-off ti-md"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="invoice-list-table table border-top">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Tgl Transaksi</th>
                            <th>Nama Member</th>
                            <th>Pilihan Paket</th>
                            <th>Aktivasi</th>
                            <th>Total Biaya</th>
                            <th>Status Transaksi</th>
                            <th>Tgl Pembayaran</th>
                            {{-- <th class="cell-fit">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @php($tgl = \Carbon\Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)))
                            <th>
                                <a href="{{ route('transaksi.show', mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99)) }}">{{ mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99) }}</a>
                            </th>
                            <th>{{ $tgl }}</th>
                            <th>[{{ mt_rand(100000000,999999999) }}] - {{ fake()->unique()->name() }}</th>
                            <th>Paket Mingguan</th>
                            <th>7 Days</th>
                            <th>Rp350.000</th>
                            <th>
                                <span class="badge bg-label-success" text-capitalized> Paid </span>
                            </th>
                            <th>{{ $tgl }}</th>
                        </tr>
                        <tr>
                            @php($tgl = \Carbon\Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)))
                            <th>
                                <a href="{{ route('transaksi.show', mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99)) }}">{{ mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99) }}</a>
                            </th>
                            <th>{{ $tgl }}</th>
                            <th>[{{ mt_rand(100000000,999999999) }}] - {{ fake()->unique()->name() }}</th>
                            <th>Paket Bulanan</th>
                            <th>1 Month</th>
                            <th>Rp900.000</th>
                            <th>
                                <span class="badge bg-label-success" text-capitalized> Paid </span>
                            </th>
                            <th>{{ $tgl }}</th>
                        </tr>
                        <tr>
                            @php($tgl = \Carbon\Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400))->format('d F Y H:i') )
                            <th>
                                <a href="{{ route('transaksi.show', mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99)) }}">{{ mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99) }}</a>
                            </th>
                            <th>{{ $tgl }}</th>
                            <th>[{{ mt_rand(100000000,999999999) }}] - {{ fake()->unique()->name() }}</th>
                            <th>Paket Tahunan</th>
                            <th>1 Year</th>
                            <th>Rp2.450.000</th>
                            <th>
                                <span class="badge bg-label-success" text-capitalized> Paid </span>
                            </th>
                            <th>{{ $tgl }}</th>
                        </tr>
                        <tr>
                            @php($tgl = \Carbon\Carbon::today()->subDays(rand(0, 179))->addSeconds(rand(0, 86400)))
                            <th>
                                <a href="{{ route('transaksi.show', mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99)) }}">{{ mt_rand(1000,9999)."-".mt_rand(1000,9999)."-".mt_rand(100,999)."-".mt_rand(100,999)."-".mt_rand(10,99) }}</a>
                            </th>
                            <th>{{ $tgl }}</th>
                            <th>[{{ mt_rand(100000000,999999999) }}] - {{ fake()->unique()->name() }}</th>
                            <th>Paket Harian</th>
                            <th>1 Days</th>
                            <th>Rp70.000</th>
                            <th>
                                <span class="badge bg-label-danger" text-capitalized> Unpaid </span>
                            </th>
                            <th>{{ $tgl }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="/assets/vendor/libs/moment/moment.js"></script>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/js/app-invoice-list.js"></script>
    @endpush
</x-display-layout>
