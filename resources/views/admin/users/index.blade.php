@extends('main')

@section('title', 'User Administration')

@section('content')

<section class="list-page-header">
    <div class="list-page-heading">
        <span class="section-label">
            Administration
        </span>

        <h1>User Management</h1>

        <p>
            Manage user accounts, account status and administrator permissions.
        </p>
    </div>

    <div class="list-page-actions">
        <a
            href="/admin/users/create"
            class="btn btn-primary"
        >
            Add New User
        </a>
    </div>
</section>


<form
    method="GET"
    action="/admin/users"
    class="search-form"
>
    <div class="search-box search-box-simple">
        <div class="filter-field">
            <label for="user-search">
                Search users
            </label>

            <input
                id="user-search"
                type="text"
                name="search"
                placeholder="Search by name or email address..."
                value="{{ $search ?? '' }}"
            >
        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Search
        </button>

        <a
            href="/admin/users"
            class="btn btn-clear"
        >
            Clear
        </a>
    </div>
</form>


@if($models->count() > 0)
    <div class="table-container">
        <table class="data-table admin-users-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($models as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <span class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>

                                <div class="user-details">
                                    <span class="user-name">
                                        {{ $user->name }}
                                    </span>

                                    <span class="user-reference">
                                        User ID: {{ $user->id }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <a
                                href="mailto:{{ $user->email }}"
                                class="user-email"
                            >
                                {{ $user->email }}
                            </a>
                        </td>

                        <td>
                            @if($user->IsAdmin)
                                <span class="user-role user-role-admin">
                                    Administrator
                                </span>
                            @else
                                <span class="user-role user-role-standard">
                                    Standard User
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($user->IsActive)
                                <span class="user-status user-status-active">
                                    Active
                                </span>
                            @else
                                <span class="user-status user-status-inactive">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td>
                            <span class="user-created-date">
                                {{ $user->created_at }}
                            </span>
                        </td>

                        <td class="admin-table-actions">
                            <div class="actions">
                                <a
                                    href="/admin/users/edit/{{ $user->id }}"
                                    class="btn btn-outline btn-small"
                                >
                                    Edit
                                </a>


                                @if($user->IsActive)
                                    <form
                                        method="POST"
                                        action="/admin/users/deactivate/{{ $user->id }}"
                                        class="inline-form"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-small"
                                            onclick="return confirm('Are you sure you want to deactivate this user?')"
                                        >
                                            Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form
                                        method="POST"
                                        action="/admin/users/activate/{{ $user->id }}"
                                        class="inline-form"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-small"
                                        >
                                            Activate
                                        </button>
                                    </form>
                                @endif


                                @if($user->IsAdmin)
                                    <form
                                        method="POST"
                                        action="/admin/users/removeAdmin/{{ $user->id }}"
                                        class="inline-form"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-secondary btn-small"
                                            onclick="return confirm('Are you sure you want to remove the administrator role from this user?')"
                                        >
                                            Remove Admin
                                        </button>
                                    </form>
                                @else
                                    <form
                                        method="POST"
                                        action="/admin/users/makeAdmin/{{ $user->id }}"
                                        class="inline-form"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-secondary btn-small"
                                            onclick="return confirm('Are you sure you want to promote this user to administrator?')"
                                        >
                                            Make Admin
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="list-empty-state">
        <div class="list-empty-icon">
            U
        </div>

        <h2>No users found</h2>

        <p>
            No user accounts match the current search criteria.
        </p>

        <div class="page-actions">
            @if(!empty($search))
                <a
                    href="/admin/users"
                    class="btn btn-outline"
                >
                    Clear Search
                </a>
            @endif

            <a
                href="/admin/users/create"
                class="btn btn-primary"
            >
                Add New User
            </a>
        </div>
    </div>
@endif

@endsection