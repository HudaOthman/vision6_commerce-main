@extends('admin.master')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">Deleted Category</h1>
        <a class="btn btn-outline-dark" href="{{ route('admin.categories.index') }}">All Categories</a>
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
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    {{-- <td>{{ json_decode($category->name, true)[App::currentLocale()] }}</td> --}}
                    <td>{{ $category->trans_name }}</td>
                    <td>{{ $category->deleted_at->diffForHumans() }}</td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.restore', $category->id) }}"><i class="fas fa-undo"></i></a>
                        @if (Auth::user()->type == 'super-admin')
                            <a onclick="return confirm('Are you sure?!')" class="btn btn-sm btn-danger" href="{{ route('admin.categories.forcedelete', $category->id) }}"><i class="fas fa-times"></i></a>
                        @endif


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
