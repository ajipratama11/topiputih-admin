<!DOCTYPE html>
<html>

<head>
    <title>Email From Topiputih.id</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="row justify-content-center">
        <div class="text-center">
            <img class="img-fluid" src="{{asset('img/topiputih.png')}}" alt="">
        </div>
        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="row justify-content-center">
                    <div class="card-body">
                        <span class="fw-bolder"> Anda Telah Diundang ke Program Privat Kami </span>

                        <h1>{{ $data['name']}}</h1>
                        <p>Klik Tombol dibawah ini untuk detail program</p>

                        <a href="http://192.168.1.9:3000/detail-program/{{$data['id']}}">TOMBOL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
