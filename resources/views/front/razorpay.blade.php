@extends('layouts.front')

@section('content')
<section class="payment-section py-5">
  <div class="container text-center">
    <h3 class="mb-4">Processing Payment for Booking #{{ $booking->id }}</h3>
    <h4>Amount: ₹{{ number_format($booking->total_amount, 2) }}</h4>

    <button id="rzp-button" class="btn btn-success mt-4">Pay Now</button>
    <button class="btn btn-outline-secondary mt-4" onclick="history.back()">⬅ Back</button>

    <form name="razorpayform" id="razorpayform" action="{{ route('site.payment.success') }}" method="POST">
      @csrf
      <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
      <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $order['id'] }}">
    </form>
  </div>
</section>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  document.getElementById('rzp-button').onclick = function(e) {
    var options = {
      "key": "{{ $razorpayKey }}",
      "amount": "{{ $order['amount'] }}",
      "currency": "INR",
      "name": "Bus Booking",
      "description": "Booking Payment",
      "order_id": "{{ $order['id'] }}",
      "handler": function(response) {
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpayform').submit();
      },
      "prefill": {
        "name": "{{ $booking->customer_name }}",
        "email": "{{ $booking->customer_email }}",
        "contact": "{{ $booking->customer_phone }}"
      },
      "theme": {
        "color": "#3399cc"
      }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
  }

  window.onload = function() {
    document.getElementById('rzp-button').click();
  };
</script>
@endsection