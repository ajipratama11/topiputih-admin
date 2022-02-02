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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dynamicAddRemove">
                            <span class="font-weight-bolder"> Nama Pemilik Sistem </span>
                            <p class="font-weight-normal">{{ $program->user->name }}</p>
                            <span class="font-weight-bolder"> Nama Program </span>
                            <p class="font-weight-normal">{{ $program->program_name }}</p>
                            <input type="hidden" name="program_id" class="form-control" value="{{ $program->id }}" />
                            <tr>
                                <th class="col-4">Nama Peneliti Keamanan</th>
                                <th class="col-1">Detail</th>
                                <th class="col-1">Aksi</th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="input[0][user_id]" class="custom-select select2"
                                        onchange="myFunction(event)">
                                        <option value=""></option>
                                        @foreach ($user as $name)
                                        <option value={{$name->id}}>{{$name->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    {{-- <a name="url_code" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#info">
                                        <i class="fas fa-fw fa-info">
                                        </i>
                                    </a> --}}
                                    <input id="myText" type="hidden" value="0">

                                    <a data-toggle="modal" id="smallButton" data-target="#smallModal"
                                        data-attr="{{ route('invite_user.show','')}}" title="show">
                                        <i class="btn btn-info">Info</i>
                                    </a>
                                </td>
                                {{-- <td><a id="info" class="btn btn-info">Show {{$name->id}}</a> --}}
                                <td>
                                    @csrf
                                    <button type="submit" class="btn btn-success ">Simpan</button>
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
                                {{-- <td>
                                    <a id="show-user" data-id="{{$invited->user->id}}" class="btn btn-info">Show</a>

                                    <a href="" id="editCompany" data-toggle="modal" data-target='#practice_modal'
                                        data-id="{{ $invited->user->id }}">Edit {{ $invited->user->id }}</a>

                                    <a data-toggle="modal" id="smallButton" data-target="#smallModal"
                                        data-attr="{{ route('invite_user.show',$invited->user->id) }}" title="show">
                                        <i class="fas fa-eye text-success  fa-lg"></i>
                                    </a>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-label="Close" href="{{url()->previous()}}">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body" id="smallBody">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function myFunction(e) {
    document.getElementById("myText").value = e.target.value
    // document.getElementById("smallButton").value = e.target.value
    // var key = e.target.value
    }
    $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr')+'/'+ document.getElementById("myText").value;
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
</script>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    $(document).ready(function(){
        $('.select2').select2();

        $('#myselect').change(function() { //jQuery Change Function
        var opval = $(this).val(); //Get value from select element
        if(opval=="secondoption"){ //Compare it and if true
            $('#info').modal("show"); //Open Modal
        }
        });


        
    });

    
</script>


@endsection