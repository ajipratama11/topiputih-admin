@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="/peneliti-keamanan" class=" mb-4 text-gray-1000"><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-3">
        <h1 class="h3 mb-0 text-gray-800">Peneliti Keamanan</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 border-right ">
                    <img class="img-fluid align-middle" src="{{'/img/profile_user/'}}{{$researcher->foto_pengguna}}">
                </div>
                <div class="col-lg-9">
                    <span class="font-weight-bolder"> Nama Peneliti Keamanan </span>
                    <p class="font-weight-normal">{{ $researcher->nama }}</p>
                    {{-- <span class="font-weight-bolder"> Nama Pengguna </span>
                    <p class="font-weight-normal">{{ $researcher->username }}</p> --}}
                    <span class="font-weight-bolder"> Nomor HP Kontak </span>
                    <p class="font-weight-normal">{{ $researcher->nomor_telepon }}</p>
                    <span class="font-weight-bolder">Alamat Surat Elektronik </span>
                    <p class="font-weight-normal">{{ $researcher->email }}</p>
                    <span class="font-weight-bolder">Nama Bank </span>
                    <p class="font-weight-normal">{{ $researcher->researcherBank->nama_bank ?? 'Belum Mengisi'}}</p>
                    <span class="font-weight-bolder">Nomor Rekening</span>
                    <p class="font-weight-normal">{{ $researcher->researcherBank->nomor_rekening ?? 'Belum Mengisi'}}
                    </p>
                    <span class="font-weight-bolder">Nama Rekening Bank </span>
                    <p class="font-weight-normal">{{ $researcher->researcherBank->nama_rekening ?? 'Belum Mengisi'}}</p>
                    {{-- <a class="btn btn-primary " href="/researcher/{{$researcher->id}}/edit">Edit</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Sertifikat Pemilik Sistem</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Peneliti Keamanan</th>
                            <th class="col-1">Nama Sertifikat</th>
                            <th class="col-1">Tanggal Sertifikat</th>
                            <th class="col-1">Tipe Sertifikat</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificate as $certificate )

                        <tr>
                            <td>{{$certificate->user->nama}}</td>
                            <td>{{$certificate->nama_sertifikat}}</td>
                            <td>{{$certificate->tanggal_sertifikat}}</td>
                            <td>{{$certificate->tipe_sertifikat}}</td>
                            <td class="text-center">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form method="POST" action="{{route('sertifikat.store')}}">
                                            @csrf
                                            <input type="hidden" id="slug" name="slug" value="{{$certificate->id}}"
                                                readonly>
                                            <button class="btn btn-info btn-sm" type="submit"><i
                                                    class="fas fa-fw fa-info"></i></button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        {{-- <a class="btn btn-info btn-sm"
                                            href="{{ route('sertifikat.show', $certificate->id)}}"><i
                                                class="fas fa-fw fa-info"></i></a></a> --}}
                                        <form action="{{url('sertifikat', $certificate->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                    class="fas fa-fw fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
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