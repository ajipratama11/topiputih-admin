@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
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