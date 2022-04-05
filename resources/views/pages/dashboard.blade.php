@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="pemilik-sistem">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Banyak Pemilik Sistem</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_company}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-building fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="peneliti-keamanan">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Banyak Peneliti
                                    Keamanan
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$count_researcher}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="program-publik">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Banyak Program</div>
                                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{$enc}}</div>
                                <br> --}}
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_program}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-code fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Earnings (Monthly) Card Example -->

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="laporan">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Laporan Diterima</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_report}}</div>
                                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dec}}</div> --}}
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="pembayaran-belum-disetujui">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pembayaran Pemilik Sistem Belum Disetujui</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_payment_waiting}}</div>
                                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dec}}</div> --}}
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="hadiah-belum-dibayarkan" class="">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Hadiah Peneliti Keamanan Belum Dibayarkan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_reward_waiting}}</div>
                                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dec}}</div> --}}
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="program-berjalan">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Program Berjalan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_program_active}}
                                </div>
                                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dec}}</div> --}}
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-laptop-code fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="laporan-menunggu">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Laporan Belum Disetujui</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_report_waiting}}</div>
                                {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dec}}</div> --}}
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>



        <!-- Pending Requests Card Example -->
        {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">SUDAH ENKRIP : {{$enc}}</div> --}}


        {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">HASIL DEKRIP : {{$dec}}</div> --}}
    </div>
</div>
@endsection