<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mini Sistema Registro">
    <meta name="author" content="Javier Mercedes">
    <title>@yield('title', env('APP_NAME'))</title>
</head>
<body>
<div style="width:100%; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
    <div style="width:100%; height:550px; padding:20px; text-align:center; border: 5px solid #787878">
        <span style="font-size:50px; font-weight:bold">Certificado de finalización</span>
        <br><br>
        <span style="font-size:25px">
            <i>Esto es para certificar que</i>
        </span>
        <br><br>
        <span style="font-size:30px"><b>{{ $student->full_name }}</b></span><br/><br/>
        @if($points >= 40 && $points <= 69)
            <span style="font-size:25px"><i>ha aprobado el curso</i></span> <br/><br/>
        @else
            <span style="font-size:25px"><i>ha completado el curso</i></span> <br/><br/>
        @endif
        <span style="font-size:30px">{{ $course->studySubject->name }}</span> <br/><br/>
        <span style="font-size:20px">con puntaje de<b> {{ $points }}%</b></span> <br/><br/><br/><br/>
        <span style="font-size:25px"><i>Fechada</i></span><br>
        <span style="font-size:30px">{{ \Carbon\Carbon::now()->format('d/m/yy') }}</span>
    </div>
</div>
</body>
</html>
