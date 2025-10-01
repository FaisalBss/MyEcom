@extends('admin.admin')

@section('content')
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="section-title text-center">
                    <h3><span class="orange-text">Products</span></h3>
                    <p>Each product has excellent quality</p>
                </div>

                {{-- Search Form --}}
                <form action="{{ route('products.admin.index') }}" method="GET" class="d-flex mb-3">
                    <input type="text" name="search" class="form-control me-2"
                           placeholder="Search by ID, Name, or Category"
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                {{-- Products Table --}}
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" width="80" alt="{{ $product->name }}">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->price }} $</td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline"
                                          onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                                <td colspan="7" class="text-center text-muted">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
