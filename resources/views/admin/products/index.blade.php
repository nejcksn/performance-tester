@extends('adminlte::page')

@section('title', 'Product List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Product List</h1>
        <a class="btn btn-success" href="{{ route('admin.products.create') }}">
            <i class="fas fa-plus"></i> Add new Product
        </a>
    </div>
@endsection

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
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->brand ? $product->brand->name : 'Not specified' }}</td>
                            <td>{{ $product->price ? $product->price . ' $' : 'Price not specified' }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                         width="50">
                                @else
                                    No image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-type="product"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-route="{{ route('admin.products.destroy', '') }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    @include('components.deleteModal')
@stop
