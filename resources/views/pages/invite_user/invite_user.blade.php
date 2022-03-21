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
                <form action="{{ route('undang-peneliti.store') }}" method="POST">
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
                                    <select name="input[0][user_id]" class="custom-select select2">
                                        <option value=""></option>
                                        @foreach ($user as $name)
                                        <option data-id={{$name->id}} value={{$name->id}}>{{$name->name}}</option>
                                        @endforeach
                                    </select>
                                    {{-- <select name="input[1][user_id]" class="custom-select select2">
                                        <option value=""></option>
                                        @foreach ($user as $name)
                                        <option data-id={{$name->id}} value={{$name->id}}>{{$name->name}}</option>
                                        @endforeach
                                    </select> --}}
                                </td>
                                <td>
                                    {{-- <a name="url_code" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#info">
                                        <i class="fas fa-fw fa-info">
                                        </i>
                                    </a> --}}
                                    {{-- <input id="myText" type="text" value="0"> --}}
                                    <a class="btn btn-secondary detail-btn" data-toggle="modal"
                                        data-target="#myModal">Detail</a>
                                    {{-- <a data-toggle="modal" id="smallButton" data-target="#smallModal"
                                        data-attr="{{ route('invite_user.show','')}}" title="show">
                                        <i class="btn btn-info">Info</i>
                                    </a> --}}
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
                                    <form action="{{url('undang-peneliti', $invited->id)}}" method="POST">
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
{{-- <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
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
</div> --}}

<div class="modal" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Peneliti Keamanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <span class="font-weight-bolder">Nama</span>
                        <p id="name"></p>
                        <span class="font-weight-bolder">Point</span>
                        <p id="point"></p>
                    </div>
                    <div class="col-lg-6">
                        <span class="font-weight-bolder">Alamat Surat Elektronik</span>
                        <p id="email"></p>
                        <span class="font-weight-bolder">Laporan Dikirim</span>
                        <p id="report"></p>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <table class="table table-striped" id="address-table" width="100%">
                            <thead id="tblHead">
                                <tr>
                                    <th>Nama Sertifikat</th>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                {{-- <button id="destroy" type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
    integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
</script>

{{-- <script>
    $('body').on('click','.detail-btn',function(event){
        event.preventDefault();

        var me=$(this),
            url = me.attr('href'),
            // title = me.attr('name');

        $.ajax({
            url:url,
            dataType: 'html',
            success:function(response){
                $('#modal-body').html(response);
            }
        })
    })
</script> --}}
<script>
    // function myFunction(e) {
    // document.getElementById("myText").value = e.target.value
    // // document.getElementById("smallButton").value = e.target.value
    // // var key = e.target.value
    // }
   
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
<script>
    $('#myModal').modal('hide');
    // function myFunction(e) {
    // // document.getElementById("myText").value = e.target.value
    
    // // console.log($(this).find(':selected').attr('data-id'))
    // // document.getElementById("smallButton").value = e.target.value
    // // var key = e.target.value
    // }
    
    $(document).ready(function() {
        
        $('select').change(function(){
           var id = $(this).find(':selected').attr('data-id'); 
           console.log(id)
        
            $('.detail-btn').click(function() {
                // var id = $(this).find(':selected').attr('data-id');
                // consol.log(id+id)
                $.ajax({
                url: '/search/'+id,
                type: 'GET',
                data: {
                    "id": id
                },
                success:function(data) {
                    console.log(data);
                    $('#name').html(data.user.name);
                    $('#email').html(data.user.email);
                    $('#point').html(data.point);
                    $('#report').html(data.report);
                    $('#myModal').modal('show');
                },
                })
                if ($.fn.dataTable.isDataTable('#address-table')) {
                    $('#address-table').DataTable().clear().destroy();               
                }
                $("#address-table").DataTable({
                    processing: true,
                    serverSide: true,
                    paging: false,
                    searching: false,
                    ordering: false,
                    info:false,
                        type : "get",
                    ajax: '{{ url("list")}}'+'/'+id,
                    columns: [
                        { data:'cert_name', name: 'cert_name'},
                        { data:'cert_date', name: 'cert_date'},
                        { data:'cert_type', name: 'cert_type'}
                    ]
                });
            });
            
      });
    });
</script>

<script>
    $(document).ready(function(){
        $('.select2').select2();
        
        // $('#myselect').change(function() { //jQuery Change Function
        // var opval = $(this).val(); //Get value from select element
        // if(opval=="secondoption"){ //Compare it and if true
        //     $('#info').modal("show"); //Open Modal
        // }
        // });
    });    
</script>


@endsection