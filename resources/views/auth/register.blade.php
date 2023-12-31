<!DOCTYPE html>
<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Register Member Pages | Natural Fitness Center</title>

    <meta name="description" content="Tempat Anda untuk meraih kesehatan optimal dan bentuk tubuh yang sempurna secara alami. Dengan instruktur berpengalaman, peralatan canggih, dan program pelatihan yang disesuaikan, kami adalah destinasi terbaik untuk mencapai tujuan kebugaran Anda." />
    <meta name="keywords" content="natural fitness center, Pusat kebugaran, Gym, Kesehatan holistik">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">

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
    <!-- Vendor -->
    <link rel="stylesheet" href="/assets/vendor/libs/%40form-validation/umd/styles/index.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css">

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="/assets/vendor/js/template-customizer.js"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="/assets/js/config.js"></script>

    </head>

    <body>


        <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!-- Content -->

        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-4">

                    <!-- Register Card -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center mb-4 mt-2">
                                <a href="index.html" class="app-brand-link gap-2">
                                    <img src="/assets/img/logo/logo.png" class="app-brand-logo demo">

                                    {{-- <span class="app-brand-text demo text-body fw-bold ms-1">Vuexy</span> --}}
                                </a>
                            </div>
                            <!-- /Logo -->

                            <h4 class="mb-1 pt-2">Adventure starts here 🚀</h4>
                            <p class="mb-4">Make your app management easy and fun!</p>

                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form id="formAuthentication" class="mb-3" action="{{ route('register.member') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your Full Name" autofocus required>
                                    <input type="text" name="isMember" value="1" hidden required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your Email" required>
                                </div>
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">(+62)</span>
                                        <input type="text" id="no_telp" name="no_telp" class="form-control multi-steps-mobile" value="{{ old('no_telp') }}" placeholder="202 555 0111" required />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="jenis_kelamin" id="gender" class="form-select">
                                        <option value="Laki-Laki">Male</option>
                                        <option value="Perempuan">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="Address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="alamat" value="{{ old('address') }}" placeholder="Enter your Address" required style="resize: none"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="paket_id" class="form-label">Choose Paket</label>
                                    <select name="paket_id" id="paket_id" class="form-select" required>
                                        <option value="-" hidden selected>Select One</option>
                                    </select>
                                    <input type="number" name="total_biaya" id="total_biaya" readonly required hidden>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                        <label class="form-check-label" for="terms-conditions">
                                            I agree to
                                            <a href="javascript:void(0);">privacy policy & terms</a>
                                        </label>
                                    </div>
                                </div>
                                <button class="btn btn-primary d-grid w-100">
                                    Sign up
                                </button>
                            </form>

                            <p class="text-center">
                                <span>Already have an account?</span>
                                <a href="{{ route('login') }}">
                                    <span>Sign in instead</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- Register Card -->
                </div>
            </div>
        </div>

        <!-- / Content -->

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
        <script src="/assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js"></script>
        <script src="/assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js"></script>
        <script src="/assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js"></script>

        <!-- Main JS -->
        <script src="/assets/js/main.js"></script>


        <!-- Page JS -->
        <script src="/assets/js/pages-auth.js"></script>
        <script>
            $(document).ready(async () => {
                @php
                    if(@auth()->guard('web')->user()){
                        echo "window.location.href='".url('/home')."'";
                    }
                @endphp

                await $.get(`{!! url('api/paket/list') !!}`, (res) => {
                    let optionHtml = ''
                    res.data.map((item) => {
                        let currency = new Intl.NumberFormat("id-ID").format(item.harga)
                        optionHtml += `<option value="${item.id}" data-total="${item.harga}">${item.nama_paket} (Rp${currency})</option>`
                    })
                    $('#paket_id').append(optionHtml)
                })

                $('#paket_id').on('change', () => {
                    const total = $('#paket_id option:selected').attr('data-total')
                    $('#total_biaya').val(total)
                })
            });
        </script>
    </body>


    <!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/auth-register-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 07 Sep 2023 03:02:27 GMT -->
    </html>

    <!-- beautify ignore:end -->

