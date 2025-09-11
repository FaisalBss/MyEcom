@extends('Layouts.master')

@section('content')

<div class="container mt-150 mb-150">

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @error('cart')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @if($items->isEmpty())
        <div class="row">
            <div class="col-12 text-center">
                <h4>Your cart is empty</h4>
                <a href="{{ url('/') }}" class="boxed-btn" style="background:#f28123;border-color:#f28123;">
                    Back to Shop
                </a>
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="cart-table-wrap">
                <table class="cart-table">
                    <thead class="cart-table-head">
                        <tr class="table-head-row">
                            <th class="product-remove"></th>
                            <th class="product-image">Product Image</th>
                            <th class="product-name">Name</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-total">Total</th>
                        </tr>
                    </thead>
                   <tbody>
@foreach($items as $item)
    @php
        $p = $item->product;
        if (!$p) continue;
        $price = (float) $p->price;
        $qty   = (int) $item->quantity;
        $rowTotal = $price * $qty;

        $img = $p->image
            ? (preg_match('/^https?:\/\//', $p->image) ? $p->image : asset($p->image))
            : asset('images/placeholder.png');
    @endphp
    <tr class="table-body-row">
        <td class="product-remove">
            <form action="{{ route('cart.remove', $p->id) }}" method="POST"
                  onsubmit="return confirm('Remove this item?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn p-0" title="Remove">
                    <i class="far fa-window-close"></i>
                </button>
            </form>
        </td>

        <td class="product-image">
            <img src="{{ $img }}" alt="{{ $p->name }}" class="cart-img">
        </td>

        <td class="product-name">{{ $p->name }}</td>
        <td class="product-price">${{ number_format($price, 2) }}</td>

        <td class="product-quantity">
            <form action="{{ route('cart.update', $p->id) }}" method="POST" class="d-inline-flex gap-2 align-items-center">
                @csrf @method('PATCH')
                <input type="number" name="quantity" min="1" step="1"
                       value="{{ $qty }}" class="qty-input"
                       onchange="this.form.submit()">
                <noscript><button class="boxed-btn" type="submit">Update</button></noscript>
            </form>
        </td>

        <td class="product-total">${{ number_format($rowTotal, 2) }}</td>
    </tr>
@endforeach
</tbody>

                </table>
            </div>
        </div>

        <div class="col-lg-4">
            @php
                $shipping = $shipping ?? 0;
                $grandTotal = $total + $shipping;
            @endphp

            <div class="total-section">
                <table class="total-table">
                    <thead class="total-table-head">
                        <tr class="table-total-row">
                            <th>Total</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="total-data">
                            <td><strong>Subtotal: </strong></td>
                            <td>${{ number_format($total, 2) }}</td>
                        </tr>
                        <tr class="total-data">
                            <td><strong>Shipping: </strong></td>
                            <td>${{ number_format($shipping, 2) }}</td>
                        </tr>
                        <tr class="total-data">
                            <td><strong>Total: </strong></td>
                            <td>${{ number_format($grandTotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="cart-buttons d-flex gap-2 mt-3">
                    <a href="{{ url('/') }}" class="boxed-btn"
                       style="background:#f28123;border-color:#f28123;">Back to Shop</a>

                    <a href="{{ route('checkout.shipping') }}" class="boxed-btn black">Check Out</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
 .cart-img{max-width:80px;max-height:80px;object-fit:cover;border-radius:6px}
 .qty-input{width:90px;padding:.35rem .5rem}
 .cart-table .btn{background:transparent;border:none}
 .boxed-btn{display:inline-block;padding:10px 20px;border:2px solid #333;border-radius:0;font-weight:600}
 .boxed-btn.black{background:#333;color:#fff;border-color:#333}
 .boxed-btn.black:hover{opacity:.9;color:#fff}
</style>
@endsection
