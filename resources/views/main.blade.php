<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Service Order Management System</title>

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>

<body class="@yield('bodyClass')">

<x-header/>
<x-navbar/>


<main>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<x-footer/>

</body>
</html>