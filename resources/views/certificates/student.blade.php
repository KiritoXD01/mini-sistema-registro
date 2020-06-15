<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mini Sistema Registro">
    <meta name="author" content="Javier Mercedes">
    <!-- Icons -->
    <title>Certificado</title>
    <style>
        .outer-border {
            width: 100%;
            height: 645px;
            padding: 20px;
            text-align: center;
            border: 10px solid #787878;
        }

        .inner-border {
            width: 100%;
            height: 595px;
            padding: 20px;
            text-align: center;
            border: 5px solid #787878;
        }

        .institution-name {
            font-size: 50px;
            font-weight: bold;
        }

        .certification-header {
            font-size: 30px;
        }

        .certifies-that {
            font-size: 20px;
        }

        .certification-name {
            font-size: 25px;
        }

        .certification-text {
            font-size: 20px;
        }

        .course-name {
            font-size: 25px;
        }

        .certification-points {
            font-size: 20px;
        }

        .director-signature {

        }
    </style>
</head>
<body>
<div class="outer-border">
    <div class="inner-border">
        <p class="institution-name">{{ $institution->name }}</p>
        <p class="certification-header">Certificado de Finalización</p>
        <p class="certifies-that">Esto es para certificar que</p>
        <p class="certification-name">{{ $student->fullname }}</p>
        @if($points >= 40 && $points <= 69)
            <p class="certification-text">
                ha aprobado el curso
            </p>
        @else
            <p class="certification-text">
                ha completado el curso
            </p>
        @endif
        <p class="course-name">{{ $course->studySubject->name }}</p>
        <p class="certification-points">con puntaje de<b> {{ $points }}%</b></p>
        <table class="director-signature">

        </table>
    </div>
</div>
</body>
</html>
