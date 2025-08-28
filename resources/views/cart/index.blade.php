@extends('Layouts.master')

@section('content')
<div class="container mt-150 mb-150">

    {{-- تنبيه نجاح/أخطاء --}}
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
                <a href="{{ url('/') }}" class="boxed-btn" style="background:#f28123;border-color:#f28123;">Back to Shop</a>
            </div>
        </div>
    @else
    <div class="row">
        {{-- جدول السلة --}}
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
                        <tr class="table-body-row">
                            {{-- remove --}}
                            <td class="product-remove">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Remove this item?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn p-0" title="Remove">
                                        <i class="far fa-window-close"></i>
                                    </button>
                                </form>
                            </td>

                            {{-- image --}}
                            <td class="product-image">
                                @if(!empty($item->image))
                                    <img src="{{ url($item->image) }}" alt="{{ $item->name }}" class="cart-img">
                                @else
                                    <img src="{{ asset('images/placeholder.png') }}" alt="{{ $item->name }}" class="cart-img">
                                @endif
                            </td>

                            {{-- name --}}
                            <td class="product-name">{{ $item->name }}</td>

                            {{-- price --}}
                            <td class="product-price">${{ number_format($item->price, 2) }}</td>

                            {{-- quantity (تحديث فوري) --}}
                            <td class="product-quantity">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex gap-2 align-items-center">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" min="1" step="1"
                                           value="{{ $item->quantity }}" class="qty-input"
                                           onchange="this.form.submit()">
                                    <noscript>
                                        <button class="boxed-btn" type="submit">Update</button>
                                    </noscript>
                                </form>
                            </td>

                            {{-- row total --}}
                            <td class="product-total">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- الملخص والعمليات --}}
        <div class="col-lg-4">
            @php
                $shipping = $shipping ?? 0;  // عدّلها إذا عندك سياسة شحن
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

                    <form action="{{ route('checkout.place') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="boxed-btn black">Check Out</button>
                    </form>
                </div>
            </div>

            {{-- كوبون (اختياري حالياً واجهة فقط) --}}
            <div class="coupon-section">
                <h3>Apply Coupon</h3>
                <div class="coupon-form-wrap">
                    <form action="#" method="POST" onsubmit="alert('Coupon feature coming soon');return false;">
                        <p><input type="text" placeholder="Coupon"></p>
                        <p><input type="submit" value="Apply"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- تنسيقات خفيفة للصورة والحقل (تبقى على ثيمك) --}}
<style>
 .cart-img{max-width:80px;max-height:80px;object-fit:cover;border-radius:6px}
 .qty-input{width:90px;padding:.35rem .5rem}
 .cart-table .btn{background:transparent;border:none}
 .boxed-btn{display:inline-block;padding:10px 20px;border:2px solid #333;border-radius:0;font-weight:600}
 .boxed-btn.black{background:#333;color:#fff;border-color:#333}
 .boxed-btn.black:hover{opacity:.9;color:#fff}
</style>
@endsection
