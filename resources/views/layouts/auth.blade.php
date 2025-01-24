<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!--end::Fonts-->
    <!-- Scripts -->
    @vite(['resources/sass/master.scss', 'resources/js/app.js','resources/css/app.css'])
</head>
<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
      data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
      data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true"
      data-kt-app-aside-push-footer="true" class="app-default">
<script>var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }</script>

<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Aside-->
    <div class="d-flex flex-column flex-lg-row-auto  tw-bg-gradient-to-b tw-from-blue-300 tw-to-blue-100 w-xl-600px positon-xl-relative">
        <div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
            <!--begin::Logo-->
            <a href="{{ route('admin.dashboard') }}" class="py-2 py-lg-20">
                <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" class="h-40px h-lg-50px">
            </a>
            <!--end::Logo-->
            <!--begin::Title-->
            <h1 class="d-none d-lg-block fw-bold text-primary-emphasis fs-2qx pb-5 pb-md-10">
                Welcome
            </h1>
            <!--end::Title-->
            <!--begin::Description-->
            <p class="d-none d-lg-block fw-semibold fs-2 text-primary-emphasis">
                Space Management System <br>
                Maximize you space , Minimize your worries
            </p>
            <!--end::Description-->
        </div>
    </div>
    <!--begin::Aside-->
    <!--begin::Body-->
    <div class="d-flex flex-column flex-lg-row-fluid py-10">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid">
            @if(session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-icon"><i class="fa fa-check-circle"></i></div>
                    <div class="alert-text">{{ session('status') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!--begin::Wrapper-->
            @yield('content')
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
        <!--begin::Footer-->
        <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
            <!--begin::Links-->
            <div class="d-flex flex-center fw-semibold fs-6">
                <p  class="text-muted text-hover-primary px-2 mb-0" target="_blank">
                    © {{ date('Y') }} RICA - All rights reserved
                </p>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Body-->
</div>

</body>
</html>
