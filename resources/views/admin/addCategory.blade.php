@extends('admin.admin')

@section('content')

<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Add</span> Category</h3>
                    <p>Create a new category for your products</p>
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

                    {{-- Add Category Form --}}
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3 text-start">
                            <label for="name" class="form-label fw-bold">Category Name:</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required
                                placeholder="Enter category name">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3 text-start">
                            <label for="description" class="form-label fw-bold">Description:</label>
                            <textarea name="description" id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Write a short description...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-3 text-start">
                            <label for="image" class="form-label fw-bold">Category Image:</label>
                            <input type="file" name="image" id="image"
                                   class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-folder-plus"></i> Add Category
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    .single-product-item {
        border: 1px solid #eee;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        background: #fff;
    }
    .single-product-item:hover {
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        transition: 0.3s;
    }
</style>
