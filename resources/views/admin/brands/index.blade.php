@extends('adminlte::page')

@section('title', 'Brands')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Brand List</h1>
        <a class="btn btn-success" href="{{ route('admin.brands.create') }}">
            <i class="fas fa-plus"></i> Add new Brand
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
                        <th>Description</th>
                        <th>Country</th>
                        <th>Founded Year</th>
                        <th>Logo</th>
                        <th>Products</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->description ?? 'N/A' }}</td>
                            <td>{{ $brand->country ?? 'N/A' }}</td>
                            <td>{{ $brand->founded_year ?? 'N/A' }}</td>
                            <td data-label="Logo">
                                @if($brand->logo)
                                    <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }} Logo"
                                         style="max-width: 100px; height: auto;">
                                @else
                                    <span>No Logo</span>
                                @endif
                            </td>
                            <td>{{ $brand->products->count() }}</td>
                            <td>
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-type="brand"
                                        data-id="{{ $brand->id }}"
                                        data-name="{{ $brand->name }}"
                                        data-route="{{ route('admin.brands.destroy', '') }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $brands->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    @include('components.deleteModal')
@stop
