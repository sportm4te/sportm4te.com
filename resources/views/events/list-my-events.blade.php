@extends('layouts.app')
@section('title', 'My events')

@section('title_html')
    <h1>My events</h1>
@endsection

@section('content')
    <div class="card card-style">
        <div class="content mb-0 mt-3" id="events">
            <div class="tab-controls tabs-small tabs-rounded" data-highlight="bg-highlight">
                <a href="#" data-active="" data-bs-toggle="collapse" data-bs-target="#hosting" class="collapsed" aria-expanded="false">Hosting</a>
                <a href="#" data-bs-toggle="collapse" data-bs-target="#upcoming" aria-expanded="false" class="collapsed">Upcoming</a>
                <a href="#" data-bs-toggle="collapse" data-bs-target="#going" aria-expanded="false" class="collapsed">Going</a>
                <a href="#" data-bs-toggle="collapse" data-bs-target="#past-events" aria-expanded="false" class="collapsed">Past Events</a>
            </div>
            <div class="clearfix mb-4"></div>
            <div data-bs-parent="#events" class="collapse show" id="hosting">
                @if($hosting->isNotEmpty() || $hosted->isNotEmpty())
                    @foreach($hosting as $event)
                        <div class="d-flex mb-4">
                            <div class="align-self-center">
                                <img src="{{ $event->image() }}" class="rounded-sm object-fit-cover me-3" width="70" height="70">
                            </div>
                            <div class="align-self-center">
                                <p class="color-highlight font-11 mb-n2"><a href="{{ $event->category->search() }}" class="text-muted">{{ $event->category->name }}</a></p>
                                <a href="{{ $event->link() }}">
                                    <h2 class="font-15 line-height-s mt-1 mb-1">
                                        {{ $event->name }}
                                        @if($event->recurring)
                                            <span class="badge bg-success font-11 ms-1">Recurring <i class="fa fa-redo ps-1"></i></span>
                                        @endif
                                    </h2>
                                </a>
                                <p class="font-600 color-highlight mb-n1">{{ $event->formatDate() }}</p>
                                <span><i class="fa fa-map-marker"></i> {{ $event->location }}</span>
                            </div>
                            <div class="ms-auto ps-3 align-self-center text-center">
                                <a href="{{ $event->edit() }}" class="btn py-1 px-2 font-600 rounded-s gradient-highlight text-white">
                                    <i class="fa fa-pen"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach

                    @if($hosted->isNotEmpty())
                        <h2>Hosted events</h2>
                        @foreach($hosted as $event)
                            <div class="d-flex mb-4">
                                <div class="align-self-center">
                                    <img src="{{ $event->image() }}" class="rounded-sm object-fit-cover me-3" width="70" height="70">
                                </div>
                                <div class="align-self-center">
                                    <p class="color-highlight font-11 mb-n2"><a href="{{ $event->category->search() }}" class="text-muted">{{ $event->category->name }}</a></p>
                                    <a href="{{ $event->link() }}">
                                        <h2 class="font-15 line-height-s mt-1 mb-1">
                                            {{ $event->name }}
                                            @if($event->recurring)
                                                <span class="badge bg-success font-11 ms-1">Recurring <i class="fa fa-redo ps-1"></i></span>
                                            @endif
                                        </h2>
                                    </a>
                                    <p class="font-600 color-highlight mb-n1">{{ $event->formatDate() }}</p>
                                    <span><i class="fa fa-map-marker"></i> {{ $event->location }}</span>
                                </div>
                                <div class="ms-auto ps-3 align-self-center text-center">
                                    <a href="{{ $event->edit() }}" class="btn py-1 px-2 font-600 rounded-s gradient-highlight text-white">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @else
                    <p class="boxed-text-l mb-4">Events you're hosting will appear here.
                        Get started by creating a new event.
                    </p>
                    <a class="btn btn-margins btn-full mb-2 gradient-highlight font-13 btn-m font-600 rounded-s" href="{{ route('events.make') }}">Create new event</a>

                @endif
            </div>
            <div data-bs-parent="#events" class="collapse" id="upcoming">
                @forelse($upcoming->pluck('event') as $event)
                    <div class="d-flex mb-4">
                        <div class="align-self-center">
                            <img src="{{ $event->image() }}" class="rounded-sm object-fit-cover me-3" width="70" height="70">
                        </div>
                        <div class="align-self-center">
                            <p class="color-highlight font-11 mb-n2"><a href="{{ $event->category->search() }}" class="text-muted">{{ $event->category->name }}</a></p>
                           <a href="{{ $event->link() }}"> <h2 class="font-15 line-height-s mt-1 mb-1">{{ $event->name }}</h2></a>
                            <p class="font-600 color-highlight mb-n1">{{ $event->formatDate() }}</p>
                            <span><i class="fa fa-map-marker"></i> {{ $event->location }}</span>
                        </div>
                        <div class="ms-auto ps-3 align-self-center text-center">
                        </div>
                    </div>
                    @empty
                        <p class="boxed-text-l mb-4">
                            You don't have any events coming up.
                        </p>
                    @endforelse
            </div>

            <div data-bs-parent="#events" class="collapse" id="going">
                @forelse($going->pluck('event') as $event)
                    <div class="d-flex mb-4">
                        <div class="align-self-center">
                            <img src="{{ $event->image() }}" class="rounded-sm object-fit-cover me-3" width="70" height="70">
                        </div>
                        <div class="align-self-center">
                            <p class="color-highlight font-11 mb-n2"><a href="{{ $event->category->search() }}" class="text-muted">{{ $event->category->name }}</a></p>
                            <a href="{{ $event->link() }}">
                            <h2 class="font-15 line-height-s mt-1 mb-1">{{ $event->name }}</h2></a>
                            <p class="font-600 color-highlight mb-n1">{{ $event->formatDate() }}</p>
                            <span><i class="fa fa-map-marker"></i> {{ $event->location }}</span>
                        </div>
                        <div class="ms-auto ps-3 align-self-center text-center">
                        </div>
                    </div>
                @empty
                    <p class="boxed-text-l mb-4">
                        Events you're going to will appear here.
                    </p>
                @endforelse
            </div>
            <div data-bs-parent="#events" class="collapse" id="past-events">
                @forelse($pastEvents->pluck('event') as $event)
                    <div class="d-flex mb-4">
                        <div class="align-self-center">
                            <img src="{{ $event->image() }}" class="rounded-sm object-fit-cover me-3" width="70" height="70">
                        </div>
                        <div class="align-self-center">
                            <p class="color-highlight font-11 mb-n2"><a href="{{ $event->category->search() }}" class="text-muted">{{ $event->category->name }}</a></p>
                            <a href="{{ $event->link() }}"><h2 class="font-15 line-height-s mt-1 mb-1">{{ $event->name }}</h2></a>
                            <p class="font-600 color-highlight mb-n1">{{ $event->formatDate() }}</p>
                            <span><i class="fa fa-map-marker"></i> {{ $event->location }}</span>
                        </div>
                        <div class="ms-auto ps-3 align-self-center text-center">
                        </div>
                    </div>
                @empty
                    <p class="boxed-text-l mb-4">
                        Events you're passed to will appear here.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
