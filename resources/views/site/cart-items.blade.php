<div class="ps-cart-listing">
    @if (session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
        </div>
    @endif
    <form action="{{ route('site.update_cart') }}" method="POST">
        @csrf
        <table class="table ps-cart__table">
            <thead>
              <tr>
                <th>All Products</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @php
                            $total = 0;
                        @endphp

                @foreach ($carts as $cart)
                @php
                            $total += $cart->quantity * $cart->price;
                        @endphp
                {{-- <input type="hidden" name="cart_ids[]" value="{{ $cart->id }}"> --}}
                <tr>
                  <td>
                      <a class="ps-product__preview" href="{{ route('site.product', $cart->product->slug) }}">
                          <img width="120" class="mr-15" src="{{ $cart->product->url }}" alt=""> {{ $cart->product->trans_name }}</a></td>
                  <td>${{ $cart->price }}</td>
                  <td>
                    <div class="form-group--number">
                      <button class="minus"><span>-</span></button>
                      <input class="form-control" type="text" name="qty[{{ $cart->id }}]" value="{{ $cart->quantity }}">
                      <button class="plus"><span>+</span></button>
                    </div>
                  </td>
                  <td>${{ $cart->price * $cart->quantity }}</td>
                  <td>
                    <a href="{{ route('site.remove_cart', $cart->id) }}"><div class="ps-remove"></div></a>
                  </td>
                </tr>
                @endforeach

            </tbody>
          </table>

          <button id="update_btn" class="ps-btn ps-btn--gray">Update Cart</button>
    </form>
    <div class="ps-cart__actions">
      <div class="ps-cart__promotion">
        <div class="form-group">
          <div class="ps-form--icon"><i class="fa fa-angle-right"></i>
            <input class="form-control" type="text" placeholder="Promo Code">
          </div>
        </div>
        <div class="form-group">
          <button class="ps-btn ps-btn--gray">Continue Shopping</button>
        </div>
      </div>
      <div class="ps-cart__total">
        <h3>Total Price: <span> {{ $total }} $</span></h3><a class="ps-btn" href="{{ route('site.checkout') }}">Process to checkout<i class="ps-icon-next"></i></a>
      </div>
    </div>
  </div>
