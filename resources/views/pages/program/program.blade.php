@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Program Publik</h1>
        <a href="{{ route('program-publik.create') }}" class="btn btn-primary"><i
                class="fas fa-download fa-sm text-white-50"></i> Tambah Program</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Program Publik</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-1">Nama Pemilik Sistem</th>
                            <th class="col-1">Nama Program</th>
                            <th class="col-1">Tipe Program</th>
                            <th class="col-1">Tanggal Mulai</th>
                            <th class="col-1">Tanggal Selesai</th>
                            <th class="col-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($program as $program )

                        <tr>
                            <td>{{$program->user->nama}}</td>
                            <td>{{$program->program_name}}</td>
                            <td>{{$program->type}}</td>
                            <td> {{$start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_start)
                                ->format('d-M-Y');}}</td>
                            <td>
                                {{$end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $program->date_end)
                                ->format('d-M-Y');}}
                            </td>
                            <td class="text-center">
                                <div class="col-lg-12">
                                    <div class="row">
                                        @if ($program->category =="Publik")
                                        <div class="col-lg-6">
                                            <form method="POST" action="program-publik/detail-program">
                                                @csrf
                                                <input type="hidden" id="slug" name="slug" value="{{$program->slug}}"
                                                    readonly>
                                                <button class="btn btn-info btn-sm" type="submit"><i
                                                        class="fas fa-fw fa-info"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-lg-6">
                                            <form action="{{url('program-publik', $program->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                        class="fas fa-fw fa-trash-alt"></i></button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @elseif ($program->category =="Privat")
                                <form action="{{url('program-privat', $program->id)}}" method="POST">

                                    <a class="btn btn-info btn-sm" href="/program-privat/{{$program->slug}}"><i
                                            class="fas fa-fw fa-info"></i></a></a>

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                            class="fas fa-fw fa-trash-alt"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
{{-- <script>
    var btn = document.querySelector('#tombol');
 btn.onclick = function(){
  alert('Halo, ini adalah pesan ketika anda klik tombol');
 }
    $(document).ready(function () 
	{	
        // let slug = document.querySelector('#slug');
        // var idnya = 'vulnerable-disclosure-bpd-bali-jawa-timur'
        // document.cookie = "username="+slug;
    });
    function send()
	{		
        

		let slug = document.querySelector('#slug');
		// localStorage.setItem('slug',slugs.value);
        // var slugs =localStorage.getItem('slug');
        // setCookie('cookieName', slug, 7);
        // var idnya = 'vulnerable-disclosure-bpd-bali-jawa-timur'
        document.cookie = "username="+slug;
        var idnya = 'vulnerable-disclosure-bpd-bali-jawa-timur'
        document.cookie = "isi="+idnya;
        // document.cookie = "username=John Doe";
	};
</script> --}}
@endsection