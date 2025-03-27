@extends('adminlte::page')

@section('title', 'Test Results')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Performance Test Results</h1>
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#graphModal">
            <i class="fas fa-chart-bar"></i> Build a Graph
        </button>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @if($testResults->isEmpty())
                    <p>No test results found.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2">Test Case</th>
                            <th rowspan="2">Test Count</th>
                            <th colspan="3" class="text-center">Time (seconds)</th>
                            <th rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th>Fastest</th>
                            <th>Average</th>
                            <th>Longest</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($testResults as $result)
                            <tr>
                                <td>{{ $result->testCase->description }}</td>
                                <td>{{ $result->test_count }}</td>
                                @if($result->test_count == 1)
                                    <td colspan="3" class="text-center">{{ $result->avg_time }}</td>
                                @else
                                    <td>{{ $result->min_time }}</td>
                                    <td>{{ $result->avg_time }}</td>
                                    <td>{{ $result->max_time }}</td>
                                @endif
                                <td>
                                    <a href="{{ route('admin.test_results.show', ['testCase' => $result]) }}" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="graphModal" tabindex="-1" aria-labelledby="graphModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="graphModalLabel">Select Test Results</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="graphForm" action="{{ route('admin.test_results.graph') }}" method="GET">
                        <div class="form-group">
                            <label for="testResults">Select Test Results:</label>
                            <select id="testResults" name="testResults[]" class="form-control" multiple required>
                                @foreach($testResults as $result)
                                    <option value="{{ $result->id }}">[{{ $result->created_at }}] {{ $result->testCase->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Data Types:</label>
                            <div class="d-flex justify-content-between">
                                <div class="form-check flex-grow-1 text-center">
                                    <input class="form-check-input" type="checkbox" name="dataTypes[]" value="min_time" id="minTimeCheckbox">
                                    <label class="form-check-label" for="minTimeCheckbox">Fastest Time</label>
                                </div>
                                <div class="form-check flex-grow-1 text-center">
                                    <input class="form-check-input" type="checkbox" name="dataTypes[]" value="avg_time" id="avgTimeCheckbox" checked>
                                    <label class="form-check-label" for="avgTimeCheckbox">Average Time</label>
                                </div>
                                <div class="form-check flex-grow-1 text-center">
                                    <input class="form-check-input" type="checkbox" name="dataTypes[]" value="max_time" id="maxTimeCheckbox">
                                    <label class="form-check-label" for="maxTimeCheckbox">Longest Time</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Show Graph</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#testResults').select2({
                width: '100%',
                placeholder: "Select test results",
                allowClear: true
            });
        });
    </script>
@endsection
