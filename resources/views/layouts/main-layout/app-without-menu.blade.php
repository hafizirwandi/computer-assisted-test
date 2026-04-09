<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('vuexy/assets') . '/' }}"
    data-template="vertical-menu-template-starter">


@include('layouts.main-layout.header')

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">


            <!-- Layout container -->
            <div class="layout-page">


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y" style="max-width: 1200px;">
                        {{-- {{ Breadcrumbs::render() }} --}}
                        <div class="mb-3"></div>
                        @yield('content')



                    </div>
                    <!-- / Content -->



                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    @include('layouts.main-layout.script')
</body>

</html>
