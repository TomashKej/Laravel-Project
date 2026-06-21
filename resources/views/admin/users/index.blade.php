@extends('main')

@section('content')

<h1>Admin Panel - Users</h1>

<div class="page-actions">
    <a href="/admin/users/create" class="btn btn-primary">Add New User</a>
</div>

<form method="GET" action="/admin/users" class="search-form">
    <div class="search-box">
        <input type="text" name="search" placeholder="Search users..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/admin/users" class="btn btn-clear">Clear</a>
    </div>
</form>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Active</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($models as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>
                    @if($user->IsAdmin)
                        <span class="badge">Admin</span>
                    @else
                        <span class="badge">User</span>
                    @endif
                </td>

                <td>
                    @if($user->IsActive)
                        <span class="badge">Active</span>
                    @else
                        <span class="badge">Inactive</span>
                    @endif
                </td>

                <td>{{ $user->created_at }}</td>

                <td>
                    <div class="actions">
                        <a href="/admin/users/edit/{{ $user->id }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>

                        @if($user->IsActive)
                            <form method="POST" action="/admin/users/deactivate/{{ $user->id }}" class="inline-form">
                                @csrf

                                <button type="submit"
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Are you sure you want to deactivate this user?')">
                                    Deactivate
                                </button>
                            </form>
                        @else
                            <form method="POST" action="/admin/users/activate/{{ $user->id }}" class="inline-form">
                                @csrf

                                <button type="submit" class="btn btn-primary btn-small">
                                    Activate
                                </button>
                            </form>
                        @endif

                        @if($user->IsAdmin)
                            <form method="POST" action="/admin/users/removeAdmin/{{ $user->id }}" class="inline-form">
                                @csrf

                                <button type="submit"
                                        class="btn btn-secondary btn-small"
                                        onclick="return confirm('Are you sure you want to remove admin role from this user?')">
                                    Remove Admin
                                </button>
                            </form>
                        @else
                            <form method="POST" action="/admin/users/makeAdmin/{{ $user->id }}" class="inline-form">
                                @csrf

                                <button type="submit"
                                        class="btn btn-primary btn-small"
                                        onclick="return confirm('Are you sure you want to promote this user to admin?')">
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

@if($models->count() == 0)
    <p>No users found.</p>
@endif

@endsection