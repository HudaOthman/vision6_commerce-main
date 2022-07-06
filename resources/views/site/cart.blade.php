@extends('site.master')

@section('content')
    <main class="ps-main">
      <div class="ps-content pt-80 pb-80">
        <div class="ps-container" id="cart-content">
            @include('site.cart-items')
        </div>
      </div>
@stop

@section('scripts')
<script>
    // $('.minus').click(function(e) {
    $('body').on('click', '.minus', function(e) {
        e.preventDefault();
        $(this).next().val( $(this).next().val() - 1 )
        if($(this).next().val() < 1) {
            $(this).next().val(1)
        }
    })

    // $('.plus').click(function(e) {
        $('body').on('click', '.plus', function(e) {
        e.preventDefault();
        $(this).prev().val( parseInt($(this).prev().val()) + 1 )
    })

    // Update Cart ajax

    // $('#update_btn').click(function(e) {
        $('body').on('click', '#update_btn', function(e) {
        e.preventDefault();

        var data = $('form').serialize();

        $.ajax({
            type: 'post',
            url: '{{ route("site.update_cart") }}',
            data: data,
            success: function(res) {
                $('#cart-content').html(res);
            }
        })
    })









</script>

@endsection
