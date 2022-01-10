@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="mb-3 text-gray-1000" ><i class="fas fa-fw fa-arrow-left"></i>Kembali</h5>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pemilik Sistem</h1>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 border-right ">
                    <img class="img-profile rounded-circle align-middle" src="{{'/img/profile.jpg'}}">
                </div>
                <div class="col-lg-9">
                    <span class="font-weight-bolder"> Nama Pemilik Sistem </span>
                    <p class="font-weight-normal">{{ $company->name }}</p>
                    <span class="font-weight-bolder"> Nama Kontak </span>
                    <p class="font-weight-normal">{{ $company->username }}</p>
                    <span class="font-weight-bolder"> Nomor HP Kontak </span>
                    <p class="font-weight-normal">{{ $company->phone_number }}</p>
                    <span class="font-weight-bolder">Alamat Surat Elektronik </span>
                    <p class="font-weight-normal">{{ $company->email }}</p>
                    <span class="font-weight-bolder">Total Program </span>
                    <p class="font-weight-normal">{{$company->program_count($company->companyProgram->user_id ??
                        0)}}</p>
                    {{-- <a class="btn btn-primary " href="/company/{{$company->id}}/edit">Edit</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Program Pemilik Sistem</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Pemilik Sistem</th>
                            <th class="col-1">Nama Program</th>
                            <th class="col-1">Nama Perushaan</th>
                            <th class="col-1">Imbalan Tertinggi</th>
                            <th class="col-2">Tanggal Program</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($program as $program )

                        <tr>
                            <td>{{$program->user->name}}</td>
                            <td>{{$program->program_name}}</td>
                            <td>{{$program->company_name}}</td>
                            <td>@currency($program->max_price)</td>

                            <td>
                                {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_start)
                                ->format('d-M-Y');}} -
                                {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_end)
                                ->format('d-M-Y');}}
                            </td>
                            <td class="text-center">
                                <form action="{{url('program', $program->id)}}" method="POST">

                                    <a class="btn btn-info btn-sm" href="/program/{{$program->id}}"><i
                                            class="fas fa-fw fa-info"></i></a></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                            class="fas fa-fw fa-trash-alt"></i></button>
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