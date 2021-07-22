@extends('layouts.app')

@section('title', 'Create Event')

@section('title_html')
    <h1>Create Event</h1>
@endsection

@section('content')
    @include('components.errors')
    @include('events.management')
@endsection
