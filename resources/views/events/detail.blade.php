@extends('layouts.app')

@section('title', 'Event')

@section('title_html')
    <h1>Event</h1>
@endsection

@section('content')
    @include('events.components.event-card')
    @if($event->isOwner() || $event->registered())
        <div class="card card-style">
            <div class="card mx-0" data-card-height="120" style="height: 120px;">
                @if($event->membersWithoutTeam() && $event->isOwner())
                <div class="card-center" style="z-index: 5">
                    <a class="external-link float-end btn btn-xs rounded-xl text-uppercase font-900 me-3 bg-white color-black" data-menu="create_team">Create team</a>
                </div>
                @endif
                <div class="card-center ms-3 ps-1">
                    <h1 class="font-20 color-white mb-n1">Game Score</h1>
                    <p class="color-white opacity-90 mb-0">
                        @if($event->isOwner())
                            Enter the score of your teammates.
                        @else
                            Here you will see score of this match.
                        @endif
                    </p>
                </div>
                <div class="card-overlay rounded-0 bg-blue-dark"></div>
            </div>
            <div class="content mt-n4 mb-0">
                @foreach($members as $member)
                        @if($member instanceof \App\Models\Event\Team)
                    <div class="cal-schedule">
                        <em class="text-center" style="z-index: 5;">
                            @if($member->score)
                                <div class="text-warning">{{ $member->score->formatScore() }}</div>
                                @if($event->isOwner())
                                <div data-menu="score_team_{{ $member->id }}"><i class="fa fa-pen"></i> Edit Score</div>
                                @endif
                            @elseif($event->isOwner())
                                <div data-menu="score_team_{{ $member->id }}"><i class="fa fa-plus"></i><br>Add Score</div>
                            @else
                                N/A score
                            @endif
                        </em>
                        <strong>{{ $member->name }} <span class="badge bg-transparent border border-red-dark color-red-dark ms-2 d-inline-block">TEAM</span></strong>
                        <span><i class="fa fa-users"></i>{!! $member->formatMembers() !!}</span>
                    </div>
                    @else
                        <div class="cal-schedule">
                            <em class="text-center" style="z-index: 5;">
                                @if($member->score)
                                    <div class="text-warning">{{ $member->score->formatScore() }}</div>
                                    @if($event->isOwner())
                                    <div data-menu="score_member_{{ $member->user->id }}"><i class="fa fa-pen"></i> Edit Score</div>
                                    @endif
                                @elseif($event->isOwner())
                                    <div data-menu="score_member_{{ $member->user->id }}"><i class="fa fa-plus"></i><br>Add Score</div>
                                @else
                                    N/A score
                                @endif
                            </em>
                            <strong>
                                <a href="{{ $member->user->link() }}" class="text-dark"><img src="{{ $member->user->image() }}" class="rounded-xl me-2" width="25"> {{ $member->user->formatName() }}</a>
                                <span class="badge bg-transparent border border-red-dark color-red-dark ms-2 d-inline-block">PLAYER</span>
                            </strong>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <div class="card card-style">
        <div class="content position-relative">
            <p class="font-600 color-highlight mb-n1">{{ $event->location }}</p>
            <h1>Event Location</h1>
            <div class="card-center" style="z-index: 5">
                <a href="{{ $event->formatMapsLink() }}" target="_blank" class="external-link float-end btn btn-xs rounded-xl text-uppercase font-900 me-3 bg-white color-black">Open in Maps</a>
            </div>
        </div>
        <div class="responsive-iframe">
            <iframe src="{{ $event->map() }}"></iframe>
        </div>
    </div>
    @if(!$event->isOwner() && !$event->passed())
<form action="{{ $event->register() }}" method="post" data-hook="{{(($event->registered()) ? 'basic-response-reload' : 'basic-response-redirect')}}">
    @csrf
    <input type="hidden" name="event_id" value="{{ $event->id }}">
    <div class="d-flex flex-column">
        @if($event->registered())
            @if(!$event->passed())
                <button class="btn btn-full btn-margins rounded-sm gradient-highlight font-14 font-600 btn-xl">Leave Event</button>
                <input type="hidden" name="leave" value="1">
            @endif
        @elseif(!$event->deadlineReached())
            <button class="btn btn-full btn-margins rounded-sm gradient-highlight font-14 font-600 btn-xl">{{ $event->registerButtonText() }}</button>
        @endif
    </div>
</form>
    @endif


@endsection

@section('after:content')
    @foreach($members as $member)
        @include('components.modals.score')
    @endforeach
    <div id="create_team" class="menu menu-box-modal rounded-m" data-menu-width="320" data-menu-height="480">
        <div class="card rounded-0 mb-0" data-card-height="150" style="height: 250px;background-image: url({{ $event->image() }})">
            <div class="card-center ps-3">
                <h1 class="color-white font-20 mb-0">Create New</h1>
                <h1 class="color-white font-28 mt-n2">Team</h1>
            </div>
            <div class="card-overlay bg-gradient"></div>
        </div>
        <div class="content">
            <form action="{{ route('api.events.teams.create', [$event->id]) }}" data-hook="basic-response-reload">
                <div class="input-style has-borders no-icon validate-field mb-4">
                    <input type="text" name="name" class="form-control validate-name" placeholder="Team name">
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                </div>
                <div class="d-flex mb-1">
                    <div class="align-self-center">
                        <h5 data-activate="toggle-id-1" class="font-700 font-16 mt-1 mb-0">Choose Team Members</h5>
                    </div>
                </div>
                <div class="todo-list list-group list-custom-small me-2">
                    @foreach($event->membersWithoutTeam() as $member)
                        <a href="#" class="">
                            <span>{{ $member->user->formatName() }}</span>
                            <div class="form-check icon-check">
                                <input class="form-check-input" type="checkbox" name="members[{{$member->user->id}}]" value="on">
                                <i class="icon-check-1 far fa-square color-gray-dark font-16"></i>
                                <i class="icon-check-2 far fa-check-square font-16 color-highlight"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="d-flex flex-column">
                    <button class="mt-4 btn btn-l btn-full rounded-sm gradient-blue font-600">Create Team</button>
                </div>
            </form>
        </div>
    </div>
@endsection
