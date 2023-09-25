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
            <span class="text-muted fw-light">Memberships /</span> Member Users
        </h4>
        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Member</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Status Member</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->is_member->member->kode_member }}</td>
                                <td>{{ $item->name }}</td>
                                <th>{{ $item->email }}</th>
                                <td>{{ $item->is_member->member->jenis_kelamin }}</td>
                                <td>0{{ preg_replace('~^[0\D]++|\D++~', '', $item->is_member->member->no_telp); }}</td>
                                <td>{{ $item->is_member->member->alamat }}</td>
                                <td>
                                    @if ($item->is_member->member->status == "NON ACTIVE" || (\Carbon\Carbon::now()->startOfDay() > \Carbon\Carbon::parse($item->is_member->member->expired_date)->startOfDay() ))
                                        <span class="badge bg-label-secondary" text-capitalized> NON ACTIVE</span>
                                    @else
                                        <span class="badge bg-label-success" text-capitalized> {{ $item->is_member->member->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->is_member->member->tgl_daftar)->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        $(document).ready(() => {
            $('.add-new').on('click', () => {
                alert(`Hello World`)
            })
        })
        $(".datatables-basic").DataTable({
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            order: [
                [8, "desc"]
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
            columnDefs: [
                {
                    "visible": false,
                    "targets": [8]
                }
            ],
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
        }), $("div.head-label").html('<h5 class="card-title mb-0">List Data User</h5>');
    </script>
    @endpush
</x-display-layout>
