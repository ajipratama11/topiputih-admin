@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{url()->previous()}}" class=" mb-4 text-gray-1000" ><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-3">
        <h1 class="h3 mb-0 text-gray-800">Peneliti Keamanan</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Sertifikat</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-fluid align-middle" src="{{'/img/certificate/'}}{{$certificate->cert_file}}">
                </div>
            </div>
        </div>
    </div>
   
</div>

@endsection