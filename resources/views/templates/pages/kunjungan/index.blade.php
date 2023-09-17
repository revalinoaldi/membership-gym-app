<x-display-layout>

    @push('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css">
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
    <!-- Form Validation -->
    <link rel="stylesheet" href="/assets/vendor/libs/%40form-validation/umd/styles/index.min.css" />
    @endpush


    <div class="row">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Memberships /</span> Kunjungan
        </h4>
        <!-- DataTable with Buttons -->
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

        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-header">
                    <h5>Today Checkin
                        {{-- {{(\Carbon\Carbon::now()->format('Y-m-d') < \Carbon\Carbon::parse(auth()->user()->is_member->member->expired_date)->format('Y-m-d')) ? "Hello" : "World" }} --}}
                        @php
                            // $now = \Carbon\Carbon::now()->startOfDay();
                            // $start = \Carbon\Carbon::parse(auth()->user()->is_member->member->expired_date)->startOfDay();
                            // echo $start->diffInDays()." - {$now} - {$start}";
                        @endphp
                    </h5>
                    @if (auth()->user()->is_member->member->status == "NON ACTIVE" || (\Carbon\Carbon::now()->startOfDay() > \Carbon\Carbon::parse(auth()->user()->is_member->member->expired_date)->startOfDay() ))
                        <div class="alert alert-danger alert-dismissible shadow" role="alert">
                            User is Not Active! You can't do it checkin gym!
                        </div>
                    @endif
                </div>
                <div class="card-body card-widget-separator">
                    @if (empty($today->id))
                        <form id="formCheckin" class="mb-3 px-4" action="{{ route('kunjungan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="kode_dayin" class="form-label">Today Code</label>
                                <input type="number" class="form-control" id="kode_dayin" name="kode_dayin" value="{{ old('kode_dayin') }}" placeholder="Enter Code Day In" required>
                                <small class="text-muted">You can ask in cashier</small>
                            </div>
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                Check In
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success alert-dismissible shadow" role="alert">
                            Today is Already Checkin{{ @$today->checkout_time ? "/Checkout" : "" }}!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <form id="formCheckin" class="mb-3 px-4" action="{{ route('kunjungan.update', $today->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="timeCheckin" class="form-label">Checkin Time</label>
                                @php($tgl = \Carbon\Carbon::parse($today->kunjungan->datein)->format('d M Y')." ".\Carbon\Carbon::parse($today->checkin_time)->format('H:i:s'))
                                <input type="text" class="form-control" id="timeCheckin" name="timeCheckin" value="{{ $tgl }}" placeholder="Enter Code Day In" readonly disabled>
                            </div>

                            @if (@$today->checkout_time)
                                <div class="mb-3">
                                    <label for="timeCheckOut" class="form-label">Checkin Time</label>
                                    @php($tglOut = \Carbon\Carbon::parse($today->kunjungan->datein)->format('d M Y')." ".\Carbon\Carbon::parse($today->checkout_time)->format('H:i:s'))
                                    <input type="text" class="form-control" id="timeCheckOut" name="timeCheckOut" value="{{ $tglOut }}" placeholder="Enter Code Day In" readonly disabled>
                                </div>
                            @else
                                <button class="btn btn-primary d-grid w-100" type="submit">
                                    Check Out
                                </button>
                            @endif
                        </form>
                    @endif

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tgl Kunjungan</th>
                            <th>Waktu Checkin</th>
                            <th>Waktu Checkout</th>
                            <th>Status</th>
                            <th>Penjaga</th>
                            {{-- <th class="cell-fit">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checklist as $check)
                            <tr>
                                <td>#{{ $check->transaction_code }}</td>
                                <td>{{ \Carbon\Carbon::parse($check->kunjungan->datein)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($check->checkin_time)->format('H:i:s') }}</td>
                                <td>{{ isset($check->checkout_time) ? \Carbon\Carbon::parse($check->checkout_time)->format('H:i:s') : '' }}</td>
                                <td>{{ $check->status }}</td>
                                <td>{{ $check->users->name }}</td>
                            </tr>
                        @endforeach
                     </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('dayin.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Form Bulk Date Kunjungan Day In</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="bulk" class="form-label">Total Row Bulk's</label>
                                <input type="number" id="bulk" name="bulk" class="form-control" placeholder="Enter Total Rows" min="1" value="1">
                                <small class="text-muted"><i>NB : Total Rows Bulk's In (Days)</i></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <!-- Flat Picker -->
    <script src="/assets/vendor/libs/moment/moment.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <!-- Form Validation -->
    <script src="/assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js"></script>
    <script src="/assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="/assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js"></script>
    {{-- <script src="/assets/js/tables-datatables-basic.js"></script> --}}

    <script>

        $(".datatables-basic").DataTable({
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            order: [
            [1, "desc"]
            ],
            buttons: [{
                extend: "collection",
                className: "btn btn-label-primary dropdown-toggle me-2",
                text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                buttons: [{
                    extend: "print",
                    text: '<i class="ti ti-printer me-1" ></i>Print',
                    className: "dropdown-item",
                    customize: function(e) {
                        $(e.document.body).css("color", config.colors.headingColor).css("border-color", config.colors.borderColor).css("background-color", config.colors.bodyBg), $(e.document.body).find("table").addClass("compact").css("color", "inherit").css("border-color", "inherit").css("background-color", "inherit")
                    }
                }, {
                    extend: "csv",
                    text: '<i class="ti ti-file-text me-1" ></i>Csv',
                    className: "dropdown-item",
                }, {
                    extend: "excel",
                    text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                    className: "dropdown-item",
                }, {
                    extend: "pdf",
                    text: '<i class="ti ti-file-description me-1"></i>Pdf',
                    className: "dropdown-item",
                }, {
                    extend: "copy",
                    text: '<i class="ti ti-copy me-1" ></i>Copy',
                    className: "dropdown-item",
                }]
            }],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(e) {
                            return "Details of " + e.data().full_name
                        }
                    }),
                    type: "column",
                    renderer: function(e, t, a) {
                        a = $.map(a, function(e, t) {
                            return "" !== e.title ? '<tr data-dt-row="' + e.rowIndex + '" data-dt-column="' + e.columnIndex + '"><td>' + e.title + ":</td> <td>" + e.data + "</td></tr>" : ""
                        }).join("");
                        return !!a && $('<table class="table"/><tbody />').append(a)
                    }
                }
            }
        }), $("div.head-label").html('<h5 class="card-title mb-0">List Day In Gym</h5>');
    </script>
    @endpush
</x-display-layout>
