@extends('adminlte::page')

@section('title', isset($brand) ? 'Edit Brand' : 'Create Brand')

@section('content_header')
    <h1>{{ isset($brand) ? 'Edit Brand' : 'Create Brand' }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($brand) ? route('admin.brands.update', $brand) : route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($brand)
                    @method('PUT')
                @endisset

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $brand->name ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $brand->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $brand->country ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="founded_year" class="form-label">Founded Year</label>
                    <input type="number" class="form-control" id="founded_year" name="founded_year" value="{{ old('founded_year', $brand->founded_year ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo">
                    @if(isset($brand) && $brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}" alt="Brand Logo" style="max-width: 100px; margin-top: 10px;">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($brand) ? 'Update' : 'Create' }}</button>
            </form>
        </div>
    </div>
@stop
