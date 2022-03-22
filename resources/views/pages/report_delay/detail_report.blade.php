@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="/laporan-menunggu" class=" mb-4 text-gray-1000"><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
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
                    <span class="font-weight-bolder"> Tanggal Laporan </span>
                    <p class="font-weight-normal"> {{$date = \Carbon\Carbon::createFromFormat('Y-m-d',
                        $report->date)->format('d-M-Y');}} </p>

                </div>
                <div class="col-lg-4">
                    <span class="font-weight-bolder"> Tanggal Program </span>
                    <p class="font-weight-normal">
                        {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d',
                        $report->program->date_start)
                        ->format('d-M-Y');}} -
                        {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d',
                        $report->program->date_end)->format('d-M-Y');}}</p>
                </div>
                <div class="col-lg-4">
                </div>
                <div class="col-lg-4">
                    <span class="font-weight-bolder"> Objek</span>
                    <p class="font-weight-normal">{{ $report->scope_report}}</p>
                </div>
                <div class="col-lg-4">

                    <span class="font-weight-bolder"> Kategori </span>
                    <p class="font-weight-normal">{{ $report->categoryReport->category}} - {{
                        $report->categoryReport->detail}}</p>
                </div>
                <div class="col-lg-4">
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="col-lg-12 border-bottom">
                                <span class="font-weight-bold"> Kerentanan </span>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 ">
                            <span class="font-weight-bolder"> Laporan </span>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 mt-3">
                    <a href="{{'/file/report/'}}{{$report->file}}" download="{{$report->file}}"
                        class="btn btn-primary"><i class="fas fa-fw fa-download"></i> Unduh File </a>
                </div>
                <div class="col-lg-12 mt-3">
                    <form method="POST" action="{{route('laporan.update',$report->id)}}">
                        @csrf
                        @method('put')
                        <span class="font-weight-bolder">Catatan</span>
                        <input name="note" type="text" class="form-control mb-3" value="{{$report->note}}">
                        <input name="category_id" type="hidden" class="form-control mb-3"
                            value="{{$report->category_id}}">
                        <input name="status_report" type="hidden" class="form-control mb-3"
                            value="{{$report->status_report}}">
                        <input name="status_causes" type="hidden" class="form-control mb-3"
                            value="{{$report->status_causes}}">
                        <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                    </form>
                </div>
                <div class="col-lg-12 mt-3">
                    <div class="row">
                        <div class="col-lg-5 ">
                            <span class="font-weight-bolder"> Kategori : </span>
                            <p class="font-weight-normal">{{ $report->categoryReport->category}} - {{
                                $report->categoryReport->detail}} </p>
                        </div>
                        <div class="col-lg-4 ">
                            <span class="font-weight-bolder"> Status : {{ $report->status_report}} </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 mt-3">
                    <a data-toggle="modal" data-target="#change-category" class="btn btn-primary"><i
                            class="fas fa-fw fa-edit"></i> Sesuaikan Kategori</a>
                </div>
                <div class="col-lg-4 mt-3">
                    @if ($report->status_report !="Disetujui")
                    <a data-toggle="modal" data-target="#change-status" class="btn btn-primary"><i
                            class="fas fa-fw fa-edit"></i> Ubah Status</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="change-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('laporan.update',$report->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <select name="status_report" class="custom-select" id="target">
                        <option value="Diterima" {{ $report->status_report == 'Diterima' ? 'selected' :'' }}> Diterima
                        </option>
                        <option value="Ditinjau" {{ $report->status_report == 'Ditinjau' ? 'selected' :'' }}> Ditinjau
                        </option>
                        <option value="Ditolak" {{ $report->status_report == 'Ditolak' ? 'selected' :'' }}> Ditolak
                        </option>
                        <option value="Disetujui" {{ $report->status_report == 'Disetujui' ? 'selected' :'' }}>Disetujui
                        </option>
                    </select>

                    <div class=" mt-3" id="causes">
                        <label for="exampleInputEmail1" class="form-label">Alasan Penolakan</label>
                        <input name="status_causes" type="text" class="form-control" value="{{$report->status_causes}}">
                    </div>
                    <input name="category_id" type="hidden" class="form-control mb-3" value="{{$report->category_id}}">
                    <input name="note" type="hidden" class="form-control mb-3" value="{{$report->note}}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="change-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('report.update',$report->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <select name="category_id" class="custom-select">
                        @foreach ($category as $category)
                        <option value={{$category->id}}>{{ $category->category}} - {{
                            $category->detail}}</option>
                        @endforeach
                    </select>
                 
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
{{-- <script type="text/javascript">
    $(document).ready(function () {
        console.log($("#target").val());
    })
</script> --}}
<script type="text/javascript">
    $(document).ready(function (e) {
        if ($("#target").val() === "Ditolak") {
        $("#causes").show();
        } else {
        $("#causes").hide();
        }
        $('#target').on('change', function () {
        if(this.value === 'Ditolak'){
            $('#causes').show();
        }else{
            $('#causes').hide();
        }
        });
    });
</script>
@endsection