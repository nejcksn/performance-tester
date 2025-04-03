@extends('adminlte::page')

@section('title', 'Performance Tests')

@section('content_header')
    <h1>Run Performance Tests</h1>
@stop

@section('content')
    <form id="testForm" method="POST">
        @csrf
        <div class="form-group">
            <label for="model">Data:</label>
            <select name="model" id="model" class="form-control" required>
                <option value=""> </option>
                @foreach($models as $model)
                    <option value="{{ $model }}">{{ $model }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Test Type:</label>
            <select name="type" id="type" class="form-control">
                <option value=""></option>
                <option value="create">Create</option>
                <option value="read">Read</option>
                <option value="read_chunk">Read with Chunk</option>
                <option value="read_cursor">Read with Cursor</option>
                <option value="cache">Read with Cache</option>
                <option value="update">Update</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div class="form-group">
            <label for="limit">Number of Records:</label>
            <input type="number" name="limit" id="limit" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="runs">Number of Runs:</label>
            <input type="number" name="runs" id="runs" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Run Test</button>
    </form>
@stop

@section('js')
    <script>
        document.getElementById('type').addEventListener('change', function() {
            var form = document.getElementById('testForm');
            var testType = this.value;

            if (testType === 'create') {
                form.action = "{{ route('admin.performance_test.create') }}";
            } else if (testType === 'read') {
                form.action = "{{ route('admin.performance_test.read') }}";
            } else if (testType === 'read_chunk') {
                form.action = "{{ route('admin.performance_test.read_chunk') }}";
            } else if (testType === 'read_cursor') {
                form.action = "{{ route('admin.performance_test.read_cursor') }}";
            } else if (testType === 'cache') {
                form.action = "{{ route('admin.performance_test.read_cache') }}";
            } else if (testType === 'update') {
                form.action = "{{ route('admin.performance_test.update') }}";
            } else if (testType === 'delete') {
                form.action = "{{ route('admin.performance_test.delete') }}";
            }
        });
    </script>
    <script>
        document.getElementById('type').addEventListener('change', function() {
            if (this.value === 'update') {
                document.getElementById('updateData').style.display = 'block';
            } else {
                document.getElementById('updateData').style.display = 'none';
            }
        });
    </script>
@stop
