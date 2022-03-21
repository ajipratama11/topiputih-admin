@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="{{url()->previous()}}" class=" mb-4 text-gray-1000"><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-3">
        <h1 class="h3 mb-0 text-gray-800">Pembayaran</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-1">Nama Program</th>
                                {{-- <th class="col-1">Nama Peneliti Keamanan</th> --}}
                                <th class="col-1">Hadiah</th>
                                <th class="col-1">Tanggal</th>
                                <th class="col-1">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment as $payment )

                            <tr>
                                <td>{{$payment->program->program_name}}</td>
                                {{-- <td>{{$payment->user->name}}</td> --}}
                                <td>@currency($payment->reward)</td>
                                <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                    $payment->updated_at)
                                    ->format('d-M-Y H:i:s');}}</td>
                                <td>{{$payment->status_reward}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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