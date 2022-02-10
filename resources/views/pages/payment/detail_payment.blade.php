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
            <h6 class="m-0 font-weight-bold text-primary">Detail Data Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5">
                            <span class="font-weight-bolder"> Nama Pemilik Sistem </span>
                            <p class="font-weight-normal">{{ $payment->user->name }}</p>
                            <span class="font-weight-bolder"> Nama Rekening </span>
                            <p class="font-weight-normal">{{ $payment->account_name }}</p>
                            <span class="font-weight-bolder"> Status Progam </span>
                            <p class="font-weight-normal">@currency( $payment->payment_amount )</p>
                            <span class="font-weight-bolder"> Status Progam </span>
                            <p class="font-weight-normal">{{ $payment->status }}</p>
                        </div>
                        <div class="col-lg-5">
                            <span class="font-weight-bolder"> Nama Bank </span>
                            <p class="font-weight-normal">{{ $payment->bank_name }}</p>
                            <span class="font-weight-bolder"> No Rekening </span>
                            <p class="font-weight-normal">{{ $payment->account_number }}</p>
                            <span class="font-weight-bolder">Tanggal Pembayaran </span>
                            <p class="font-weight-normal">
                                {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->payment_date)
                                ->format('d-M-Y');}}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">
                    <span class="font-weight-bolder">Bukti Transfer </span>
                    <div class=" mt-2">
                        <img class="img-fluid align-middle" style="max-height: 300px"
                            src="{{'/img/payment/'}}{{$payment->image_transfer}}">
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <a data-toggle="modal" data-target="#change-status" class="btn btn-primary mr-3"><i
                            class="fas fa-fw fa-edit"></i> Konfirmasi Pembayaran</a>
                    <a data-toggle="modal" data-target="#change-status" class="btn btn-primary"><i
                            class="fas fa-fw fa-edit"></i> Ubah Status</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection