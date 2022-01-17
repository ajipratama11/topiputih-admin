@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Program Publik</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Program</h6>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" id="upload-image"
                action="{{ route('program_private.store') }}">
                <div class="row">
                    @csrf
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Program</label>
                            <input name="program_name" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input name="date_start" type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tipe Program</label>
                            <select name="type" class="custom-select" id="inputGroupSelect01">
                                <option selected>Pilih</option>
                                <option value="Bug Bounty">Bug Bounty</option>
                                <option value="Vulnerability Disclosure">Vulnerability Disclosure</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Perusahaan</label>
                            <input name="company_name" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label name="date_end" class="form-label">Tanggal Selesai</label>
                            <input name="date_end" type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <select name="status" class="custom-select">
                                <option selected>Pilih</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Hadiah Tingkat 1</label>
                            <input name="price_1" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Hadiah Tingkat 2</label>
                            <input name="price_2" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Hadiah Tingkat 3</label>
                            <input name="price_3" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Hadiah Tingkat 4</label>
                            <input name="price_4" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Hadiah Tingkat 5</label>
                            <input name="price_5" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <input name="user_id" type="hidden" class="form-control" value="12">
                        <input name="category" type="hidden" class="form-control" value="Privat">

                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="file" class="btn btn-secondary" name="program_image"
                                    placeholder="Choose image" id="image">
                                @error('image')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <img id="preview-image-before-upload" alt="preview image" style="max-height: 250px;"
                                src="{{'/img/program_image/'}}topiputih.png">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi</label>
                            <textarea name="description" class="ckeditor form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Cakupan</label>
                            <textarea name="scope" class="ckeditor form-control"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection