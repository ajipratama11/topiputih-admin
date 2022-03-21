@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi Pemilik Sistem</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Pemilik Sistem</th>
                            <th class="col-1">Jumlah Transfer</th>
                            <th class="col-1">Tanggal</th>
                            <th class="col-1">Status</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment as $payment )

                        <tr>
                            <td>{{$payment->user->name}}</td>
                            <td>@currency($payment->payment_amount)</td>
                            <td>{{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->payment_date)
                            ->format('Y-M-d H:i:s');}}</td>
                            <td>{{$payment->status}}</td>
                            <td class="text-center">
                                {{-- <form action="{{url('payment', $payment->id)}}" method="POST"> --}}

                                    <a class="btn btn-info btn-sm" href="/pembayaran-pemilik-sistem/{{$payment->id}}"><i
                                            class="fas fa-fw fa-info"></i></a></a>
                                    {{-- @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                            class="fas fa-fw fa-trash-alt"></i></button> --}}
                                    {{--
                                </form> --}}
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