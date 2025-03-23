@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Админская панель</h1>
        <p>Привет, {{ auth()->user()->name }}!</p>

        @role('super_admin')
        <a href="#" class="btn btn-primary">Управление пользователями</a>
        @endrole

        @role('admin')
        <a href="#" class="btn btn-success">Управление постами</a>
        @endrole

    </div>
@endsection
