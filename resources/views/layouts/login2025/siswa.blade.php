<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="{{ asset('asset2025/css/style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        @if ($errors->any())
            <center><small class="text-danger">{{ $errors->first() }}</small></center>
        @endif
        <form action="{{ route('auth.siswa') }}" method="post">
            @csrf
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="nis" id="nis" name="nis" value="{{ old('nis') }}">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password">
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button type="submit" class="btn">Login</button>

        </form>
    </div>

</body>

</html>
