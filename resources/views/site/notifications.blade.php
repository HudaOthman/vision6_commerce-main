@extends('site.master')

@section('content')
    <main class="ps-main">
      <div class="ps-content pt-80 pb-80">
        <div class="ps-container" id="cart-content">
            <h3 class="mb-5">Your Notifications</h3>
            <ul class="list-group">
                @foreach ($user->notifications as $item)
                    @if ($item->read_at)
                    <li class="list-group-item">{{ $item->data['title'] }}</li>
                    @else
                    <a href="{{ route('read_notification', $item->id) }}" class="list-group-item list-group-item-danger">{{ $item->data['title'] }}</a>
                    @endif


                @endforeach

              </ul>
        </div>
      </div>
@stop
