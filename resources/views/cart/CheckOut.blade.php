@extends('Layouts.master')

@section('content')
@php
    $addr = auth()->user()?->shippingAddress;
    $pm   = auth()->user()?->defaultPaymentMethod;
@endphp

@php
    $methods   = auth()->user()?->paymentMethods ?? collect();
    $addresses = \App\Models\ShippingAddress::where('user_id', auth()->id())->get();
@endphp

<div class="container">

			<div class="row">
				<div class="col-lg-8">
					<div class="checkout-accordion-wrap">
						<div class="accordion" id="accordionExample">
						  <div class="card single-accordion">
						    <div class="card-header" id="headingOne">
						      <h5 class="mb-0">
						        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          Payment Details
						        </button>
						      </h5>
						    </div>

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="payment-form">
                                    <h4>Payment Details</h4>
                                    <form action="{{ route('payment-methods.upsert') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="payment_method_id">Choose a saved card</label>
                                    <select id="payment_method_id" name="payment_method_id" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach($methods as $m)
                                            <option
                                            value="{{ $m->id }}"
                                            data-name="{{ $m->cardholder_name }}"
                                            data-brand="{{ $m->brand }}"
                                            data-last4="{{ $m->last4 }}"
                                            data-exp-month="{{ $m->exp_month }}"
                                            data-exp-year="{{ $m->exp_year }}"
                                            @selected(optional($pm)->id === $m->id)
                                            >
                                            {{ $m->brand ?? 'Card' }} •••• {{ $m->last4 }} ({{ sprintf('%02d/%02d', $m->exp_month, $m->exp_year % 100) }})
                                            </option>
                                        @endforeach
                                        <option value="new">+ Add New Card</option>
                                    </select>
                                            <label for="card_name">Cardholder Name</label>
                                            <input
                                                value="{{ old('card_name', $pm->cardholder_name ?? '') }}"
                                                type="text" class="form-control" id="card_name" name="card_name"
                                                placeholder="Name on Card" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="card_number">Card Number</label>
                                            <input
                                                value=""
                                                type="text" class="form-control" id="card_number" name="card_number"
                                                placeholder="{{ isset($pm) ? '**** **** **** '.$pm->last4 : '1234 5678 9012 3456' }}"
                                                maxlength="19" required>
                                        </div>

                                        <div class="form-row" style="display: flex; gap: 15px;">
                                            <div class="form-group" style="flex: 1;">
                                                <label for="expiry_date">Expiry Date</label>
                                                <input
                                                    value="{{ old('expiry_date', isset($pm) ? sprintf('%02d/%02d', $pm->exp_month, $pm->exp_year % 100) : '') }}"
                                                    type="text" class="form-control" id="expiry_date" name="expiry_date"
                                                    placeholder="MM/YY" required>
                                            </div>

                                            <div class="form-group" style="flex: 1;">
                                                <label for="cvv">CVV</label>
                                                <input
                                                    value="" type="password" class="form-control" id="cvv" name="cvv"
                                                    placeholder="123" maxlength="4" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success">Pay Now</button>
                                    </form>
                                </div>
						      </div>
						    </div>
						  </div>
						  <div class="card single-accordion">
						    <div class="card-header" id="headingTwo">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          Shipping Address
						        </button>
						      </h5>
						    </div>
						    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="shipping-address-form">
                                    <h4>Shipping Address</h4>
                                    <form action="{{ route('shipping.upsert') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label for="address_id">Choose a saved address</label>
                                        <select id="address_id" name="address_id" class="form-control">
                                            <option value="">-- Select --</option>
                                            @foreach($addresses as $a)
                                                <option
                                                value="{{ $a->id }}"
                                                data-full-name="{{ $a->full_name }}"
                                                data-line1="{{ $a->address_line1 }}"
                                                data-line2="{{ $a->address_line2 }}"
                                                data-city="{{ $a->city }}"
                                                data-state="{{ $a->state }}"
                                                data-zip="{{ $a->zip }}"
                                                data-country="{{ $a->country }}"
                                                data-phone="{{ $a->phone }}"
                                                >
                                                {{ $a->city }} - {{ $a->zip }}
                                                </option>
                                            @endforeach
                                            <option value="new">+ Add New Address</option>
                                        </select>
                                            <label for="full_name">Full Name</label>
                                            <input
                                                value="{{ old('full_name', $addr->full_name ?? '') }}"
                                                type="text" class="form-control" id="full_name" name="full_name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="address_line1">Address Line 1</label>
                                            <input
                                                value="{{ old('address_line1', $addr->address_line1 ?? '') }}"
                                                type="text" class="form-control" id="address_line1" name="address_line1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="address_line2">Address Line 2 (Optional)</label>
                                            <input
                                                value="{{ old('address_line2', $addr->address_line2 ?? '') }}"
                                                type="text" class="form-control" id="address_line2" name="address_line2">
                                        </div>

                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input
                                                value="{{ old('city', $addr->city ?? '') }}"
                                                type="text" class="form-control" id="city" name="city" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="state">State / Province</label>
                                            <input
                                                value="{{ old('state', $addr->state ?? '') }}"
                                                type="text" class="form-control" id="state" name="state" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="zip">ZIP / Postal Code</label>
                                            <input
                                                value="{{ old('zip', $addr->zip ?? '') }}"
                                                type="text" class="form-control" id="zip" name="zip" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input
                                                value="{{ old('country', $addr->country ?? '') }}"
                                                type="text" class="form-control" id="country" name="country" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input
                                                value="{{ old('phone', $addr->phone ?? '') }}"
                                                type="tel" class="form-control" id="phone" name="phone" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Save Shipping Address</button>
                                    </form>
                                </div>
						      </div>
						    </div>
						  </div>
						  <div class="card single-accordion">
						    <div class="card-header" id="headingThree">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						          Cart Details
						        </button>
						      </h5>
						    </div>
						    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="card-details">
						        	<div class="card-details">
                                <div class="container mt-150 mb-150">

                                    @if($items->isEmpty())
                                    <div class="row">
                                        <div class="col-12 text-center">
                                        <h4>Your cart is empty</h4>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12">
                                        <div class="cart-table-wrap">
                                            <table class="cart-table">
                                            <thead class="cart-table-head">
                                                <tr class="table-head-row">
                                                <th class="product-image">Product Image</th>
                                                <th class="product-name">Name</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Qty</th>
                                                <th class="product-total">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $item)
                                                @php
                                                    $p = $item->product; if(!$p) continue;
                                                    $price = (float) $p->price;
                                                    $qty   = (int) $item->quantity;
                                                    $rowTotal = $price * $qty;
                                                    $img = $p->image
                                                    ? (preg_match('/^https?:\/\//', $p->image) ? $p->image : asset($p->image))
                                                    : asset('images/placeholder.png');
                                                @endphp
                                                <tr class="table-body-row">
                                                    <td class="product-image"><img src="{{ $img }}" alt="{{ $p->name }}" class="cart-img"></td>
                                                    <td class="product-name">{{ $p->name }}</td>
                                                    <td class="product-price">${{ number_format($price, 2) }}</td>
                                                    <td class="product-quantity">{{ $qty }}</td>
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
                                                <th>Order Summary</th>
                                                <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="total-data">
                                                <td><strong>Subtotal:</strong></td>
                                                <td>${{ number_format($total, 2) }}</td>
                                                </tr>
                                                <tr class="total-data">
                                                <td><strong>Shipping:</strong></td>
                                                <td>${{ number_format($shipping, 2) }}</td>
                                                </tr>
                                                <tr class="total-data">
                                                <td><strong>Total:</strong></td>
                                                <td>${{ number_format($grandTotal, 2) }}</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>

                                        </div>
                                    </div>
                                    @endif

                                </div>
                                    </div>

						        </div>
						      </div>
						    </div>
						  </div>
						</div>

					</div>
				</div>

				<div class="col-lg-4">
					<div class="order-details-wrap">
						<table class="order-details">

						</table>
						<a href="#" class="boxed-btn">Place Order</a>
					</div>
				</div>
			</div>
		</div>

        <script>
