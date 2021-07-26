@extends('layouts.app')

@section('title', 'Search Users')

@section('title_html')
    <h1>Search Users</h1>
@endsection

@section('content')
    <form action="{{ route('users.list') }}" data-hook="none">
        <div class="content mt-n3 mb-4">
            <div class="search-box search-dark shadow-sm border-0 mt-4 bg-theme rounded-sm bottom-0">
                <i class="fa fa-search ms-1"></i>
                <input type="text" name="q" class="border-0" value="{{ $text }}" placeholder="Search By User Name">
            </div>
        </div>

        <div class="card card-style">
            <div class="content mb-0">
                <h4>Filters</h4>
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect collapsed" href="#sports" aria-expanded="false">
                        <i class="fa font-14 fa-list color-red-dark"></i>
                        <span class="font-14">Favourite sports</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="collapse mt-3" id="sports">
                    @foreach($sports as $sport)
                        <div class="form-check interest-check">
                            <input class="form-check-input" type="checkbox" name="sports[]" value="{{ $sport->id }}" id="{{ $sport->slug }}" {{ ((in_array($sport->id, $searchedSports)) ? 'checked' : '') }}>
                            <label class="form-check-label shadow-xl rounded-xl" for="{{ $sport->slug }}">{{ $sport->name }}</label>
                            <i class="fa fa-check-circle color-white font-18"></i>
                            <i class="fa">{{ $sport->emoji }}</i>
                        </div>
                    @endforeach
                </div>
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#location">
                        <i class="fa font-14 fa-map-marker color-green-dark"></i>
                        <span class="font-14">Location</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="collapse" id="location">
                    <div class="input-style has-borders no-icon input-style-always-active mb-4 autocomplete">
                        <label for="location" class="color-highlight">Location</label>
                        {{ html()->text('location', $request->get('location'))->class('autocomplete-input')->id('location')->placeholder('Search location') }}
                        {{ html()->hidden('place_id', $request->get('place_id')) }}
                        <ul class="autocomplete-result-list" style="visibility: hidden"></ul>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" style="position: absolute; left: -9999px"/>
    </form>


    @forelse($users as $user)
        <div class="card card-style">
            <div class="content text-center">
                <a href="{{ $user->link() }}">
                    <img src="{{ $user->image() }}" class="mx-auto rounded-circle shadow-xl" width="150" height="150">
                    <h1 class="mt-4 font-20 font-700 mb-n1">{{ $user->formatName() }}</h1>
                </a>
                @if($user->reviews->isNotEmpty())
                <span>
                    @php($rating=$user->reviews->avg('stars'))
                    @foreach(range(1, 5) as $star)
                        <i class="fa fa-star font-18 {{ (($rating >= $star) ? 'color-yellow-dark' : 'color-dark-dark') }}"></i>
                    @endforeach
                </span>
                @endif
                <span>
                    <p class="font-10 mb-2">Member since {{ $user->created_at->format('jS F Y') }}</p>
                    @if($user->sports->isNotEmpty())
                        <div class="font-500 font-12">
                            <i class="fa fa-heart text-danger"></i> {{ $user->sports->pluck('sport.name')->join(', ') }}
                        </div>
                    @endif
                </span>
                <div class="row mt-3 mb-0 text-center">
                    <div class="col-4">
                        <h1 class="mb-n1">{{ $user->friends()->count() }}</h1>
                        <p class="font-10 mb-0 pb-0">Friends</p>
                    </div>
                    <div class="col-4">
                        <h1 class="mb-n1">{{ $user->hosting()->count() }}</h1>
                        <p class="font-10 mb-0 pb-0">Events</p>
                    </div>
                    <div class="col-4">
                        <h1 class="mb-n1">{{ $user->going()->count() }}</h1>
                        <p class="font-10 mb-0 pb-0">Joined events</p>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card card-style">
            <h4 class="font-28 text-center color-theme font-800 pt-3 mt-3">We didn't find any results</h4>
            <p class="boxed-text-l mb-4">
                Make sure everything is spelled correctly or try different keywords.
            </p>
        </div>
    @endforelse

    {!! $users->links() !!}
@endsection

