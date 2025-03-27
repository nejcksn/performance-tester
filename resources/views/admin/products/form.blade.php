@extends('adminlte::page')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('content_header')
    <h1>{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $product->name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01"
                           value="{{ old('price', $product->price ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if(isset($product) && $product->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
@push('js')
    <script>
        $(document).ready(function() {
            $('#category_id, #brand_id').select2({
                width: '100%',
                placeholder: "Select an option",
                theme: 'bootstrap-4',
                allowClear: true
            });
        });
    </script>
@endpush
