@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Program</h1>
        {{-- <a href="{{ route('report.create') }}" class="btn btn-primary"><i
                class="fas fa-download fa-sm text-white-50"></i> Tambah Perusahaan</a> --}}
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Peneliti Keamanan</th>
                            <th class="col-1">Nama Program</th>
                            <th class="col-1">Kategori</th>
                            <th class="col-1">Status Laporan</th>
                            <th class="col-1">Tanggal Laporan</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                        <tr>
                            <td>{{$report->user->nama}}</td>
                            <td>{{$report->program->program_name}}</td>
                            <td>{{$report->categoryReport->category}} - {{$report->categoryReport->detail}}</td>
                            <td>{{$report->status_report}}</td>
                            <td>{{$date = \Carbon\Carbon::createFromFormat('Y-m-d', $report->date)->format('Y-M-d');}}
                            </td>
                            <td class="text-center">
                                <form action="{{url('report', $report->id)}}" method="POST">
                                    <a class="btn btn-info btn-sm" href="/laporan/{{$report->slug}}"><i
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('table.display').DataTable({
            "order": []
        });
    });
</script>
@endsection