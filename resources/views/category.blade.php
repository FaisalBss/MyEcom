@extends('Layouts.master')

@section('content')

    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            @foreach ($categories as $item)
                                <li data-filter="._{{ $item->id }}">{{ $item->name }}</li>
                            @endforeach
                            <li class="active" data-filter="*">All</li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="row product-lists">
                @foreach ($products as $item)
                        <div class="col-lg-4 col-md-6 text-center _{{ $item->category_id }} ">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="single-product.html"><img style="max-height: 200px; min-height: 200px;" src="{{ $item->image }}" alt=""></a>
                            </div>
                            <h3>{{ $item->name }}</h3>
                            <p class="product-price"><span>Price: </span> {{ $item->price }} $ </p>
                            <p class="product-Quantity"><span>Quantity: </span> {{ $item->quantity }} $ </p>

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
                        </div>
                    </div>
                @endforeach

            <div style="text-align: center; margin: 0px auto; ">
                {{ $products->links() }}
            </div>

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
