@extends('adminlte::page')

@section('title', 'Admin Panel')

@section('content_header')
    <h1>Welcome to the Admin Panel</h1>
@stop

@section('content')
    <p>This is the main page of the admin panel.</p>
    @role('super_admin')
    <p>You are a super admin.</p>
    @endrole
@stop

