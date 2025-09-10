@extends('Layouts.master')

@section('content')
<div class="container my-5">
  <h3 class="mb-4 text-center">Payment Details</h3>

  @if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

  <form action="{{ route('checkout.payment.save') }}" method="POST" class="p-4 border rounded bg-light shadow-sm mb-4">
    @csrf
    <h5>Add New Card</h5>

    <div class="mb-3">
      <label class="form-label">Cardholder Name</label>
      <input type="text" name="card_name" class="form-control" >
    </div>
    <div class="mb-3">
      <label class="form-label">Card Number</label>
      <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" >
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Expiry Month</label>
        <input type="number" name="exp_month" class="form-control" min="1" max="12" >
      </div>
      <div class="col-md-6">
        <label class="form-label">Expiry Year</label>
        <input type="number" name="exp_year" class="form-control" min="{{ date('Y') }}" max="{{ date('Y')+20 }}" >
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Save Card</button>
  </form>

  {{-- الدفع باستخدام بطاقة محفوظة --}}
  <form action="{{ route('checkout.payment.place') }}" method="POST" class="p-4 border rounded bg-light shadow-sm">
    @csrf
    <h5>Use Saved Card</h5>
    <div class="mb-3">
      <label class="form-label">Select Card</label>
      <select name="payment_method_id" class="form-control" >
        <option value="">-- Select --</option>
        @foreach($methods as $m)
          <option value="{{ $m->id }}">
            {{ $m->cardholder_name }} - **** **** **** {{ $m->last4 }}
            ({{ $m->exp_month }}/{{ $m->exp_year }})
          </option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">CVV</label>
      <input type="password" name="cvv" class="form-control" maxlength="4" placeholder="123" >
    </div>
    <button type="submit" class="btn btn-success">Place Order</button>
  </form>
</div>
@endsection
