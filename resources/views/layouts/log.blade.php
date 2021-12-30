<!DOCTYPE html>
<html lang="en">

@include('includes.style')

<body id="page-top">

  

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
              
                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

          @include('includes.footer')
   
   @include('includes.script')
</body>

</html>
