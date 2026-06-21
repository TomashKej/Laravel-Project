<nav>
    <div class="nav-left">

        <a href="/">Home</a>

        @auth
            <a href="/clients">Clients</a>
            <a href="/employees">Employees</a>
            <a href="/positions">Positions</a>
            <a href="/serviceCategories">Service Categories</a>
            <a href="/serviceItems">Service Items</a>
            <a href="/serviceOrders">Service Orders</a>

            
            @if(Auth::user()->IsAdmin)
                <a href="/admin/users">Admin Panel</a>
            @endif
        @endauth
    </div>

    <div class="nav-right">
        @auth
            <span class="nav-user">
                Logged In User: {{ Auth::user()->name }}
            </span>

            <form method="POST" action="/logout" class="nav-form">
                @csrf
                <button type="submit" class="nav-button">Logout</button>
            </form>
        @endauth

        @guest
            <a href="/login">Login</a>
            <a href="/forgotPassword">Forgot Password</a>
        @endguest
    </div>
</nav>