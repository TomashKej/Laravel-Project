@extends('main')

@section('title', 'Service Categories')

@section('content')

<section class="list-page-header">
    <div class="list-page-heading">
        <span class="section-label">
            Service Management
        </span>

        <h1>Service Categories</h1>

        <p>
            Manage the categories used to organise services available
            within the business.
        </p>
    </div>

    <div class="list-page-actions">
        <a
            href="/serviceCategories/create"
            class="btn btn-primary"
        >
            Add New Category
        </a>
    </div>
</section>


<form
    method="GET"
    action="/serviceCategories"
    class="search-form"
>
    <div class="search-box search-box-simple">
        <div class="filter-field">
            <label for="category-search">
                Search categories
            </label>

            <input
                id="category-search"
                type="text"
                name="search"
                placeholder="Search by title or description..."
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
            href="/serviceCategories"
            class="btn btn-clear"
        >
            Clear
        </a>
    </div>
</form>


@if($models->count() > 0)
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($models as $category)
                    <tr>
                        <td>
                            <div class="category-cell">
                                <span class="category-icon">
                                    {{ strtoupper(substr($category->Title, 0, 1)) }}
                                </span>

                                <div class="category-details">
                                    <span class="record-title">
                                        {{ $category->Title }}
                                    </span>

                                    <span class="category-reference">
                                        Category ID: {{ $category->Id }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="category-description">
                                {{ $category->Description }}
                            </span>
                        </td>

                        <td class="table-actions">
                            <div class="actions">
                                <a
                                    href="/serviceCategories/details/{{ $category->Id }}"
                                    class="btn btn-primary btn-small"
                                >
                                    Details
                                </a>

                                <a
                                    href="/serviceCategories/edit/{{ $category->Id }}"
                                    class="btn btn-outline btn-small"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="/serviceCategories/delete/{{ $category->Id }}"
                                    class="inline-form"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Are you sure you want to deactivate this category?')"
                                    >
                                        Delete
                                    </button>
                                </form>
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
            C
        </div>

        <h2>No service categories found</h2>

        <p>
            No categories match the current search criteria.
        </p>

        <div class="page-actions">
            @if(!empty($search))
                <a
                    href="/serviceCategories"
                    class="btn btn-outline"
                >
                    Clear Search
                </a>
            @endif

            <a
                href="/serviceCategories/create"
                class="btn btn-primary"
            >
                Add New Category
            </a>
        </div>
    </div>
@endif

@endsection