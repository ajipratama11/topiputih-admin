@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="/report" class=" mb-4 text-gray-1000"><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-3">
        <h1 class="h3 mb-0 text-gray-800">Laporan Program</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Data Laporan</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <span class="font-weight-bolder"> Nama Program </span>
                    <p class="font-weight-normal">{{ $report->program->program_name }}</p>
                    <span class="font-weight-bolder"> Kategori </span>
                    <p class="font-weight-normal">{{ $report->category_report}}</p>
                    <span class="font-weight-bolder"> Cakupan </span>
                    <p class="font-weight-normal">{{ $report->scope_report}}</p>
                </div>
                <div class="col-lg-4">
                    <span class="font-weight-bolder"> Tanggal Program </span>
                    <p class="font-weight-normal">
                        {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d',
                        $report->program->date_start)
                        ->format('d-M-Y');}} -
                        {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d',
                        $report->program->date_end)->format('d-M-Y');}}</p>
                    <span class="font-weight-bolder"> Tanggal Laporan </span>
                    <p class="font-weight-normal"> {{$date = \Carbon\Carbon::createFromFormat('Y-m-d',
                        $report->date)->format('d-M-Y');}} </p>
                    <span class="font-weight-bolder"> Status </span>
                    <p class="font-weight-normal">{{ $report->status_report}}</p>
                </div>
                <div class="col-lg-4">
                </div>
                <div class="col-lg-4 mt-3">
                    <a href="{{'/file/report/'}}{{$report->file}}" download="{{$report->file}}"
                        class="btn btn-primary"><i class="fas fa-fw fa-download"></i> Unduh File </a>
                </div>
                <div class="col-lg-4 mt-3">
                    <a href="" class="btn btn-primary"><i class="fas fa-fw fa-edit"></i> Ubah Status</a>
                </div>
                <div class="col-lg-4 mt-3">

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="col-lg-12 border-bottom">
                                <span class="font-weight-bold"> Ringkasan </span>
                                <p class="font-weight-normal">{{ $report->summary }}</p>

                                <span class="font-weight-bold"> Dampak </span>
                                <p class="font-weight-normal">{{ $report->impact }}</p>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <span class=" font-weight-bold"> Deskripsi </span>
                                <p class="font-weight-normal">{!! $report->description_report !!}</p>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection