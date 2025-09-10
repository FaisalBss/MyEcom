@extends('admin.admin')

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

                                <a href="{{ route('products.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit Product</a>
                                <form action="{{ route('products.destroy', $item->id) }}" method="POST" style="display:inline"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-shopping-cart"></i> Delete Product
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach



                </div>
            </div>
            @if($products->hasPages())
    <div class="d-flex justify-content-center mt-3">
      {{ $products->onEachSide(1)->links() }}
    </div>
    <div class="text-muted small mt-2 text-center">
      Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
    </div>
  @endif
        </div>
@endsection()

<style>
    svg {
        width: 50px;
        height: 50px;
    }
</style>
