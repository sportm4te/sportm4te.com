@extends('layouts.app')

@section('title', 'Profile')

@section('title_html')
    <h1>Profile</h1>
@endsection

@section('content')
    <div class="mb-4">
        <div class="divider mb-4"></div>
        <div class="d-flex content mt-0 mb-1">

            <div>
                <img src="{{ $user->image() }}" data-src="{{ $user->image() }}" width="85" height="85" class="rounded-circle me-3 shadow-xl preload-img entered loaded" data-ll-status="loaded">
            </div>

            <div class="flex-grow-1">
                <h2>{{ $user->formatName() }}</h2>
                @if($user->id === auth()->id())
                    <a href="{{ route('settings') }}" class="mt-2 btn btn-xs font-600 btn-border border-highlight color-highlight">
                        <i class="fa fa-cog"></i>
                        Update Account
                    </a>
                @elseif($user->requestReceived(auth()->user()))
                    <form action="{{ route('api.friends.request-respond', [$user->id]) }}" data-hook="friend-request-respond">
                        <button name="action" value="confirm" class="mt-2 btn btn-xs font-600 btn-border border-highlight color-highlight">
                            <i class="fa fa-user-times"></i>
                            Confirm Request
                        </button>
                        <button name="action" value="remove" class="mt-2 ms-2 btn btn-xs font-600 btn-border border-danger text-danger">
                            <i class="fa fa-user-times"></i>
                            Remove Request
                        </button>
                    </form>
                @elseif($user->isFriends(auth()->user()))
                    <a href="#" data-menu="remove-friend" class="mt-2 btn btn-xs font-600 btn-border border-highlight color-highlight">
                            <i class="fa fa-user"></i>
                            <i class="font-11 fa fa-check"></i>
                    </a>
                @elseif($user->requestSent(auth()->user()))
                    <form action="{{ route('api.friends.request-respond', [$user->id]) }}" data-hook="basic-response-reload">
                        <button name="action" value="remove" class="mt-2 btn btn-xs font-600 btn-border border-danger text-danger">
                            <i class="fa fa-user-times"></i>
                            Cancel Request
                        </button>
                    </form>
                @else
                    <form action="{{ route('api.friends.request', [$user->id]) }}" data-hook="basic-response-reload">
                        <button class="mt-2 btn btn-xs font-600 btn-border border-highlight color-highlight">
                        <i class="fa fa-user-plus"></i>
                        Add Friend
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @if($user->bio)
        <div class="content">
            <p class="mb-n3">{{ $user->bio }}</p><br>
        </div>
        @endif
        @if($user->sports->isNotEmpty())
            <div class="splide story-slider slider-no-dots mb-4" id="story-slider">
                <div class="splide__track">
                    <div class="splide__list">
                        @foreach($user->sports->pluck('sport') as $sport)
                            <div class="splide__slide text-center">
                                <a data-menu="menu-story" href="{{ $sport->search() }}">
                                    <img src="{{ $sport->image() }}" width="60" height="60" class="rounded-circle mx-auto mb-n4 border border-m">
                                    <br><span class="d-block pt-2 font-12 color-theme opacity-60">{{ $sport->name }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="divider mb-2"></div>
        <div class="row mb-2 text-center">
            <div class="col-4">
                <h6 class="mb-0 color-theme">{{ $user->friends()->count() }}</h6>
                Friends
            </div>
            <div class="col-4">
                <h6 class="mb-0 color-theme">{{ $user->hosting->count() }}</h6>
                Events
            </div>
            <div class="col-4">
                <h6 class="mb-0 color-theme">{{ $user->going()->count() }}</h6>
                Joined Events
            </div>
        </div>
        <div class="divider mb-3"></div>
        @if($canAddReview)
            @php
                $review = $user->reviews->firstWhere('author_id', auth()->user()->id);
            @endphp
            <div class="card card-style">
                <form class="content text-center" id="user-review" action="{{ route('api.user.review', [$user->id]) }}" data-hook="basic-response">
                    <h1>My Review</h1>
                    <img src="{{ auth()->user()->image() }}" class="mx-auto rounded-circle shadow-xl" width="150">
                    <h1 class="mt-4 font-20 font-700 mb-n1">{{ auth()->user()->formatName() }}</h1>
                    <span>
                        @foreach(range(1, 5) as $star)
                            <i class="fa fa-star font-18 {{ ((($review->stars ?? 5) >= $star) ? 'color-yellow-dark' : 'color-dark-dark') }}"></i>
                        @endforeach
                        <input type="hidden" name="rating" id="rating" value="{{ $review->stars ?? 0 }}">
                        <textarea class="line-height-l boxed-text-xl font-14 pb-3 border-0" name="review" placeholder="Wrote Review to this User here... (optional)">{{ $review->review ?? null }}</textarea>
                        <button class="btn btn-full btn-s font-600 rounded-s gradient-highlight mt-1 m-auto" {{ ((!$review) ? 'disabled' : '') }}>Save Review</button>
                    </span>
                </form>
            </div>
        @endif

        @if($user->reviews->isNotEmpty())
            <div class="card card-style">
                <div class="content text-center">
                    <span>
                        @php($rating=$user->reviews->avg('stars'))
                        @foreach(range(1, 5) as $star)
                            <i class="fa fa-star font-18 {{ (($rating >= $star) ? 'color-yellow-dark' : 'color-dark-dark') }}"></i>
                        @endforeach
                    </span>
                    <br>{{ $rating }}, based on {{ $user->reviews->count() }} reviews
                </div>
            </div>
            @foreach($user->reviews as $review)
                <div class="card card-style">
                    <div class="content">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span>
                                    @foreach(range(1, 5) as $star)
                                        <i class="fa fa-star {{ (($review->stars >= $star) ? 'color-yellow-dark' : 'color-dark-dark') }}"></i>
                                    @endforeach
                                </span>
                            </div>
                            <div>
                                <img src="{{ $review->author->image() }}" class="me-2 rounded-xl" width="30">
                            </div>
                            <div>
                                <h6 class="mb-0 text-end">{{ $review->author->formatName() }}</h6>
                                <p class="font-10 text-end">{{ $review->created_at->format('jS F Y') }}</p>
                            </div>
                        </div>
                        @if(!empty($review->review))
                            <p class="mt-2">
                                {{ $review->review }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        <div class="card card-style">
            <div class="content mb-0 mt-3" id="events">
                <div class="tab-controls tabs-small tabs-rounded" data-highlight="bg-highlight">
                    <a href="#" data-active="" data-bs-toggle="collapse" data-bs-target="#public" class="collapsed" aria-expanded="false"><i class="fa fa-globe"></i> Public Events</a>
                    @if($user->id === auth()->id() || $user->isFriends(auth()->user()))
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#private" aria-expanded="false" class="collapsed"><i class="fa fa-lock"></i> Private Events</a>
                    @endif
                </div>
                <div class="clearfix mb-4"></div>
                <div data-bs-parent="#events" class="collapse show" id="public">
                    @forelse($user->hosting->where('privacy', \App\Models\User\Event::PRIVACY_PUBLIC) as $event)
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
                            @if($user->id === auth()->id())
                                You don't have any public events.
                            @else
                                User don't have any public events.
                            @endif
                        </p>
                    @endforelse
                </div>
                @if($user->id === auth()->id() || $user->isFriends(auth()->user()))
                    <div data-bs-parent="#events" class="collapse" id="private">
                        @forelse($user->hosting->where('privacy', \App\Models\User\Event::PRIVACY_PRIVATE) as $event)
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
                                @if($user->id === auth()->id())
                                    You don't have any private events.
                                @else
                                    User don't have any private events.
                                @endif
                            </p>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('after:content')
    <div id="remove-friend" class="menu menu-box-modal rounded-m" data-menu-width="300" data-menu-height="380">
        <form class="text-center" action="{{ route('api.friends.remove', [$user->id]) }}" data-hook="basic-response-reload">
            <img src="{{ $user->image() }}" width="150" height="150" class="mx-auto mt-4 rounded-circle">
            <p class="text-center font-15 mt-4">Remove <strong>{{ $user->formatName() }}</strong> from friends?</p>
            <div class="divider mb-0"></div>
            <button class="color-red-dark font-15 font-600 text-center py-3 d-block w-100">Remove</button>
            <div class="divider mb-0"></div>
            <a href="#" class="close-menu color-theme font-15 text-center py-3 d-block">Cancel</a>
        </form>
    </div>
@endsection

@section('after:scripts')
    <script>
        sportM4te.review();
    </script>
@endsection
