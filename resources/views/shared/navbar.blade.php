<nav>
    <div class="nav-left">

        @auth
            <a href="/">Home</a>
            <a href="/clients">Clients</a>
            <a href="/employees">Employees</a>
            <a href="/serviceCategories">Service Categories</a>
            <a href="/serviceItems">Service Items</a>
            <a href="/serviceOrders">Service Orders</a>
        @endauth
    </div>

    <div class="nav-right">
        @auth
            <span class="nav-user">
                {{ Auth::user()->name }}
            </span>

            <form method="POST" action="/logout" class="nav-form">
                @csrf
                <button type="submit" class="nav-button">Logout</button>
            </form>
        @endauth

        @guest
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        @endguest
    </div>
</nav>