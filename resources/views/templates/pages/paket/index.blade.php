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
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
    <!-- Form Validation -->
    <link rel="stylesheet" href="/assets/vendor/libs/%40form-validation/umd/styles/index.min.css" />
    @endpush


    <div class="row">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Memberships /</span> Paket
        </h4>
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
        {{-- Error Start --}}
        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Paket</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Masa Aktif</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pakets as $paket)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $paket['nama_paket'] }}</td>
                            <td class="text-end">Rp{{ number_format($paket['harga'], 0, ',', '.') }}</td>
                            <td>{{ $paket['deskripsi'] }}</td>
                            <td class="text-center">{{ $paket['masa_aktif'] }} {{ $paket['activation']['type'] }}</td>
                            <td class="text-center">{{ $paket['activation']['description'] }}</td>
                            <td>
                                <span class="badge bg-{{ $paket['deleted_at'] == NULL ? "success" : "danger" }}">{{ $paket['deleted_at'] == NULL ? "Active" : "Not Active" }}</span>
                            </td>
                            <td class="text-center">
                                @if ($paket['deleted_at'] == null)
                                <a class="btn btn-primary btn-edit" href="{{ route('paket.edit', $paket['slug']) }}" title="edit"><i class="ti ti-pencil me-sm-1"></i></a>
                                <form action="{{ route('delete.paket', $paket['slug']) }}" method="POST" style="display: inline">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('You sure delete this data?');" type="submit" class="btn btn-danger btn-destroy" data-id="{{ $paket['slug'] }}" title="delete"><i class="ti ti-trash me-sm-1"></i></button>
                                </form>
                                @else
                                <form action="{{ route('restore.paket', $paket['slug']) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Restore Data" onclick="return confirm('You sure restore this data?');" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ti ti-arrow-back me-sm-1"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal to add new record -->
        <div class="offcanvas offcanvas-end" id="add-new-record">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">Form Paket</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" method="post" action="{{ route('save.paket') }}">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label" for="nama_paket">Nama Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="nama_paket2" class="input-group-text"><i class='ti ti-briefcase'></i></span>
                            <input type="text" id="nama_paket" class="form-control dt-paket-name" name="nama_paket" placeholder="Nama Paket" aria-label="Nama Paket" aria-describedby="nama_paket2" />
                            <input type="text" id="slug" name="slug" readonly required hidden>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="harga">Harga Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="harga2" class="input-group-text">Rp</span>
                            <input type="number" id="harga" name="harga" class="form-control dt-salary" placeholder="12000" aria-label="12000" aria-describedby="harga2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <div class="input-group input-group-merge">
                            <textarea id="deskripsi" name="deskripsi" class="form-control dt-description" placeholder="Deskrkipsi Paket" aria-label="Deskrkipsi Paket" aria-describedby="deskripsi2"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="masa_aktif">Masa Aktif</label>
                        <div class="input-group">
                            <input type="number" id="masa_aktif" name="masa_aktif" class="form-control dt-activation" placeholder="0" aria-label="0" />
                            <select name="type_activation_id" id="type_activation_id" class="form-select dt-type-activation">
                                <option value="" hidden>-- Select One --</option>
                                @foreach ($aktivasi as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" name="submitButton" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
        <!--/ DataTable with Buttons -->
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

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <script>
        let fv, offCanvasEl;
        document.addEventListener("DOMContentLoaded", function(e) {
            var t;

            t = document.getElementById("form-add-new-record"),
            setTimeout(() => {
                const e = document.querySelector(".create-new"),
                t = document.querySelector("#add-new-record");
                e && e.addEventListener("click", function() {
                    offCanvasEl = new bootstrap.Offcanvas(t),
                    t.querySelector(".dt-paket-name").value = "",
                    t.querySelector(".dt-salary").value = "",
                    t.querySelector(".dt-description").value = "",
                    t.querySelector(".dt-activation").value = "",
                    t.querySelector(".dt-type-activation").value = "",
                    offCanvasEl.show()
                });


            }, 200), fv = FormValidation.formValidation(t, {
                fields: {
                    nama_paket: {
                        validators: {
                            notEmpty: {
                                message: "Nama Paket Tidak Boleh Kosong"
                            }
                        }
                    },
                    harga: {
                        validators: {
                            notEmpty: {
                                message: "Harga Paket Tidak Boleh Kosong"
                            }
                        }
                    },
                    deskripsi: {
                        validators: {
                            notEmpty: {
                                message: "Deskripsi Paket Tidak Boleh Kosong"
                            }
                        }
                    },
                    masa_aktif: {
                        validators: {
                            notEmpty: {
                                message: "Masa Aktif Paket Tidak Boleh Kosong"
                            }
                        }
                    },
                    type_activation_id: {
                        validators: {
                            notEmpty: {
                                message: "Jenis Masa Aktif Paket Tidak Boleh Kosong"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: "",
                        rowSelector: ".col-sm-12"
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton,
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit,
                    autoFocus: new FormValidation.plugins.AutoFocus
                },
                init: e => {
                    e.on("plugins.message.placed", function(e) {
                        e.element.parentElement.classList.contains("input-group") &&
                        e.element.parentElement.insertAdjacentElement("afterend", e.messageElement)
                    })
                }
            })
        }), $(function() {
        })
        // function
        $(".datatables-basic").DataTable({
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            // displayLength: 7,
            // lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [{
                extend: "collection",
                className: "btn btn-label-primary dropdown-toggle me-2",
                text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                buttons: [{
                    extend: "print",
                    text: '<i class="ti ti-printer me-1" ></i>Print',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6],
                    },
                    customize: function(e) {
                        $(e.document.body).css("color", config.colors.headingColor)
                        .css("border-color", config.colors.borderColor)
                        .css("background-color", config.colors.bodyBg), $(e.document.body)
                        .find("table").addClass("compact")
                        .css("color", "inherit")
                        .css("border-color", "inherit")
                        .css("background-color", "inherit")
                    }
                }, {
                    extend: "csv",
                    text: '<i class="ti ti-file-text me-1" ></i>Csv',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6],
                    }
                }, {
                    extend: "excel",
                    text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6],
                    }
                }, {
                    extend: "pdf",
                    text: '<i class="ti ti-file-description me-1"></i>Pdf',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6],
                    }
                }, {
                    extend: "copy",
                    text: '<i class="ti ti-copy me-1" ></i>Copy',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6],
                    }
                }]
            }, {
                text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Record</span>',
                className: "create-new btn btn-primary"
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
        }), $("div.head-label").html('<h5 class="card-title mb-0">List Paket Memberships</h5>');
    </script>
    @endpush
</x-display-layout>
