<!DOCTYPE html>
<html lang="en">

    <!----- Head section ----->
    <head>
        <meta charset="UTF-8">
        <title>Service Order Management System</title>
    
        <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    </head>
    
    <!----- Body section ----->
    <body>

        <header>
            <h2>Service Order Management System</h2>
        </header>

        <!----- Navigation ----->
        <nav>
            <a href="/">Home</a>
            <a href="/clients">Clients</a>
            <a href="/employees">Employees</a>
            <a href="/serviceCategories">Service Categories</a>
            <a href="/serviceItems">Service Items</a>
            <a href="/serviceOrders">Service Orders</a>

        </nav>

        <!----- Main content ----->
        <main>
            @yield('content')
        </main>

    </body>
</html>