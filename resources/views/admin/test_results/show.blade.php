@extends('adminlte::page')

@section('title', 'Test Results: ' . $testCase->name)

@section('content_header')
    <h1>Test Results: {{ $testCase->name }}</h1>
@stop

@section('content')
    <p>{{ $testCase->description }}</p>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Test Results</h3>
            @if($testResults->test_count > 1)
                <div class="ml-auto btn-group">
                    <a href="{{ route('admin.test_results.show', ['testCase' => $testCase, 'view' => 'overall']) }}"
                       class="btn btn-outline-primary {{ request('view', 'overall') === 'overall' ? 'active' : '' }}">
                        Overall
                    </a>
                    <a href="{{ route('admin.test_results.show', ['testCase' => $testCase, 'view' => 'detail']) }}"
                       class="btn btn-outline-primary {{ request('view') === 'detail' ? 'active' : '' }}">
                        Detail
                    </a>
                </div>
            @endif
        </div>

        <div class="card-body">
            @if($view === 'overall')
                <strong>Execution Time: </strong> {!!  $testResults->test_count == 1 ? $testResults->avg_time . ' seconds' . '<br>' : '' !!}
                @if($testResults->test_count > 1)
                    <ul class="list-group">
                        <li class="list-group-item">Fastest: {{ $testResults->min_time }} seconds</li>
                        <li class="list-group-item">Average: {{ $testResults->avg_time }} seconds</li>
                        <li class="list-group-item">Longest: {{ $testResults->max_time }} seconds</li>
                    </ul>
                @endif
                <strong>Test Count:</strong> {{ $testResults->test_count }}
                <br>
                <strong>Record Count:</strong> {{ $testResults->record_count }}
                <br>
                <strong>Date:</strong> {{ $testResults->created_at }}
            @elseif($view === 'detail')
                @foreach($testExecutions as $index => $execution)
                    <div class="card">
                        <div class="card-body">
                            <strong>{{ $loop->iteration }}. Execution Time:</strong> {{ $execution->execution_time }} seconds
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <a href="{{ route('admin.test_results.index') }}" class="btn btn-primary mt-3">Test Results list</a>
    <a href="{{ route('admin.performance_test.index') }}" class="btn btn-primary mt-3">Take a new Test</a>
@stop