document.addEventListener('DOMContentLoaded', function () {
  // === Payment select ===
  const pmSel = document.getElementById('payment_method_id');
  const cardName = document.getElementById('card_name');
  const cardNum  = document.getElementById('card_number');
  const expDate  = document.getElementById('expiry_date');
  const cvv      = document.getElementById('cvv');

  function setCardRequired(isNew) {
    cardNum.required = isNew;
    expDate.required = true; // نحتاجه حتى للقديمة (للتعبئة)
    cardName.required = true;
  }

  if (pmSel) {
    pmSel.addEventListener('change', function () {
      const opt = pmSel.options[pmSel.selectedIndex];
      if (!opt || opt.value === '') return; // لاشيء
      if (opt.value === 'new') {
        // NEW card
        cardName.value = '';
        cardNum.value  = '';
        cardNum.placeholder = '1234 5678 9012 3456';
        expDate.value  = '';
        cvv.value      = '';
        setCardRequired(true);
        return;
      }
      // Existing card
      const name = opt.dataset.name || '';
      const last4 = opt.dataset.last4 || '';
      const brand = opt.dataset.brand || 'Card';
      const mm = String(opt.dataset.expMonth || '').padStart(2,'0');
      let yy = opt.dataset.expYear || '';
      yy = yy ? String(yy).slice(-2) : '';

      cardName.value = name;
      cardNum.value  = ''; // لا نملأ الرقم
      cardNum.placeholder = `**** **** **** ${last4}`;
      expDate.value  = mm && yy ? `${mm}/${yy}` : '';
      cvv.value      = '';

      // عند اختيار بطاقة محفوظة، ما نحتاج رقم البطاقة
      setCardRequired(false);
    });
  }

  // === Address select ===
  const addrSel = document.getElementById('address_id');
  const fullName = document.getElementById('full_name');
  const line1 = document.getElementById('address_line1');
  const line2 = document.getElementById('address_line2');
  const city  = document.getElementById('city');
  const state = document.getElementById('state');
  const zip   = document.getElementById('zip');
  const country = document.getElementById('country');
  const phone = document.getElementById('phone');

  if (addrSel) {
    addrSel.addEventListener('change', function () {
      const opt = addrSel.options[addrSel.selectedIndex];
      if (!opt || opt.value === '') return;
      if (opt.value === 'new') {
        [fullName,line1,line2,city,state,zip,country,phone].forEach(i => i && (i.value = ''));
        return;
      }
      fullName.value = opt.dataset.fullName || '';
      line1.value    = opt.dataset.line1 || '';
      line2.value    = opt.dataset.line2 || '';
      city.value     = opt.dataset.city || '';
      state.value    = opt.dataset.state || '';
      zip.value      = opt.dataset.zip || '';
      country.value  = opt.dataset.country || '';
      phone.value    = opt.dataset.phone || '';
    });
  }
});
</script>

@endsection()
