@extends('admin.admin')

@section('content')

<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Edit</span> Category</h3>
                    <p>Update category details below</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="single-product-item p-4">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Edit Form --}}
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Category Name</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $category->name) }}"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Current Image</label><br>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" width="120">
                            @else
                                <p class="text-muted">No Image</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Upload New Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection
