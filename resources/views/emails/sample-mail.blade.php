@component('mail::message')
# Hai Peneliti Keamanan
<br>
<h2>Selamat,</h2>
<h3>Anda telah terpilih untuk mengikuti program:</h3>
<h1>{{$data['name']}}</h1>
<br>
<h3>Klik tombol dibawah untuk mengikuti program</h3>

<?php
    $link = $data['id'];
?>
@component('mail::button', ['url' => 'http://192.168.1.9:3000/detail-program/'.$link])
Ikuti Program
@endcomponent
<br>
Terima Kasih,<br>
{{ config('app.name') }}


@endcomponent
