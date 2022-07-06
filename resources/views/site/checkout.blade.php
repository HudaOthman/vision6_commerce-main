@extends('site.master')

@section('content')

    <main class="ps-main">
      <div class="ps-checkout pt-80 pb-80">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">

                  <script src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}"></script>
                  <form action="{{ route('site.thanks') }}" class="paymentWidgets" data-brands="VISA MASTER AMEX MADA"></form>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                  <div class="ps-checkout__order">
                    <header>
                      <h3>Your Order</h3>
                    </header>
                    <div class="content">
                      <table class="table ps-checkout__products">
                        <thead>
                          <tr>
                            <th class="text-uppercase">Product</th>
                            <th class="text-uppercase">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                            <tr>
                                <td>{{ $cart->product->trans_name }} x{{ $cart->quantity }}</td>
                                <td>${{ $cart->price * $cart->quantity }}</td>
                              </tr>
                            @endforeach

                          <tr>
                              <td colspan="2">
                                  <hr style="margin-top: 5px;margin-bottom:5px">
                              </td>
                          </tr>
                          <tr>
                            <td><h3>Order Total</h3></td>
                            <td><h3>${{ number_format($total, 2) }}</h3></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div>
                  <div class="ps-shipping">
                    <h3>FREE SHIPPING</h3>
                    <p>YOUR ORDER QUALIFIES FOR FREE SHIPPING.<br> <a href="#"> Singup </a> for free shipping on every order, every time.</p>
                  </div>
                </div>
          </div>
        </div>
      </div>
@stop
