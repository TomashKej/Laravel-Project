<nav class="site-navbar">
    <div class="navbar-content">

        <div class="nav-left">

            <!-- Home link -->
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>

            @auth
                <!-- Clients link -->
                <a href="/clients" class="nav-link {{ request()->is('clients*') ? 'active' : '' }}">Clients</a>

                <!-- Employees link -->
                <a href="/employees" class="nav-link {{ request()->is('employees*') ? 'active' : '' }}">Employees</a>

                <!-- Positions link -->
                <a href="/positions" class="nav-link {{ request()->is('positions*') ? 'active' : '' }}">Positions</a>

                <!-- Service categories link -->
                <a href="/serviceCategories" class="nav-link {{ request()->is('serviceCategories*') ? 'active' : '' }}">Service Categories</a>

                <!-- Service items link -->
                <a href="/serviceItems" class="nav-link {{ request()->is('serviceItems*') ? 'active' : '' }}">Service Items</a>

                <!-- Service orders link -->
                <a href="/serviceOrders" class="nav-link {{ request()->is('serviceOrders*') ? 'active' : '' }}">Service Orders</a>

                @if(Auth::user()->IsAdmin)
                    <!-- Admin panel link -->
                    <a href="/admin/users" class="nav-link nav-admin-link {{ request()->is('admin/users*') ? 'active' : '' }}">Admin Panel</a>
                @endif
            @endauth

        </div>

        <div class="nav-right">

            @auth
                <!-- Authenticated user information -->
                <div class="nav-user">
                    <span class="nav-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>

                    <span class="nav-user-details">
                        <small>Signed in as</small>
                        <strong>{{ Auth::user()->name }}</strong>
                    </span>
                </div>

                <!-- Logout form -->
                <form method="POST" action="/logout" class="nav-form">
                    @csrf
                    <button type="submit" class="nav-button">Logout</button>
                </form>
            @endauth

            @guest
                <!-- Login link -->
                <a href="/login" class="nav-link {{ request()->is('login') ? 'active' : '' }}">Login</a>

                <!-- Password recovery link -->
                <a href="/forgotPassword" class="nav-link {{ request()->is('forgotPassword*') ? 'active' : '' }}">Forgot Password</a>
            @endguest

        </div>

    </div>
</nav>
