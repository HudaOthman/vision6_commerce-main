@extends('admin.master')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">{{ __('site.Edit Category') }}</h1>
        <a class="btn btn-outline-dark" href="{{ route('admin.products.index') }}">All Categories</a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('admin.products.form')

        <button class="btn btn-info btn-lg px-5 mt-4">Update</button>
    </form>

@stop
