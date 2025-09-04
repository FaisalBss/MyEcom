@extends('Layouts.master')

@section('content')

@auth
    @if(auth()->user()->role === 'admin')

    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Adding</span> Products</h3>
                        <p>Adding products has never been easier with our website</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="form-title">
                        <h2>Add products</h2>
                        <p>here you can add products</p>
                    </div>
                    <div id="form_status"></div>
                    <div class="contact-form">
                        <form Method="POST" enctype="multipart/form-data" action="{{ route('products.store') }}" style="text-align: left;">
                            @csrf
                            <p>
                                <input type="text" style="width: 100%" placeholder="Name" name="name" id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                            </p>
                            <p style="display: flex; justify-content: space-between;">
                                <input type="number" step="0.1" style="width:49%" placeholder="Price" name="price" id="price" value="{{ old('price') }}">
                                    @error('price')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                                <input type="number" style="width:49%" placeholder="Quantity" name="quantity" id="quantity" value="{{ old('quantity') }}">
                                    @error('quantity')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                            </p>
                            <p><textarea name="description" id="description" cols="30" rows="10" placeholder="description"></textarea>
                                    @error('description')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                            </p>
                            <p>
                            <select class="form-control" name="category_id" id="category_id" >
                                <option value="">--Select Category--</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="text-danger">
                                {{ $message }}
                                </span>
                            @enderror
                            </p>
                            <p>
                                <input type="file" class="form-control" name="image" id="image">
                                @error('image')
                                    <span class="text-danger">
                                    {{ $message }}
                                    </span>
                                @enderror
                            </p>
                            <p><input type="submit" value="Submit"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
@endauth


@endsection
