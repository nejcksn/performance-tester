@extends('adminlte::page')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('title', 'Test Performance Graph')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Performance Test Graph</h1>
        <a href="{{ route('admin.test_results.index') }}" class="btn btn-primary mt-3">Back</a>
    </div>
@endsection

@section('content')
    <div id="chart-container">
        <canvas id="performanceChart"></canvas>
    </div>
@stop

@section('js')
{{--    <script>--}}
{{--        document.addEventListener("DOMContentLoaded", function () {--}}
{{--            var ctx = document.getElementById("performanceChart").getContext("2d");--}}

{{--            var labels = {!! json_encode($labels) !!};--}}
{{--            var datasets = [];--}}

{{--            @if(count($minTimes))--}}
{{--            datasets.push({--}}
{{--                label: "Min Time (seconds)",--}}
{{--                data: {!! json_encode($minTimes) !!},--}}
{{--                backgroundColor: "rgba(75, 192, 192, 0.5)",--}}
{{--                borderColor: "rgba(75, 192, 192, 1)",--}}
{{--                borderWidth: 1,--}}
{{--            });--}}
{{--            @endif--}}

{{--            @if(count($avgTimes))--}}
{{--            datasets.push({--}}
{{--                label: "Avg Time (seconds)",--}}
{{--                data: {!! json_encode($avgTimes) !!},--}}
{{--                backgroundColor: "rgba(54, 162, 235, 0.5)",--}}
{{--                borderColor: "rgba(54, 162, 235, 1)",--}}
{{--                borderWidth: 1,--}}
{{--            });--}}
{{--            @endif--}}

{{--            @if(count($maxTimes))--}}
{{--            datasets.push({--}}
{{--                label: "Max Time (seconds)",--}}
{{--                data: {!! json_encode($maxTimes) !!},--}}
{{--                backgroundColor: "rgba(255, 99, 132, 0.5)",--}}
{{--                borderColor: "rgba(255, 99, 132, 1)",--}}
{{--                borderWidth: 1,--}}
{{--            });--}}
{{--            @endif--}}

{{--            var chart = new Chart(ctx, {--}}
{{--                type: "bar",--}}
{{--                data: { labels: labels, datasets: datasets },--}}
{{--                options: {--}}
{{--                    responsive: true,--}}
{{--                    maintainAspectRatio: false,--}}
{{--                    scales: {--}}
{{--                        x: {--}}
{{--                            ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 },--}}
{{--                        },--}}
{{--                        y: { min: 0, ticks: { beginAtZero: true } },--}}
{{--                    },--}}
{{--                },--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById("performanceChart").getContext("2d");

            var labels = {!! json_encode($labels) !!};
            var datasets = [];

            @if(count($minTimes))
            datasets.push({
                label: "Min Time (seconds)",
                data: {!! json_encode($minTimes) !!},
                backgroundColor: "rgba(75, 192, 192, 0.5)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
            });
            @endif

            @if(count($avgTimes))
            datasets.push({
                label: "Avg Time (seconds)",
                data: {!! json_encode($avgTimes) !!},
                backgroundColor: "rgba(54, 162, 235, 0.5)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1,
            });
            @endif

            @if(count($maxTimes))
            datasets.push({
                label: "Max Time (seconds)",
                data: {!! json_encode($maxTimes) !!},
                backgroundColor: "rgba(255, 99, 132, 0.5)",
                borderColor: "rgba(255, 99, 132, 1)",
                borderWidth: 1,
            });
            @endif

            var isMobile = window.innerWidth < 600;

            var chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels.map(label => isMobile ? label.substring(0, 5) + "…" : label),
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                display: !isMobile, // Скрываем подписи на маленьких экранах
                                autoSkip: false,
                                maxRotation: isMobile ? 45 : 0,
                                minRotation: isMobile ? 45 : 0,
                            },
                        },
                        y: {
                            min: 0,
                            ticks: { beginAtZero: true },
                        },
                    },
                },
            });
        });
    </script>

@endsection
