@extends('admin.admin')

@section('content')

<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Edit</span> Product</h3>
                    <p>Update product details below.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="form-title">
                    <h2>Product Information</h2>
                    <p>Modify the fields and click update.</p>
                </div>

                <div id="form_status"></div>

                <div class="contact-form">
                    <form method="POST" enctype="multipart/form-data"
                          action="{{ route('products.update', $product->id) }}"
                          style="text-align: left;">
                        @csrf
                        @method('PUT')

                        <p>
                            <input type="text" style="width: 100%"
                                   placeholder="Name" name="name" id="name"
                                   value="{{ old('name', $product->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </p>

                        <p style="display: flex; justify-content: space-between;">
                            <input type="number" step="0.1" style="width:49%"
                                   placeholder="Price" name="price" id="price"
                                   value="{{ old('price', $product->price) }}">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="number" style="width:49%"
                                   placeholder="Quantity" name="quantity" id="quantity"
                                   value="{{ old('quantity', $product->quantity) }}">
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </p>

                        <p>
                            <textarea name="description" id="description" cols="30" rows="10"
                                      placeholder="description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </p>

                        <p>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">--Select Category--</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ (string) old('category_id', $product->category_id) === (string) $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </p>

                        <p>
                            <input type="file" class="form-control" name="image" id="image">
                            @if(!empty($product->image))
                                <img src="{{ url($product->image) }}" alt="current image"
                                     style="max-height:120px; margin-top:8px;">
                            @endif
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </p>

                        <p>
                            <input type="submit" value="Update">
                            <a href="{{ url('/admin/product') }}" class="btn btn-link">Cancel</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
