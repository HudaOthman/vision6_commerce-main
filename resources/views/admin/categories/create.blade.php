@extends('admin.master')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">{{ __('site.Add New') }}</h1>
        <a class="btn btn-outline-dark" href="{{ route('admin.categories.index') }}">All Categories</a>
    </div>

    @include('admin.errors')

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.categories.form')

        <button class="btn btn-success btn-lg px-5 mt-4">Add</button>
    </form>

@stop
