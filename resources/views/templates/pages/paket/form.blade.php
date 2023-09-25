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
            <div class="card-header flex-column flex-md-row">
                <div class="head-label">
                    <h5 class="card-title mb-0">List Paket Memberships</h5>
                </div>
            </div>
            <div class="card-body pt-0">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" method="post" action="{{ route('update.paket', $paket->slug) }}">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label" for="nama_paket">Nama Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="nama_paket2" class="input-group-text"><i class='ti ti-briefcase'></i></span>
                            <input type="text" id="nama_paket" value="{{ $paket->nama_paket }}" class="form-control dt-paket-name" name="nama_paket" placeholder="Nama Paket" aria-label="Nama Paket" aria-describedby="nama_paket2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="harga">Harga Paket</label>
                        <div class="input-group input-group-merge">
                            <span id="harga2" class="input-group-text">Rp</span>
                            <input type="number" id="harga" name="harga" class="form-control dt-salary" placeholder="12000" aria-label="12000" value="{{ $paket->harga }}" aria-describedby="harga2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <div class="input-group input-group-merge">
                            <textarea id="deskripsi" name="deskripsi" class="form-control dt-description" placeholder="Deskrkipsi Paket" aria-label="Deskrkipsi Paket" aria-describedby="deskripsi2">{{ $paket->deskripsi }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="masa_aktif">Masa Aktif</label>
                        <div class="input-group">
                            <input type="number" id="masa_aktif" name="masa_aktif" class="form-control dt-activation" placeholder="0" value="{{ $paket->masa_aktif }}" aria-label="0" />
                            <select name="type_activation_id" id="type_activation_id" class="form-select dt-type-activation">
                                <option value="" hidden>-- Select One --</option>
                                @foreach ($aktivasi as $item)
                                <option value="{{ $item->id }}" {{ $paket->activation->id == $item->id ? "selected" : "" }}>{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 text-end mt-3">
                        <button type="submit" name="submitButton" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" onclick="history.back()" data-bs-dismiss="offcanvas">Cancel</button>
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

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <script>
        let fv, offCanvasEl;
        document.addEventListener("DOMContentLoaded", function(e) {
            var t;

            t = document.getElementById("form-add-new-record"),
            fv = FormValidation.formValidation(t, {
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
    </script>
    @endpush
</x-display-layout>
