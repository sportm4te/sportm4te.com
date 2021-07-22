@extends('layouts.app')

@section('title', 'Edit Event')

@section('title_html')
    <h1>Edit Event</h1>
@endsection


@section('content')
    @include('components.errors')
    @include('events.management')

    <form action="{{ route('api.events.remove', [$event->id]) }}" data-hook="event-removed">
        <div class="d-flex flex-column">
            {{ html()->div('Delete event')->class('btn btn-margins btn-full gradient-red font-13 btn-m font-600 rounded-s')->attribute('data-menu', 'menu-option-2')}}
        </div>
        <div id="menu-option-2" class="menu menu-box-bottom rounded-m" data-menu-height="320" data-menu-effect="menu-over">
            <h1 class="text-center mt-4"><i class="fa fa-3x fa-info-circle scale-box color-blue-dark shadow-xl rounded-circle"></i></h1>
            <h3 class="text-center mt-3 font-700">Are you sure?</h3>
            <p class="boxed-text-xl opacity-70">
                If you delete your event, you won't be able to access it again.
            </p>
            <div class="row mb-0 me-3 ms-3">
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m color-red-dark border-red-dark font-600 rounded-s">Cancel</a>
                </div>
                <div class="col-6 d-flex flex-column">
                    <button class="btn close-menu btn-full btn-m color-green-dark border-green-dark font-600 rounded-s">Delete</button>
                </div>
            </div>
        </div>
    </form>

@endsection
