@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hadiah Peneliti Keamanan</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Hadiah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Peneliti Keamanan</th>
                            <th class="col-1">Hadiah Diproses</th>
                            <th class="col-1">Sisa Hadiah</th>
                            <th class="col-1">Hadiah Ditarik</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balance as $balance )

                        <tr>
                            <td>{{$balance->name}}</td>
                            {{-- <td>{{$balance->id}}</td> --}}
                            <td>@currency($balance->get_reward_process($balance->id))</td>
                            <td>@currency($balance->get_reward($balance->id))</td>
                            <td>@currency($balance->get_reward_done($balance->id))</td>
                            {{-- <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $balance->balance_date)
                                ->format('d-M-Y H:i:s');}}</td> --}}
                            
                            <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="/payment_researcher/{{$balance->id}}"><i
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
@endsection