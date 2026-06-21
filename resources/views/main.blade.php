<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> @yield('title', 'Service Order Management System')</title>

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>

<body class="@yield('bodyClass')">

    <x-header/>
    <x-navbar/>
    
    <main class="site-main">
        @if(session('success'))
                <div class="alert alert-success">
                    <span class="alert-icon">✓</span>
    
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
    
        @if(session('error'))
                <div class="alert alert-error">
                    <span class="alert-icon">!</span>
    
                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
    
        @yield('content')
    </main>
    
    <x-footer/>

</body>
</html>