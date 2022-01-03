@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pemilik Sistem</h1>
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
                            <img class="img-profile rounded-circle align-middle"
                                    src="{{'/img/profile.jpg'}}">
                        </div>
                        <div class="col-lg-9">
                            <span class="font-weight-bolder"> Nama Pemilik Sistem </span>
                            <p class="font-weight-normal">{{ $company->name }}</p>
                            <span class="font-weight-bolder"> Nama Kontak </span>
                            <p class="font-weight-normal">{{ $company->username }}</p>
                            <span class="font-weight-bolder"> Nomor HP Kontak </span>
                            <p class="font-weight-normal">{{ $company->phone_number }}</p>
                            <span class="font-weight-bolder">Alamat Surat Elektronik </span>
                            <p class="font-weight-normal">{{ $company->email }}</p>
                            <a class="btn btn-primary " href="/company/{{$company->id}}/edit">Edit</a>
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
