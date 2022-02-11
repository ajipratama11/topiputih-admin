@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembayaran Per-Program</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Pemilik Sistem</th>
                            <th class="col-1">Nama Program</th>
                            <th class="col-1">Nama Peneliti Keamanan</th>
                            <th class="col-1">Jumlah Hadiah</th>
                            <th class="col-1">Status</th>
                            <th class="col-1">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment as $payment )

                        <tr>
                            <td>{{$payment->name}}</td>
                            <td>{{$payment->program_name}}</td>
                            
                            <td>{{$payment->user->name}}</td>
                            {{-- <td>{{$payment->reward}}</td> --}}
                            <td>@currency($payment->reward)</td>
                            <td>{{$payment->status_reward}}</td>
                            <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->updated_at)
                                ->format('d-M-Y H:i:s');}}</td>
                            {{-- <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="/payment/{{$payment->id}}"><i
                                            class="fas fa-fw fa-info"></i></a></a>
                              
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection