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
                                    <h3 class="mb-1">{{ $member }}</h3>
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
                                    <h3 class="mb-1">{{ $invoice }}</h3>
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
                                    <h3 class="mb-1">Rp{{ number_format($paid, 0, ',', '.') }}</h3>
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
                                    <h3 class="mb-1">Rp{{ number_format($unpaid, 0, ',', '.') }}</h3>
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
                            <th>Expired Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                            <tr>
                                <th>
                                    <a href="{{ route('transaksi.show', $item['kode_transaksi']) }}">{{ $item['kode_transaksi'] }}</a>
                                </th>
                                <th>{{ \Carbon\Carbon::parse($item['tgl_transaksi'])->format('d M Y') }}</th>
                                <th>[{{ $item['membership']['kode_member'] }}] - {{ $item['membership']['nama_lengkap'] }}</th>
                                <th>{{ $item['paket']['nama_paket'] }}</th>
                                <th>{{ $item['paket']['masa_aktif'] }} {{ $item['paket']['activation']['type'] }}</th>
                                <th>Rp{{ number_format($item['total_biaya'], 0, ',', '.') }}</th>
                                <th>
                                    <span class="badge bg-{{ $item['paid_status'] == 1 ? "label-success" : "label-danger" }}" text-capitalized> {{ $item['paid_status'] == 1 ? "Paid" : "Unpaid" }} </span>
                                </th>
                                <th>{{ @$item['paid_date'] ? \Carbon\Carbon::parse($item['paid_date'])->format('d M Y') : "-" }}</th>
                                <th>{!! (\Carbon\Carbon::now() > \Carbon\Carbon::parse($item['expired_date'])) ? 'Expired' : \Carbon\Carbon::parse($item['expired_date'])->diffForHumans() !!}</th>
                            </tr>
                        @endforeach
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
