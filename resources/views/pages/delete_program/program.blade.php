@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Program</h1>
    </div>

    <!-- DataTales Example -->
  
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Program Request Penghapusan</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-2">
                    <label for="">Filter Data Tipe</label>
                </div>
                <div class="col-lg-3">
                    <select id="table-filter2" class="custom-select">
                        <option value="">Semua</option>
                        <option>Bug Bounty</option>
                        <option>Vulnerability Disclosure</option>
                        <option>Penetration Testing</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
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
                        @foreach ($program_hapus as $program_hapus )

                        <tr>
                            <td>{{$program_hapus->user->nama}}</td>
                            <td>{{$program_hapus->program_name}}</td>
                            <td>{{$program_hapus->type}}</td>
                            <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d',
                                $program_hapus->date_start)
                                ->format('d-M-Y');}} </td>
                            <td>
                                {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program_hapus->date_end)
                                ->format('d-M-Y');}}
                            </td>
                            <td class="text-center">
                                <div class="col-lg-12">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <form method="POST" action="hapus-program/detail-program">
                                                @csrf
                                                <input type="hidden" id="slug" name="slug"
                                                    value="{{$program_hapus->slug}}" readonly>
                                                <button class="btn btn-info btn-sm" type="submit"><i
                                                        class="fas fa-fw fa-info"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-lg-6">
                                            <form action="{{url('program-publik', $program_hapus->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                        class="fas fa-fw fa-trash-alt"></i></button>
                                            </form>
                                        </div>
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
            "lengthMenu": [[5,10], [5,10]]
        //    dom: 'lfrtip'
        });
        
        $('#table-filter').on('change', function(){
        table.columns(2).search(this.value).draw();   
        });
    });

    $(document).ready(function (){
        var table = $('#dataTable2').DataTable({
            "order": [],
            "lengthMenu": [[5,10], [5,10]]
        });
        
        $('#table-filter2').on('change', function(){
        table.columns(2).search(this.value).draw();   
        });
    });

</script>
@endsection