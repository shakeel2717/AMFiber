<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Authentication {{ env('APP_NAME') }}</title>

    <meta name="description" content="{{ env('APP_DESC') }}">
    <meta name="author" content="asanwebs">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
</head>

<body>
    <div id="page-container">
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('assets/media/photos/photo22@2x.jpg');">
                <div class="row g-0 bg-primary-op">
                    <!-- Main Section -->
                    <div class="hero-static col-md-6 d-flex align-items-center bg-body-extra-light">
                        <div class="p-3 w-100">
                            <!-- Header -->
                            <div class="mb-3 text-center">
                                <a class="link-fx fw-bold fs-1" href="{{ route('login') }}">
                                    <span class="text-dark">{{ env('APP_NAME') }}</span>
                                </a>
                                <p class="text-uppercase fw-bold fs-sm text-muted">Sign In</p>
                            </div>
                            <!-- END Header -->
                            <div class="row g-0 justify-content-center">
                                <div class="col-sm-8 col-xl-6">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="py-3">
                                            <div class="mb-4">
                                                <input type="text" class="form-control form-control-lg form-control-alt" id="email" name="email" placeholder="Email">
                                            </div>
                                            <div class="mb-4">
                                                <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <button type="submit" class="btn w-100 btn-lg btn-hero btn-primary">
                                                <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Sign In
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- END Sign In Form -->
                        </div>
                    </div>
                    <!-- END Main Section -->

                    <!-- Meta Info Section -->
                    <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
                        <div class="p-3">
                            <p class="display-4 fw-bold text-white mb-3">
                                Welcome to {{ env('APP_NAME') }}
                            </p>
                            <p class="fs-lg fw-semibold text-white-75 mb-0">
                                Copyright &copy; <span data-toggle="year-copy"></span>
                            </p>
                        </div>
                    </div>
                    <!-- END Meta Info Section -->
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
    <script src="assets/js/dashmix.app.min.js"></script>
    <script src="assets/js/lib/jquery.min.js"></script>
    <x-alert />
</body>

</html>