@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perusahaan</h1>
    </div>
{{-- <div class="row">
    <div class="col-lg-4"> --}}
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="container">
                    <form method="post" action="{{ route('company.update', $company->id) }}">
                        @csrf
                        @method('put')
                            <div class="mb-3">
                            <label   class="form-label">Nama Pemilik Sistem</label>
                            <input name="name" class="form-control" value="{{ $company->name }}" >
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Kontak</label>
                            <input name="username" class="form-control"value="{{ $company->username }}" >
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nomor HP Kontak</label>
                            <input name="phone_number" class="form-control" value="{{ $company->phone_number }}">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Alamat Surat Elektronik</label>
                            <input name="email" class="form-control" value="{{ $company->email }}">
                          </div>
                          
                        <button type="submit" class="btn btn-primary ">Submit</button>
                      </form>
                    </div>
                </div>
            {{-- </div>
        </div> --}}
    </div>
</div>
</div>

</div>
@endsection
