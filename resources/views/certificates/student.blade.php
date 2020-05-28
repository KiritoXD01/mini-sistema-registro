<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mini Sistema Registro">
    <meta name="author" content="Javier Mercedes">
    <title>@yield('title', env('APP_NAME'))</title>
</head>
<body>
<div style="width:800px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
    <div style="width:750px; height:550px; padding:20px; text-align:center; border: 5px solid #787878">
        <span style="font-size:50px; font-weight:bold">Certificado de finalización</span>
        <br><br>
        <span style="font-size:25px">
            <i>Esto es para certificar que</i>
        </span>
        <br><br>
        <span style="font-size:30px"><b>$student.getFullName()</b></span><br/><br/>
        <span style="font-size:25px"><i>ha completado el curso</i></span> <br/><br/>
        <span style="font-size:30px">$course.getName()</span> <br/><br/>
        <span style="font-size:20px">con puntaje de<b>$grade.getPoints()%</b></span> <br/><br/><br/><br/>
        <span style="font-size:25px"><i>Fechada</i></span><br>
        <span style="font-size:30px">$dt</span>
    </div>
</div>
</body>
</html>
