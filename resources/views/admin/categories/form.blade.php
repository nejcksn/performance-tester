@extends('adminlte::page')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content_header')
    <h1>{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset

                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name ?? '') }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@stop
