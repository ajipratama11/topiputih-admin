<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrator | topiputih.id</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('img/topiputih.png')}}" rel="icon" />
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>

    <div class="row">
        <div class="col-lg-9">
            <span class="font-weight-bolder"> Nama Peneliti Keamanan </span>
            <p class="font-weight-normal">{{ $researcher->nama }}</p>
            <span class="font-weight-bolder"> Point </span>
            {{-- <p class="font-weight-normal">{{ $point ?? 'Belum Memiliki Point'}}</p>
            <span class="font-weight-bolder">Sertifikat Keahlian</span>
            <p class="font-weight-normal">{{$researcher->cert_count_1($researcher->id) ?? 'Belum Mengisi'}}
            </p>
            <span class="font-weight-bolder">Sertifikat Penghargaan</span>
            <p class="font-weight-normal">{{ $researcher->cert_count_2($researcher->id) ?? 'Belum Mengisi'}}
            </p>
            <span class="font-weight-bolder">Laporan Terkirim</span>
            <p class="font-weight-normal">{{ $researcher->report_count($researcher->id) ?? 'Belum Mengisi'}}
            </p> --}}
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    {{-- <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script> --}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js')}}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js')}}"></script>

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
           $('.ckeditor').ckeditor();
        });
    </script>
</body>

</html>