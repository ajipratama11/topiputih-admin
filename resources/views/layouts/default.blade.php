<!DOCTYPE html>
<html lang="en">

@include('includes.style')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

     @include('includes.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
              @include('includes.topbar')
                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

          @include('includes.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    @include('includes.modal')
   @include('includes.script')
</body>

</html>
