@extends('Layouts.master')

@section('content')
<div class="container">
    <h2>My Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Products</th>
                <th>Total</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->product->name }} (x{{ $item->quantity }}) <br>
                        @endforeach
                    </td>
                    <td>
                        <strong>{{ $order->total ?? $order->total_amount }}</strong>
                    </td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">You have no orders yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
