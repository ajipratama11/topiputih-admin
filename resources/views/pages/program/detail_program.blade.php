@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{url()->previous()}}" class=" mb-4 text-gray-1000"><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-3">
        <h1 class="h3 mb-0 text-gray-800">Program</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data Program</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="text-center">
                        <img class="img-fluid align-middle" style="max-height: 175px"
                            src="{{'/img/program_image/'}}{{$program->program_image}}">
                    </div>
                    <div class="text-center">
                        <a href="{{ route('program_public.edit',$program->id)}}" class="btn btn-primary mt-5"><i
                                class="fas fa-edit fa-sm text-white-50"></i> Edit Program</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-5">
                            <span class="font-weight-bolder"> Nama Pemilik Sistem </span>
                            <p class="font-weight-normal">{{ $program->user->name }}</p>
                            <span class="font-weight-bolder"> Tipe Program </span>
                            <p class="font-weight-normal">{{ $program->type }}</p>
                            <span class="font-weight-bolder"> Status Progam </span>
                            <p class="font-weight-normal">{{ $program->status }}</p>
                        </div>
                        <div class="col-lg-5">
                            <span class="font-weight-bolder"> Nama Progam </span>
                            <p class="font-weight-normal">{{ $program->program_name }}</p>
                            <span class="font-weight-bolder">Tanggal Program </span>
                            <p class="font-weight-normal">
                                {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_start)
                                ->format('d-M-Y');}} -
                                {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_end)
                                ->format('d-M-Y');}}
                            </p>
                            <span class="font-weight-bolder"> Kategori Progam </span>
                            <p class="font-weight-normal">{{ $program->category }}</p>
                        </div>
                    </div>
                    @if ($program->type =="Bug Bounty")
                    <div class="row">
                        <div class="col-lg-2">
                            <span class="font-weight-bolder">Hadiah Tingkat 1</span>
                            <p class="font-weight-normal">@currency($program->price_1)</p>
                        </div>
                        <div class="col-lg-2">
                            <span class="font-weight-bolder">Hadiah Tingkat 2</span>
                            <p class="font-weight-normal">@currency($program->price_2)</p>
                        </div>
                        <div class="col-lg-2">
                            <span class="font-weight-bolder">Hadiah Tingkat 3</span>
                            <p class="font-weight-normal">@currency($program->price_3)</p>
                        </div>
                        <div class="col-lg-2">
                            <span class="font-weight-bolder">Hadiah Tingkat 4</span>
                            <p class="font-weight-normal">@currency($program->price_4)</p>
                        </div>
                        <div class="col-lg-2">
                            <span class="font-weight-bolder">Hadiah Tingkat 5</span>
                            <p class="font-weight-normal">@currency($program->price_5)</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <span class="font-weight-bold align-middle">Deskripsi Program</span>
                            <p class="font-weight-normal">{!! $program->description !!}</p>
                        </div>
                        <div class="card-body">
                            <span class="font-weight-bolder">Cakupan Program</span>
                            <p class="font-weight-normal">{!! $program->scope !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection