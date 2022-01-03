@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peneliti Keamanan</h1>
        {{-- <a href="{{ route('researcher.create') }}" class="btn btn-primary"><i
                class="fas fa-download fa-sm text-white-50"></i> Tambah Peneliti Keamanan</a> --}}
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
                            <td>{{$researcher->phone_number}}</td>
                            <td>{{$researcher->email}}</td>
                            <td>{{$researcher->roles}}</td>
                            <td>
                                <form action="{{url('researcher', $researcher->id)}}" method="POST">
                                    <a class="btn btn-info btn-sm" href="/researcher/{{$researcher->id}}/edit"><i
                                            class="fas fa-fw fa-edit"></i></a>
                                    <a class="btn btn-info btn-sm"
                                        href="{{ route('researcher.show', $researcher->id)}}"><i
                                            class="fas fa-fw fa-info"></i></a></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                            class="fas fa-fw fa-trash-alt"></i></button>
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