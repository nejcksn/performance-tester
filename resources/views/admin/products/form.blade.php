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

                <div id="fields-container"></div>

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
@endsection
@push('js')
   <script>
       document.addEventListener("DOMContentLoaded", function () {
           let categorySelect = document.getElementById('category_id');
           let container = document.getElementById('fields-container');

           $('#category_id').on('select2:select', function (e) {
               let categoryId = $(this).val();
               console.log("Выбрана категория через Select2:", categoryId); // Проверяем

               container.innerHTML = '';

               if (categoryId) {
                   fetch(`/api/category-fields/${categoryId}`)
                       .then(response => response.json())
                       .then(fields => {
                           console.log("Загруженные поля:", fields); // Проверяем

                           if (fields.length > 0) {
                               let collapseButton = document.createElement('button');
                               collapseButton.className = 'btn btn-primary mb-2';
                               collapseButton.setAttribute('type', 'button');
                               collapseButton.setAttribute('id', 'toggleFields'); // Устанавливаем ID
                               collapseButton.textContent = 'Показать характеристики';
                               container.appendChild(collapseButton);

                               let collapseDiv = document.createElement('div');
                               collapseDiv.className = 'collapse';
                               collapseDiv.id = 'categoryFieldsCollapse';
                               container.appendChild(collapseDiv);

                               fields.forEach(field => {
                                   let formGroup = document.createElement('div');
                                   formGroup.classList.add('form-group', 'mb-2');

                                   let label = document.createElement('label');
                                   label.textContent = field.label;
                                   label.setAttribute('for', field.name);
                                   formGroup.appendChild(label);

                                   let input;
                                   if (field.type === 'checkbox') {
                                       input = document.createElement('input');
                                       input.type = 'checkbox';
                                       input.className = 'form-check-input';
                                   } else if (field.type === 'textarea') {
                                       input = document.createElement('textarea');
                                       input.className = 'form-control';
                                   } else {
                                       input = document.createElement('input');
                                       input.type = field.type;
                                       input.className = 'form-control';
                                   }

                                   input.name = field.name;
                                   input.id = field.name;
                                   formGroup.appendChild(input);
                                   collapseDiv.appendChild(formGroup);
                               });

                               // Добавляем обработчик клика
                               document.getElementById('toggleFields').addEventListener('click', function () {
                                   let collapseEl = document.getElementById('categoryFieldsCollapse');
                                   let bsCollapse = new bootstrap.Collapse(collapseEl, {
                                       toggle: true
                                   });
                               });
                           }
                       })
                       .catch(error => console.error("Ошибка запроса:", error));
               }
           });

           $(document).ready(function () {
               $('#category_id, #brand_id').select2({
                   width: '100%',
                   placeholder: "Select an option",
                   theme: 'bootstrap-4',
                   allowClear: true
               });
           });
       });
   </script>
@endpush
