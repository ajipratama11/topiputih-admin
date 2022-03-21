@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ubah Password Admin</h6>
        </div>
        <div class="card-body">
            @if ($alert = Session::get('error'))
            <div class="alert alert-warning">
                {{ $alert }}
            </div>
            @endif
            <form method="POST" enctype="multipart/form-data" id="upload-image"
                action="{{ route('pengguna.update',auth()->user()->id) }}">
                <div class="row">
                    @csrf
                    @method('put')
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Password Lama</label>
                            <input name="password_old" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input name="password_new" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input name="password_confirm" type="text" class="form-control">
                        </div>

                    </div>

                </div>
                <button type="submit" class="btn btn-primary ">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection