@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peneliti Keamanan</h1>
        <a href="#" class="btn btn-primary"><i class="fas fa-download fa-sm text-white-50"></i> Tambah Peneliti Keamanan</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Peneliti Keamanan</h6>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <form method="POST" action="{{ url('researcher', $researcher->id ) }}">
                    @csrf
                    @method('PUT')
                    <input name="title" value="{{ $researcher->name }}" type="text" placeholder="Title..."> 
                    <input name="body" value="{{ $researcher->email }}" type="text" placeholder="Body...">
                    <button class="btn-blue">Submit</button>
                  </form>
            </div>
        </div>
    </div>

</div>
@endsection
