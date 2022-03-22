@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Admin</h6>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" id="upload-image"
                action="{{ route('pengguna.store') }}">
                <div class="row">
                    @csrf
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input name="nama" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control">
                        </div>

                    </div>

                </div>
                <button type="submit" class="btn btn-primary ">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection