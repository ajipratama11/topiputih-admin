@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hadiah Program Belum Dibayarkan</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Pemilik Sistem</th>
                            <th class="col-1">Nama Program</th>
                            <th class="col-1">Nama Peneliti Keamanan</th>
                            <th class="col-1">Jumlah Hadiah</th>
                            {{-- <th class="col-1">Status Pembayaran</th> --}}
                            {{-- <th class="col-1">Tanggal</th> --}}
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment as $payment )

                        <tr>
                            <td>{{$payment->nama}}</td>
                            <td>{{$payment->program_name}}</td>

                            <td>{{$payment->user->nama}}</td>
                            {{-- <td>{{$payment->reward}}</td> --}}
                            <td>@currency($payment->reward)</td>
                            {{-- <td>{{$payment->status_reward}}</td> --}}
                            {{-- <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->updated_at)
                                ->format('Y-M-d H:i:s');}}</td> --}}
                            <td class="text-center">
                                <form method="POST" action="{{route('pembayaran-peneliti-keamanan.store')}}">
                                    @csrf
                                    <input type="hidden" id="slug" name="slug" value="{{$payment->rid}}" readonly>
                                    <button class="btn btn-info btn-sm" type="submit"><i
                                            class="fas fa-fw fa-info"></i></button>
                                </form>
                                {{-- <a class="btn btn-info btn-sm" href="/pembayaran-peneliti-keamanan/{{$payment->rid}}"><i
                                        class="fas fa-fw fa-info"></i></a></a> --}}

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