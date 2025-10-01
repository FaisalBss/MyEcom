@extends('admin.admin')

@section('content')

<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">All</span> Categories</h3>
                    <p>Manage all categories below</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="80">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No categories found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($categories->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $categories->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
