@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="/payment" class=" mb-4 text-gray-1000"><i class="fas fa-fw fa-arrow-left"></i>Kembali</a>
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
                            <span class="font-weight-bolder"> Nominal </span>
                            <p class="font-weight-normal">@currency( $payment->payment_amount )</p>
                            <span class="font-weight-bolder"> Status </span>
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
                                ->format('d-M-Y H:i:s');}}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12 mt-3">
                    <a data-toggle="modal" data-target="#image" class="btn btn-primary"><i
                            class="fas fa-fw fa-edit"></i> Lihat Bukti Transfer</a>
                    @if ($payment->status !="Diterima")
                    <a data-toggle="modal" data-target="#change-status" class="btn btn-primary ml-3"><i
                            class="fas fa-fw fa-edit"></i> Konfirmasi Pembayaran</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bukti Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class=" mt-2">
                        <img class="img-fluid align-middle" style="max-height: 300px"
                            src="{{'/img/payment/'}}{{$payment->image_transfer}}">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="change-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('payment.update',$payment->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="modal-body">
                    <span class="font-weight-bolder">Nominal </span>
                    <input name="payment_amount" type="text" class="form-control mb-3"
                        value="{{$payment->payment_amount}}">
                    <span class="font-weight-bolder">Status</span>
                    <select name="status" class="custom-select" id="target">
                        <option value="Diterima" {{ $payment->status == 'Diterima' ? 'selected' :'' }}> Diterima
                        </option>
                        <option value="Ditolak" {{ $payment->status == 'Ditolak' ? 'selected' :'' }}> Ditolak
                        </option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection