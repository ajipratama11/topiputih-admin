@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perusahaan</h1>
        <a href="{{ route('company.create') }}" class="btn btn-primary"><i class="fas fa-download fa-sm text-white-50"></i> Tambah Perusahaan</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Perusahaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Nama Kontak</th>
                            <th>Nomor HP Kontak</th>
                            <th>Surat Elektronik</th>
                            <th>Total Program</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                        <tr>
                            <td>{{$company->name}}</td>
                            <td>{{$company->username}}</td>
                            <td>{{$company->email}}</td>
                            <td>{{$company->phone_number}}</td>
                            <td>{{$company->roles}}</td>
                            <td colspan="5">
                                {{-- <a href="/company/edit/{{$company->id}}"><i class="fas fa-trash-alt"></i> Hapus</a>&nbsp;
                                <a href=""><i class="fas fa-edit"></i>Ubah</a> --}}
                                <a class="btn btn-info btn-sm" href="/company/{{$company->id}}/edit">Edit</a>
                                     {{-- <a class="btn btn-primary btn-sm" href="{{ route('company.show', $company->id) }}">CEK</a> --}}
                 
                                     <form action="{{url('company', $company->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                    </td>
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
