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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Nama Pengguna</th>
                            <th>Nomor HP</th>
                            <th>Surat Elektronik</th>
                            <th>Point</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($researchers as $researcher)
                        <tr>
                            <td>{{$researcher->name}}</td>
                            <td>{{$researcher->username}}</td>
                            <td>{{$researcher->email}}</td>
                            <td>{{$researcher->phone_number}}</td>
                            <td>{{$researcher->roles}}</td>
                            <td>
                                {{-- <a href=""><i class="fas fa-trash-alt"></i> Hapus</a>&nbsp;
                                <a href=""><i class="fas fa-edit"></i>Ubah</a> --}}
                                    <a class="btn btn-info btn-sm" href="{{ route('researcher.edit', $researcher->id) }}">Edit</a>
                 
                                     <a class="btn btn-primary btn-sm" href="{{ route('researcher.show', $researcher->id) }}">CEK</a>
                 
                                     <form action="{{url('researcher', $researcher->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                    </td>
                        </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
