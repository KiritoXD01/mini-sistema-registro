<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <style>
        table {
            border: 5px solid black;
            padding: 20px;
            width: 100%;
        }

        .logo {
            width: 150px;
            height: 150px;
        }

        .qrcode {
            width: 170px;
            height: 170px;
            float: right;
        }

        .institution-name {
            text-align: center;
            font-size: 40px;
            overflow-wrap: break-word;
        }

        .diploma {
            text-align: center;
            font-size: 35px;
            padding: 20px;
        }

        .nombre {
            text-align: center;
            font-size: 40px;
            padding: 20px;
        }

        .texto {
            text-align: justify;
            font-size: 18px;
            padding: 25px;
        }

        .firmas {
            width: 128px;
            height: 128px;
            padding: 0;
        }
    </style>
</head>
<body>
<table>
    <tbody>
    <tr>
        <td>
            <img class="logo" src="{{ asset($institution->logo) }}">
        </td>
        <td class="institution-name">
            {{ $institution->name }}
        </td>
        <td>
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(512)->generate(route('course.checkCertification', [$course->id, $student->code]))) !!}" class="qrcode" alt="" />
        </td>
    </tr>
    <tr>
        <td colspan="3" class="diploma">
            <b>DIPLOMA</b>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="nombre">
            <b>{{ $student->full_name }}</b>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="texto">
            Por haber
            <b>
                @if($student->points >= 40 && $student->points <= 69)
                    asistido
                @else
                    aprobado
                @endif
            </b>
            satisfactoriamente <b>{{ $course->studySubject->name }}</b> en <b>{{ $institution->name }}</b>.
            Esta formación contó con una carga académica de <b>{{ $course->hour_count }}</b> horas interactivas,
            impartida en la modalidad <b>{{ $course->course_modality['value'] }}</b>. Dado en
            <b>
                @if ($course->city_id > 0 && !empty($course->city_id))
                    {{ $course->city->name }}, {{ $course->country->name }}
                @else
                    {{ $course->country->name }}
                @endif
            </b>, el día <b>{{ $course->end_date_formatted->format("l j F Y") }}</b>.
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding: 15px;">
            <img class="firmas" src="{{ asset($institution->rector_signature) }}">
            <hr>
            <b>Rector</b>
        </td>
        <td style="text-align: center; padding: 15px;">
            <img class="firmas" src="{{ $teacher->digital_signature }}">
            <hr>
            <b>Profesor</b>
        </td>
        <td style="text-align: center; padding: 15px;">
            <img class="firmas" src="{{ $institution->director_signature }}">
            <hr>
            <b>Director Academico</b>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
