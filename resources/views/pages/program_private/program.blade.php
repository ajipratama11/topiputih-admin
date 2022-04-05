@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Program Privat</h1>
        <a href="{{ route('program-privat.create') }}" class="btn btn-primary"><i
                class="fas fa-download fa-sm text-white-50"></i> Tambah Program Privat</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Program Privat</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-2">
                    <label for="">Filter Data Tipe</label>
                </div>
                <div class="col-lg-3">
                    <select id="table-filter" class="custom-select">
                        <option value="">Semua</option>
                        <option>Bug Bounty</option>
                        <option>Vulnerability Disclosure</option>
                        <option>Penetration Testing</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Pemilik Sistem</th>
                            <th class="col-1">Nama Program</th>
                            <th class="col-1">Tipe Program</th>
                            <th class="col-1">Tanggal Mulai</th>
                            <th class="col-1">Tanggal Selesai</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($program as $program )

                        <tr>
                            <td>{{$program->user->nama}}</td>
                            <td>{{$program->program_name}}</td>
                            <td>{{$program->type}}</td>
                            <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_start)
                                ->format('d-M-Y');}} </td>
                            <td>
                                {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_end)
                                ->format('d-M-Y');}}
                            </td>
                            <td class="text-center">
                                <div class="col-lg-12">
                                    <div class="row">
                                        @if ($program->category =="Publik")
                                        <div class="col-lg-6">
                                            <form method="POST" action="program-publik/detail-program">
                                                @csrf
                                                <input type="hidden" id="slug" name="slug" value="{{$program->slug}}"
                                                    readonly>
                                                <button class="btn btn-info btn-sm" type="submit"><i
                                                        class="fas fa-fw fa-info"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-lg-6">
                                            <form action="{{url('program-publik', $program->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                        class="fas fa-fw fa-trash-alt"></i></button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @elseif ($program->category =="Privat")
                                <div class="col-lg-6">
                                    <form method="POST" action="program-privat/detail-program">
                                        @csrf
                                        <input type="hidden" id="slug" name="slug" value="{{$program->slug}}" readonly>
                                        <button class="btn btn-info btn-sm" type="submit"><i
                                                class="fas fa-fw fa-info"></i></button>
                                    </form>
                                </div>
                                <div class="col-lg-6">
                                    <form action="{{url('program-privat', $program->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                class="fas fa-fw fa-trash-alt"></i></button>

                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('table.display').DataTable({
    //         "order": []
    //     });
    // });

    $(document).ready(function (){
    var table = $('#dataTable').DataTable({
        "order": [],
    //    dom: 'lfrtip'
    });
    
    $('#table-filter').on('change', function(){
       table.columns(2).search(this.value).draw();   
    });

});
</script>
@endsection