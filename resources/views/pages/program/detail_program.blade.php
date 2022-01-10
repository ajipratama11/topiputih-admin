@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a  href="{{url()->previous()}}" class=" mb-4 text-gray-1000" ><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-3">
        <h1 class="h3 mb-0 text-gray-800">Program</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- <div class="col-lg-3 border-right ">
                    <img class="img-profile rounded-circle align-middle" src="{{'/img/profile.jpg'}}">
                </div> --}}
                <div class="col-lg-9">
                    <span class="font-weight-bolder"> Nama Pemilik Sistem </span>
                    <p class="font-weight-normal">{{ $program->user->name }}</p>
                    <span class="font-weight-bolder"> Nama Progam </span>
                    <p class="font-weight-normal">{{ $program->program_name }}</p>
                    <span class="font-weight-bolder"> Nana Perusahaan </span>
                    <p class="font-weight-normal">{{ $program->company_name }}</p>
                    <span class="font-weight-bolder">Imbalan Tertinggi</span>
                    <p class="font-weight-normal">@currency($program->max_price)</p>
                    <span class="font-weight-bolder">Tanggal Program </span>
                    <p class="font-weight-normal">
                        {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_start)
                        ->format('d-M-Y');}} -
                        {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_end)
                        ->format('d-M-Y');}}
                    </p>
                    <span class="font-weight-bolder">Deskripsi Program</span>
                    <p class="font-weight-normal">{{ $program->description }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection