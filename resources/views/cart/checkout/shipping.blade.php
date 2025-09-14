@extends('Layouts.master')

@section('content')
<div class="container my-5">
  <h3 class="mb-4 text-center">Shipping Address</h3>

  @if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

  <form action="{{ route('checkout.shipping.store') }}" method="POST" class="p-4 border rounded bg-light shadow-sm mb-4">
    @csrf
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="full_name" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Address Line 1</label>
      <input type="text" name="address_line1" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">City</label>
      <input type="text" name="city" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">State</label>
      <input type="text" name="state" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">ZIP</label>
      <input type="text" name="zip" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Country</label>
      <input type="text" name="country" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save Address</button>
  </form>

  <div class="p-4 border rounded bg-light shadow-sm">
    <h5>Select a Shipping Address</h5>
    <form action="{{ route('checkout.shipping.select') }}" method="POST">
        @csrf
      <select name="shipping_address_id" class="form-control mb-3">
        <option value="">-- Select an address --</option>
        @foreach($addresses as $addr)
          <option value="{{ $addr->id }}">
            {{ $addr->full_name }} - {{ $addr->city }} - {{ $addr->country }}
          </option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-success">Proceed to Payment</button>
    </form>
  </div>
</div>
@endsection
