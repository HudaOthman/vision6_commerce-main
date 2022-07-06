@extends('admin.master')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">{{ __('site.All Categories') }}</h1>
        <a class="btn btn-outline-dark" href="{{ route('admin.categories.create') }}">Add New Category</a>
    </div>

    @if (session('msg'))
    <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
        {{ session('msg') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif

    {{-- {{ App::currentLocale() }} --}}
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr class="bg-dark text-white">
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Parent</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    {{-- <td>{{ json_decode($category->name, true)[App::currentLocale()] }}</td> --}}
                    <td>{{ $category->trans_name }}</td>
                    <td>
                        @php
                            $src = 'https://via.placeholder.com/80';
                            if(file_exists(public_path('uploads/images/categories/'.$category->image))){
                                $src = asset('uploads/images/categories/'.$category->image);
                            }
                        @endphp
                        <img width="80" src="{{ $src }}" alt="">
                    </td>
                    <td> {{ $category->parent->trans_name??'' }}</td>
                    {{-- <td>{{ $category->created_at->format('d M, Y') }}</td> --}}
                    <td>{{ $category->created_at->diffForHumans() }}</td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', $category->id) }}"><i class="fas fa-edit"></i></a>
                        <form class="d-inline" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No Data Found</td>
            </tr>
            @endforelse

        </tbody>
    </table>

    {{ $categories->links() }}
@stop
