<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ URL::asset('img/logo-kotak.png') }}">
    <title>Verifikasi Email</title>
    <style>
        .alert {
            display: flex;
            flex-direction: column;
            background-color: #f0fdf4;
            border: 1px solid #4ade80;
            color: #065f46;
            padding: 1rem;
            border-radius: 0.375rem;
        }

        .alert .font-bold {
            font-weight: bold;
        }

        .alert span {
            display: block;
        }

        @media (min-width: 640px) {
            .alert span {
                display: inline;
            }
        }
    </style>
</head>

<body>

    <div class="alert" role="alert">
        <strong class="font-bold">Hallo {{ $hasil->email }}, Email Anda Sudah Terverifikasi !</strong>
        <span>Anda bisa login menggunakan akun yang sudah anda daftarkan sebelumnya.</span>
    </div>
</body>

</html>
