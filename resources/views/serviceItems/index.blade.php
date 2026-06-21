@extends('main')

@section('title', 'Service Items')

@section('content')

<section class="list-page-header">
    <div class="list-page-heading">
        <span class="section-label">
            Service Management
        </span>

        <h1>Service Items</h1>

        <p>
            Manage the services offered by the business, their categories,
            descriptions and current prices.
        </p>
    </div>

    <div class="list-page-actions">
        <a
            href="/serviceItems/create"
            class="btn btn-primary"
        >
            Add New Service Item
        </a>
    </div>
</section>


<form
    method="GET"
    action="/serviceItems"
    class="search-form"
>
    <div class="search-box search-box-simple">
        <div class="filter-field">
            <label for="service-item-search">
                Search service items
            </label>

            <input
                id="service-item-search"
                type="text"
                name="search"
                placeholder="Search by title, category or description..."
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
            href="/serviceItems"
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
                    <th>Service Item</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($models as $serviceItem)
                    <tr>
                        <td>
                            <div class="service-item-cell">
                                <span class="service-item-icon">
                                    {{ strtoupper(substr($serviceItem->Title, 0, 1)) }}
                                </span>

                                <div class="service-item-details">
                                    <span class="record-title">
                                        {{ $serviceItem->Title }}
                                    </span>

                                    <span class="service-item-reference">
                                        Service ID: {{ $serviceItem->Id }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($serviceItem->serviceCategory)
                                <span class="service-category-badge">
                                    {{ $serviceItem->serviceCategory->Title }}
                                </span>
                            @else
                                <span class="table-value-empty">
                                    No category
                                </span>
                            @endif
                        </td>

                        <td>
                            <span class="service-price">
                                £{{ number_format($serviceItem->Price, 2) }}
                            </span>
                        </td>

                        <td>
                            <span class="service-description">
                                {{ $serviceItem->Description }}
                            </span>
                        </td>

                        <td class="table-actions">
                            <div class="actions">
                                <a
                                    href="/serviceItems/details/{{ $serviceItem->Id }}"
                                    class="btn btn-primary btn-small"
                                >
                                    Details
                                </a>

                                <a
                                    href="/serviceItems/edit/{{ $serviceItem->Id }}"
                                    class="btn btn-outline btn-small"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="/serviceItems/delete/{{ $serviceItem->Id }}"
                                    class="inline-form"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Are you sure you want to deactivate this service item?')"
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
            S
        </div>

        <h2>No service items found</h2>

        <p>
            No service items match the current search criteria.
        </p>

        <div class="page-actions">
            @if(!empty($search))
                <a
                    href="/serviceItems"
                    class="btn btn-outline"
                >
                    Clear Search
                </a>
            @endif

            <a
                href="/serviceItems/create"
                class="btn btn-primary"
            >
                Add New Service Item
            </a>
        </div>
    </div>
@endif

@endsection