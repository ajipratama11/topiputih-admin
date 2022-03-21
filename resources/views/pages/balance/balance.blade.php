@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Saldo Pemilik Sistem</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Saldo</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Pemilik Sistem</th>
                            <th class="col-1">Jumlah Saldo</th>
                            <th class="col-1">Jumlah Bayar</th>
                            <th class="col-1">Sisa Saldo</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balance as $balance )

                        <tr>
                            <td>{{$balance->name}}</td>
                            {{-- <td>{{$balance->id}}</td> --}}
                            <td>@currency($balance->get_balance($balance->id))</td>
                            <td>@currency($balance->get_payment($balance->id))</td>
                            {{-- <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                                $balance->balance_date)
                                ->format('d-M-Y H:i:s');}}</td> --}}
                            <td>@currency($balance->payment_used($balance->id))</td>
                            <td class="text-center">
                                {{-- <form action="{{url('balance', $balance->id)}}" method="POST"> --}}

                                    <a class="btn btn-info btn-sm" href="/keuangan-pemilik-sistem/{{$balance->id}}"><i
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
@endsection