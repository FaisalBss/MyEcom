@extends('admin.admin')

@section('content')
<div class="container">
    <h2>User Orders</h2>
    <table class="table table-bordered">
        <form action="{{ route('admin.orders.search') }}" method="GET" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control me-2"
           placeholder="Search by ID, Product, User, or Status"
           value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Search</button>
</form>

        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Order</th>
                <th>Price</th>
                <th>Status</th>
                <th>Change Status</th>
            </tr>
        </thead>
                <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->user->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>
                    @foreach($order->items as $item)
                        {{ $item->product->name }} (x{{ $item->quantity }}) <br>
                    @endforeach
                </td>
                <td>
                    @foreach($order->items as $item)
                        {{ $item->subtotal }} <br>
                    @endforeach
                    <strong>Total: {{ $order->total ?? $order->total_amount }}</strong>
                </td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        <select name="status" class="form-control">
                            <option value="pending"   {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted"  {{ $order->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="on_the_way"{{ $order->status == 'on_the_way' ? 'selected' : '' }}>On the way</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="canceled"  {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <div class="d-flex justify-content-center mt-3">
    {{ $orders->links() }}
</div>

</div>
@endsection
