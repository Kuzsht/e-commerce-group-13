@extends('layouts.app')

@section('title', 'Manage Categories - KICKSup')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="color: var(--dark-blue);">Manage Categories</h1>
        <a href="{{ route('seller.categories.create') }}" class="btn btn-primary">+ Add Category</a>
    </div>

    <div class="card">
        @if($categories->isEmpty())
            <p style="text-align: center; color: #666; padding: 2rem;">No categories yet</p>
        @else
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th>Products</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                            <td>{{ $category->products_count ?? 0 }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('seller.categories.edit', $category->id) }}" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem;">Edit</a>
                                    <form action="{{ route('seller.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem; background: var(--red); color: white; border: none;" onclick="return confirm('Delete category?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem;">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection