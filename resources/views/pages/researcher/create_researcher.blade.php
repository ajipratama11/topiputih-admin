@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peneliti Keamanan</h1>
    </div>
<!-- {{-- <div class="row">
    <div class="col-lg-4"> --}} -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
        </div>
          <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="container">
                        <form method="POST" action="{{ route('company.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Pemilik Sistem</label>
                            <input type ="email" class="form-control" >
                           </div>
                          <!-- <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Kontak</label>
                            <input type="email" class="form-control" >
                          </div> -->
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nomor HP Kontak</label>
                            <input type="email" class="form-control" >
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Alamat Surat Elektronik</label>
                            <input type="email" class="form-control" >
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
