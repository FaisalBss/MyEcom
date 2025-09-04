@extends('Layouts.master')

@section('content')

    <div class="product-section mt-150 mb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="section-title">
                            <h3><span class="orange-text">Products</span></h3>
                            <p>Each product has excilint quality</p>
                        </div>
                    </div>
                </div>

                <div class="row">

                    @foreach ($products as $item)
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="single-product.html">

                                        <img src="{{ url($item->image) }}"
                                        style="max-height: 200px!important;min-height: 200px!important;"
                                         alt=""></a>
                                </div>
                                <h3>{{ $item->name }}</h3>
                                <p class="product-price"><span>{{ $item->quantity }}</span> {{ $item->price }} $</p>

                                @auth
                                    <form action="{{ route('cart.add', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-orange">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-orange">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </a>
                                @endauth

                                @auth
                                    @if(auth()->user()->role === 'admin')
                                <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit Product</a>
                                <form action="{{ route('products.destroy', $item->id) }}" method="POST" style="display:inline"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-shopping-cart"></i> Delete Product
                                    </button>
                                </form>
                                    @endif
                                @endauth

                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
@endsection()

<style>
    svg {
        width: 50px;
        height: 50px;
    }
</style>
