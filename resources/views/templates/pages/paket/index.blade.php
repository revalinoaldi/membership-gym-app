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
            <span class="text-muted fw-light">Memberships /</span> Paket
        </h4>
        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Paket</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Masa Aktif</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Paket Harian</td>
                            <td>Rp250.000</td>
                            <td>Paket Harian + Instruktur Gym</td>
                            <td>1 Days</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>#</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Paket Mingguan</td>
                            <td>Rp350.000</td>
                            <td>Paket Mingguan + Instruktur Gym</td>
                            <td>7 Days</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>#</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Paket Bulanan</td>
                            <td>Rp600.000</td>
                            <td>Paket Mingguan + Instruktur Gym + Soft Drink</td>
                            <td>1 Month</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>#</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal to add new record -->
        <div class="offcanvas offcanvas-end" id="add-new-record">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="exampleModalLabel">New Record</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body flex-grow-1">
                <form class="add-new-record pt-0 row g-2" id="form-add-new-record" onsubmit="return false">
                    <div class="col-sm-12">
                        <label class="form-label" for="basicFullname">Full Name</label>
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ti ti-user"></i></span>
                            <input type="text" id="basicFullname" class="form-control dt-full-name" name="basicFullname" placeholder="John Doe" aria-label="John Doe" aria-describedby="basicFullname2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicPost">Post</label>
                        <div class="input-group input-group-merge">
                            <span id="basicPost2" class="input-group-text"><i class='ti ti-briefcase'></i></span>
                            <input type="text" id="basicPost" name="basicPost" class="form-control dt-post" placeholder="Web Developer" aria-label="Web Developer" aria-describedby="basicPost2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicEmail">Email</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-mail"></i></span>
                            <input type="text" id="basicEmail" name="basicEmail" class="form-control dt-email" placeholder="john.doe@example.com" aria-label="john.doe@example.com" />
                        </div>
                        <div class="form-text">
                            You can use letters, numbers & periods
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicDate">Joining Date</label>
                        <div class="input-group input-group-merge">
                            <span id="basicDate2" class="input-group-text"><i class='ti ti-calendar'></i></span>
                            <input type="text" class="form-control dt-date" id="basicDate" name="basicDate" aria-describedby="basicDate2" placeholder="MM/DD/YYYY" aria-label="MM/DD/YYYY" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="basicSalary">Salary</label>
                        <div class="input-group input-group-merge">
                            <span id="basicSalary2" class="input-group-text"><i class='ti ti-currency-dollar'></i></span>
                            <input type="number" id="basicSalary" name="basicSalary" class="form-control dt-salary" placeholder="12000" aria-label="12000" aria-describedby="basicSalary2" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
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

    <script>
        let fv, offCanvasEl;
        document.addEventListener("DOMContentLoaded", function(e) {
            var t;
            t = document.getElementById("form-add-new-record"), setTimeout(() => {
                const e = document.querySelector(".create-new"),
                t = document.querySelector("#add-new-record");
                e && e.addEventListener("click", function() {
                    offCanvasEl = new bootstrap.Offcanvas(t), t.querySelector(".dt-full-name").value = "", t.querySelector(".dt-post").value = "", t.querySelector(".dt-email").value = "", t.querySelector(".dt-date").value = "", t.querySelector(".dt-salary").value = "", offCanvasEl.show()
                })
            }, 200), fv = FormValidation.formValidation(t, {
                fields: {
                    basicFullname: {
                        validators: {
                            notEmpty: {
                                message: "The name is required"
                            }
                        }
                    },
                    basicPost: {
                        validators: {
                            notEmpty: {
                                message: "Post field is required"
                            }
                        }
                    },
                    basicEmail: {
                        validators: {
                            notEmpty: {
                                message: "The Email is required"
                            },
                            emailAddress: {
                                message: "The value is not a valid email address"
                            }
                        }
                    },
                    basicDate: {
                        validators: {
                            notEmpty: {
                                message: "Joining Date is required"
                            },
                            date: {
                                format: "MM/DD/YYYY",
                                message: "The value is not a valid date"
                            }
                        }
                    },
                    basicSalary: {
                        validators: {
                            notEmpty: {
                                message: "Basic Salary is required"
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
                    autoFocus: new FormValidation.plugins.AutoFocus
                },
                init: e => {
                    e.on("plugins.message.placed", function(e) {
                        e.element.parentElement.classList.contains("input-group") && e.element.parentElement.insertAdjacentElement("afterend", e.messageElement)
                    })
                }
            }), flatpickr(t.querySelector('[name="basicDate"]'), {
                enableTime: !1,
                dateFormat: "m/d/Y",
                onChange: function() {
                    fv.revalidateField("basicDate")
                }
            })
        }), $(function() {
        })
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
                    // exportOptions: {
                    //     columns: [3, 4, 5, 6, 7],
                    //     format: {
                    //         body: function(e, t, a) {
                    //             var s;
                    //             return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                    //                 void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                    //             }), s)
                    //         }
                    //     }
                    // },
                    customize: function(e) {
                        $(e.document.body).css("color", config.colors.headingColor).css("border-color", config.colors.borderColor).css("background-color", config.colors.bodyBg), $(e.document.body).find("table").addClass("compact").css("color", "inherit").css("border-color", "inherit").css("background-color", "inherit")
                    }
                }, {
                    extend: "csv",
                    text: '<i class="ti ti-file-text me-1" ></i>Csv',
                    className: "dropdown-item",
                    // exportOptions: {
                    //     columns: [3, 4, 5, 6, 7],
                    //     format: {
                    //         body: function(e, t, a) {
                    //             var s;
                    //             return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                    //                 void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                    //             }), s)
                    //         }
                    //     }
                    // }
                }, {
                    extend: "excel",
                    text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                    className: "dropdown-item",
                    // exportOptions: {
                    //     columns: [3, 4, 5, 6, 7],
                    //     format: {
                    //         body: function(e, t, a) {
                    //             var s;
                    //             return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                    //                 void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                    //             }), s)
                    //         }
                    //     }
                    // }
                }, {
                    extend: "pdf",
                    text: '<i class="ti ti-file-description me-1"></i>Pdf',
                    className: "dropdown-item",
                    // exportOptions: {
                    //     columns: [3, 4, 5, 6, 7],
                    //     format: {
                    //         body: function(e, t, a) {
                    //             var s;
                    //             return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                    //                 void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                    //             }), s)
                    //         }
                    //     }
                    // }
                }, {
                    extend: "copy",
                    text: '<i class="ti ti-copy me-1" ></i>Copy',
                    className: "dropdown-item",
                    // exportOptions: {
                    //     columns: [3, 4, 5, 6, 7],
                    //     format: {
                    //         body: function(e, t, a) {
                    //             var s;
                    //             return e.length <= 0 ? e : (e = $.parseHTML(e), s = "", $.each(e, function(e, t) {
                    //                 void 0 !== t.classList && t.classList.contains("user-name") ? s += t.lastChild.firstChild.textContent : void 0 === t.innerText ? s += t.textContent : s += t.innerText
                    //             }), s)
                    //         }
                    //     }
                    // }
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
