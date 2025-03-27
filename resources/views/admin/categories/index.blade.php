@extends('adminlte::page')

@section('title', 'Category List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Category List</h1>
        <a class="btn btn-success" href="{{ route('admin.categories.create') }}">
            <i class="fas fa-plus"></i> Add new Category
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->products->count() }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-type="category"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        data-route="{{ route('admin.categories.destroy', '') }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                <div class="d-flex justify-content-center">--}}
{{--                     {{ $categories->links('pagination::bootstrap-4') }} --}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    @include('components.deleteModal')
@stop
