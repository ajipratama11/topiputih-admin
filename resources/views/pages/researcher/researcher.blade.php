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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peneliti Keamanan</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Lengkap</th>
                            {{-- <th class="col-2">Nama Pengguna</th> --}}
                            <th class="col-1">Alamat Surat Elektronik</th>
                            {{-- <th class="col-1">Nama Bank</th>
                            <th class="col-1">Nomor Rekening</th> --}}
                            <th class="col-1">Banyak Sertifikat<br>Keahlian</th>
                            <th class="col-1">Banyak Sertifikat Penghargaan</th>
                            <th class="col-1">Laporan Terkirim</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($researchers as $researcher)
                        <tr>
                            <td>{{$researcher->name}}</td>
                            <td>{{$researcher->email}}</td>
                            <td>{{$researcher->cert_count_1($researcher->id)}} Sertifikat</td>
                            <td>{{$researcher->cert_count_2($researcher->id)}} Sertifikat</td>
                            <td>{{$researcher->report_count($researcher->id)}} Laporan</td>
                            <td class="text-center">
                                <form action="{{url('peneliti-keamanan', $researcher->id)}}" method="POST">
                                    {{-- <a class="btn btn-info btn-sm" href="/researcher/{{$researcher->id}}/edit"><i
                                            class="fas fa-fw fa-edit"></i></a> --}}
                                    <a class="btn btn-info btn-sm"
                                        href="{{ route('peneliti-keamanan.show', $researcher->slug)}}"><i
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

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

@endsection