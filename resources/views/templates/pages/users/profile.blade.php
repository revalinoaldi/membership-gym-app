<x-display-layout>
    @push('styles')
          <!-- Vendors CSS -->
        <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css">
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css">
        <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css">
        <link rel="stylesheet" href="/assets/vendor/libs/animate-css/animate.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
        <link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

        <!-- Page CSS -->

        <link rel="stylesheet" href="/assets/vendor/css/pages/page-user-view.css" />
    @endpush

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">User / </span> Profile
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

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ auth()->user()->profile_photo_url }}" height="100" width="100" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ auth()->user()->name }}</h4>
                                <span class="badge bg-label-secondary mt-1">{{ auth()->user()->getRoleNames()[0] }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 small text-uppercase text-muted">Details</p>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Member Code:</span>
                                <span>{{ auth()->user()->is_member->member->kode_member }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Email:</span>
                                <span>{{ auth()->user()->email }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Status:</span>
                                @if (auth()->user()->is_member->member->status == "NON ACTIVE" || (\Carbon\Carbon::now()->startOfDay() > \Carbon\Carbon::parse(auth()->user()->is_member->member->expired_date)->startOfDay() ))
                                    <span class="badge bg-label-secondary" text-capitalized> NON ACTIVE</span>
                                @else
                                    <span class="badge bg-label-success" text-capitalized> {{ auth()->user()->is_member->member->status }}</span>
                                @endif
                                {{-- <span class="badge bg-{{ auth()->user()->is_member->member->status == "ACTIVE" ? "label-success" : "label-danger" }}">{{ auth()->user()->is_member->member->status }}</span> --}}
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Role:</span>
                                <span>{{ auth()->user()->getRoleNames()[0] }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Gender:</span>
                                <span>{{ auth()->user()->is_member->member->jenis_kelamin }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">No Telp:</span>
                                <span>{{ auth()->user()->is_member->member->no_telp }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Address:</span>
                                <span>{{ auth()->user()->is_member->member->alamat }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-medium me-1">Register Date:</span>
                                <span>{{ \Carbon\Carbon::parse(auth()->user()->is_member->member->tgl_daftar)->diffForHumans() }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- /User Card -->

            @if (@$member->paket_id)
                <!-- Plan Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="badge bg-label-primary">{{ $member->paket->nama_paket }}</span>
                            <div class="d-flex justify-content-center">
                                <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary fw-normal">Rp</sup>
                                <h1 class="mb-0 text-primary">{{ number_format($member->paket->harga, 0, ',', '.') }}</h1>
                                <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal"></sub>
                            </div>
                        </div>
                        <ul class="ps-3 g-2 my-3">
                            <li class="mb-2">{{ $member->paket->deskripsi }}</li>
                            <li class="mb-2">{{ \Carbon\Carbon::parse($member->expired_date)->format('d M Y H:i:s') }}</li>
                            <li>{!! (\Carbon\Carbon::now() > \Carbon\Carbon::parse($member->expired_date)) ? 'Expired' : \Carbon\Carbon::parse($member->expired_date)->diffForHumans() !!}</li>
                        </ul>
                        <div class="d-grid w-100 mt-4">
                            <a href="{{ route('transaksi.create')."?type=extends" }}" onclick="return confirm(`are you sure to changes plan? \nYou can delete this paket member active`)" class="btn btn-primary">Upgrade Plan</a>
                        </div>
                    </div>
                </div>
                <!-- /Plan Card -->
            @endif
        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            <!-- Project table -->
            <div class="card mb-4">
                <h5 class="card-header">Update User Profile</h5>
                <div class="table-responsive mb-3">
                    <form id="formAuthentication" class="mb-3 px-4" action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" placeholder="Enter your Full Name" autofocus required>
                            <input type="text" name="isMember" value="1" hidden required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" placeholder="Enter your Email" required>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text">(+62)</span>
                                <input type="text" id="no_telp" name="no_telp" class="form-control multi-steps-mobile" value="{{ auth()->user()->is_member->member->no_telp }}" placeholder="202 555 0111" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="jenis_kelamin" id="gender" class="form-select">
                                <option value="Laki-Laki" {{ auth()->user()->is_member->member->jenis_kelamin == "Laki-Laki" ? "selected" : "" }}>Male</option>
                                <option value="Perempuan" {{ auth()->user()->is_member->member->jenis_kelamin == "Perempuan" ? "selected" : "" }}>Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="alamat" placeholder="Enter your Address" required style="resize: none">{{ auth()->user()->is_member->member->alamat }}</textarea>
                        </div>
                        <button class="btn btn-primary d-grid w-100">
                            Save Profile
                        </button>
                    </form>
                </div>
            </div>
            <!-- /Project table -->
            <!-- Invoice table -->
            <div class="card mb-4">
                <div class="table-responsive mb-3">
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
                                {{-- <th class="cell-fit">Actions</th> --}}
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
                                    {{-- <th>
                                        @php
                                            // $dateNow = \Carbon\Carbon::now();
                                            $dateExpired = \Carbon\Carbon::parse($item['expired_date']);
                                            if(@$dateExpired){
                                                echo '<span class="badge bg-label-danger text-capitalized> Expired </span>';
                                            }
                                        @endphp
                                    </th> --}}
                                    <th>{!! (\Carbon\Carbon::now() > \Carbon\Carbon::parse($item['expired_date'])) ? 'Expired' : \Carbon\Carbon::parse($item['expired_date'])->diffForHumans() !!}</th>
                                    {{-- <th>
                                        <a class="btn btn-primary btn-edit" href="{{ route('transaksi.show', $item['kode_transaksi']) }}" title="edit"><i class="ti ti-info-circle me-sm-1"></i></a>
                                    </th> --}}
                                </tr>
                            @endforeach
                         </tbody>
                    </table>
                </div>
            </div>
            <!-- /Invoice table -->
            {{-- Checkin Checkout Table --}}
            <div class="card mb-4">
                <div class="table-responsive mb-3">
                    <table class="invoice-list-table table border-top">
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
            {{-- /Checkin Checkout Table --}}
        </div>
        <!--/ User Content -->
    </div>

    @push('scripts')
        <!-- Vendors JS -->
        <script src="/assets/vendor/libs/moment/moment.js"></script>
        <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
        <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
        <script src="/assets/vendor/libs/cleavejs/cleave.js"></script>
        <script src="/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
        <script src="/assets/vendor/libs/select2/select2.js"></script>
        <script src="/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
        <script src="/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
        <script src="/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>

        <!-- Main JS -->
        <script src="/assets/js/main.js"></script>


        <!-- Page JS -->
        <script src="/assets/js/modal-edit-user.js"></script>
        <script src="/assets/js/app-user-view.js"></script>
        <script src="/assets/js/app-user-view-account.js"></script>
    @endpush
</x-display-layout>
