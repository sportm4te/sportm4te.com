@extends('layouts.app')

@section('title', 'Dashboard')

@section('title_html')
    <div>
        <h1 class="font-16 color-highlight mb-n3">Welcome Back</h1>
        <h1 class="font-18">{{ $name }}</h1>
    </div>
@endsection

@section('content')
    <div id="stacked-cards-block" class="stackedcards stackedcards--animatable init">
        <div class="stackedcards-container">
            @foreach($eventResponses as $eventResponse)
                @php
                    $height = 155;

                    if ($eventResponse->isApproved()) {
                        $height = 190;
                    }
                @endphp
                <div class="card card-style" style="background-image: url({{ $eventResponse->event->image() }}); height: {{ $height }}px;" data-id="{{ $eventResponse->id }}">
                    <div class="card-top pt-3">
                        <div class="ps-3">
                            <h2 class="color-white pt-3 pb-3">
                                @if($eventResponse->isApproved())
                                    <i class="fa fa-check rounded-xl bg-green-dark color-green1-dark font-13 icon-badge"></i>
                                    Your request has been approved
                                @else
                                    <i class="fa fa-times bg-red-dark rounded-xl color-red2-dark font-13 icon-badge"></i>
                                    Your request hasn't been approved
                                @endif
                            </h2>
                            <p class="font-600 color-highlight mb-n1">{{ $eventResponse->event->name }}</p>
                            <p class="color-white"><i class="fa fa-map-marker color-white pe-2"></i> {{ $eventResponse->event->location }}
                            </p>
                        </div>
                    </div>
                    @if($eventResponse->isApproved())
                        <div class="card-bottom ps-3 mb-3 pb-1">
                            <h4 class="color-white opacity-50 font-14"><i
                                    class="fa fa-user pe-2"></i> {{ $eventResponse->event->formatRegistrations() }}</h4>
                        </div>
                        <div class="card-bottom pe-3 mb-3">
                            <div class="float-end">
                                <a href="{{ $eventResponse->event->link() }}" class="btn btn-s bg-white color-black font-600 rounded-m">Get directions</a>
                            </div>
                        </div>
                    @endif

                    <div class="card-overlay bg-black opacity-70"></div>
                </div>
            @endforeach
        </div>

        <div class="stackedcards--animatable stackedcards-overlay right">
            <div>
                <i class="fa fa-archive text-danger fa-3x"></i>
                <div class="font-23 ms-2">Hide notification</div>
            </div>
        </div>
        <div class="stackedcards--animatable stackedcards-overlay left">
            <div>
                <i class="fa fa-bell text-warning fa-3x"></i>
                <div class="font-23 ms-2">Snooze notification</div>
            </div>
        </div>
        <div class="card card-style final-state justify-content-center disabled" style="min-height: 190px">
            <div class="content text-center font-20">
                <div class="fa-2x mb-3">
                    <i class="fa fa-star text-warning"></i>
                </div>
                Great! You've seen all the notifications.
            </div>
        </div>
    </div>
    @foreach($eventRequests as $eventRequest)
        <form class="card card-style" style="background-image: url({{ $eventRequest->event->image() }}); height: 270px;"
              data-card-height="270" action="{{ route('api.events.join.request', $eventRequest->event_id) }}"
              method="post" data-hook="join-request-update">
            <div class="card rounded-0 shadow-xl" data-card-height="cover"
                 style="width: 100px; z-index: 99; height: 270px;">
                <div class="card-center text-center">
                    <a href="{{ $eventRequest->user->link() }}"><img src="{{ $eventRequest->user->image() }}"
                                                                     class="rounded-circle object-fit-cover mb-3"
                                                                     width="70" height="70"></a>
                    <h1 class="font-28 text-uppercase font-900 opacity-30">{{ $eventRequest->created_at->format('D') }}</h1>
                    <h1 class="font-24 font-900">{{ $eventRequest->created_at->format('jS') }}</h1>
                </div>
            </div>
            <div class="card-top ps-5 ms-5 pt-3">
                <div class="ps-4">
                    <h2 class="color-white pt-3 pb-3">{{ $eventRequest->user->formatName() }} asked to attend the
                        event {{ $eventRequest->event->name }}. </h2>
                    <p class="font-600 color-highlight mb-n1">{{ $eventRequest->event->formatStart() }}</p>
                    <p class="color-white"><i
                            class="fa fa-map-marker color-white pe-2"></i> {{ $eventRequest->event->location }}</p>
                    <input type="hidden" name="user_id" value="{{ $eventRequest->user_id }}">
                    <button name="action" value="1" class="btn btn-m bg-white color-black font-700">Accept</button>
                    <button name="action" value="0" class="btn btn-m border-white color-white font-700 ms-3">Decline
                    </button>
                </div>
            </div>
            <div class="card-overlay bg-black opacity-70"></div>
        </form>
    @endforeach

    @foreach($friendRequests as $friendRequest)
        <form class="card card-style" action="{{ route('api.friends.request-respond', [$friendRequest->user_id]) }}"
              method="post" data-hook="friend-request-respond">
            <div class="content text-center">
                <a href="{{ $friendRequest->requester->link() }}">
                    <img src="{{ $friendRequest->requester->image() }}" class="mx-auto rounded-circle shadow-xl"
                         width="150" height="150">
                    <h1 class="mt-4 font-20 font-700 mb-n1">{{ $friendRequest->requester->name }}</h1>
                </a>
                <span>
                    <p class="font-10 mb-2">{{ $friendRequest->created_at->format('jS F Y') }}</p>
                        <button name="action" value="confirm"
                                class="mt-3 ms-2 btn btn-xs font-600 btn-border border-highlight color-highlight">
                            <i class="fa fa-user-times"></i>
                            Confirm Request
                        </button>
                        <button name="action" value="remove"
                                class="mt-3 ms-2 btn btn-xs font-600 btn-border border-danger text-danger">
                            <i class="fa fa-user-times"></i>
                            Remove Request
                        </button>
                </span>
            </div>
        </form>
    @endforeach

    <div class="content mb-0 mt-3">
        <div class="row mb-0">
            <div class="col-6 pe-1">
                <div class="card card-style mx-0 mb-2 p-3">
                    <h6 class="font-14">Total events</h6>
                    <h3 class="color-green-dark mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="col-6 ps-1">
                <div class="card card-style mx-0 mb-2 p-3">
                    <h6 class="font-14">Total registrations</h6>
                    <h3 class="color-red-dark mb-0">{{ $stats['accept'] }}</h3>
                </div>
            </div>
            <div class="col-6 pe-1">
                <div class="card card-style mx-0 p-3">
                    <h6 class="font-14">Waiting events</h6>
                    <h3 class="color-brown-dark mb-0">{{ $stats['waiting'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    @foreach($upcomingEvent->pluck('event') as $event)
        <div class="card card-style" data-card-height="350"
             style="height: 350px;background-image: url({{ $event->image() }})">
            <div class="card-center text-end pe-3 me-2">
                <h1 class="color-white font-40 mb-4">Calendar</h1>
                <h1 class="color-white font-20 line-height-l mb-4">
                    {{ $event->name }}<br>
                    <span class="opacity-30">at</span> {{ $event->location }}<br>
                    <span class="opacity-30">in</span> {{ $event->start->diffForHumans() }}
                </h1>
                <a href="{{ $event->link() }}" class="btn btn-m rounded-s font-600 ms-3 bg-highlight">Get Directions</a>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
        </div>
    @endforeach
@endsection


@section('after:scripts')
    <script>
        sportM4te.stackedCards();
    </script>
@endsection
