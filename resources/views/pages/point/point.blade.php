@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Point Peneliti Keamanan</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Point</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Peneliti Keamanan</th>
                            <th class="col-1">Jumlah Point</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($point as $point )

                        <tr>
                            <td>{{$point->user->name}}</td>
                            <td>{{$point->points}}</td>

                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="/program_private/{{$point->id}}"><i
                                        class="fas fa-fw fa-info"></i></a></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('table.display').DataTable({
            "order": []
        });
    });
</script>
@endsection