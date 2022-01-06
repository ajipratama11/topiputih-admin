@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peneliti Keamanan</h1>
    </div>
{{-- <div class="row">
    <div class="col-lg-4"> --}}
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data</h6>
        </div>
        <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 border-right ">
                            <img class="img-fluid align-middle"
                            src="{{'/img/profile_user/'}}{{$researcher->profile_picture}}">
                        </div>
                        <div class="col-lg-9">
                            <span class="font-weight-bolder"> Nama Peneliti Keamanan </span>
                            <p class="font-weight-normal">{{ $researcher->name }}</p>
                            {{-- <span class="font-weight-bolder"> Nama Pengguna </span>
                            <p class="font-weight-normal">{{ $researcher->username }}</p> --}}
                            <span class="font-weight-bolder"> Nomor HP Kontak </span>
                            <p class="font-weight-normal">{{ $researcher->phone_number }}</p>
                            <span class="font-weight-bolder">Alamat Surat Elektronik </span>
                            <p class="font-weight-normal">{{ $researcher->email }}</p>
                            <span class="font-weight-bolder">Nama Bank </span>
                            <p class="font-weight-normal">{{ $researcher->researcherBank->bank_name }}</p>
                            <span class="font-weight-bolder">Nomor Rekening</span>
                            <p class="font-weight-normal">{{ $researcher->researcherBank->account_number }}</p>
                            <span class="font-weight-bolder">Nama Rekening Bank </span>
                            <p class="font-weight-normal">{{ $researcher->researcherBank->account_name }}</p>
                            {{-- <a class="btn btn-primary " href="/researcher/{{$researcher->id}}/edit">Edit</a> --}}
                        </div>
                    </div>

                </div>
            {{-- </div>
        </div> --}}
    </div>
</div>
</div>

</div>
@endsection
