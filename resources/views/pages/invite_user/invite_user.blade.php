@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Program</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Undang Peneliti Keamanan ke Program Privat</h6>
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{ route('invite_user.store') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dynamicAddRemove">
                            <span class="font-weight-bolder"> Nama Pemilik Sistem </span>
                            <p class="font-weight-normal">{{ $program->user->name }}</p>
                            <span class="font-weight-bolder"> Nama Program </span>
                            <p class="font-weight-normal">{{ $program->program_name }}</p>
                            <input type="hidden" name="program_id" class="form-control" value="{{ $program->id }}" />
                            <tr>
                                <th class="col-5">Nama Peneliti Keamanan</th>
                                <th class="col-2">Action</th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="input[0][user_id]" class="custom-select select2" >
                                        {{-- <select name="user_id[]" class="custom-select select2" multiple='multiple' > --}}
                                        @foreach ($user as $name)
                                        <option value={{$name->id}}>{{$name->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success btn-block">Simpan</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <div class="table-responsive mt-5">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-5">Nama Peneliti Keamanan</th>
                                <th class="col-4">Tanggal Undangan</th>
                                <th class="col-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $invited )
                            <tr>
                                <td>{{$invited->user->name}}</td>
                                <td>{{$invited->created_at}}</td>
                                <td class="text-center">
                                    <form action="{{url('invite_user', $invited->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                class="fas fa-fw fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        // $("#dynamicAddRemove").append('<tr><td><input type="text" name="input[' + i +'][cert_name]" placeholder="Enter subject" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
        //     );
        $("#dynamicAddRemove").append('<tr><td><select name="input[' + i +'][user_id]" class="custom-select select2" >@foreach ($user as $name)<option value={{$name->id}}>{{$name->name}}</option>@endforeach</select></td><td><button type="button" class="btn btn-outline-primary remove-input-field">Hapus</button></td></tr>'
        );
      
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
    });
</script>
@endsection