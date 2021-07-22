@extends('layouts.app')
@section('title', 'Search')

@section('title_html')
    <h1>Search</h1>
@endsection

@section('content')
    <form action="{{ route('events.list') }}" data-hook="none">
    <div class="content mt-n3 mb-4">
            <div class="search-box search-dark shadow-sm border-0 mt-4 bg-theme rounded-sm bottom-0">
                <i class="fa fa-search ms-1"></i>
                <input type="text" name="q" class="border-0" value="{{ $text }}"
                       placeholder="Searching for something? Try 'Soccer at New York'">
            </div>
        </div>
        <div class="card card-style overflow-visible" style="z-index: 1;">
            <div class="content mb-0">
                <h4>Filters</h4>
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect collapsed" href="#category" aria-expanded="false">
                        <i class="fa font-14 fa-list color-red-dark"></i>
                        <span class="font-14">Sport</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="collapse mt-3" id="category">
                    @foreach($sports as $sport)
                        <div class="form-check interest-check">
                            <input class="form-check-input" type="radio" name="sport_id" value="{{ $sport->id }}" id="{{ $sport->slug }}" onchange="this.form.submit()" {{ $eventSearchService->checkOption('category_id', $sport->id) ? 'checked' : '' }}>
                            <label class="form-check-label shadow-xl rounded-xl" for="{{ $sport->slug }}">{{ $sport->name }}</label>
                            <i class="fa fa-check-circle color-white font-18"></i>
                            <i class="fa">{{ $sport->emoji }}</i>
                        </div>
                    @endforeach
                </div>
                <script>
                    setTimeout(function() {
                        var radios = document.querySelectorAll('.form-check input[type=radio]'),
                            checkedRadio = document.querySelectorAll('.form-check input[type=radio]:checked');

                        radios.forEach((radio) => {
                            radio.addEventListener('click', function()
                            {
                                if (checkedRadio === this)
                                {
                                    this.checked = false;
                                    this.dispatchEvent(new Event("change"));
                                    checkedRadio = null;
                                } else {
                                    checkedRadio = this;
                                }
                            });
                        });
                    }, 1000);
                </script>
                <div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#dates">
                        <i class="fa font-14 fa-calendar color-blue-dark"></i>
                        <span class="font-14">Dates</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="collapse" id="dates">
                    <div class="todo-list list-group list-custom-small me-2">
                        @foreach(array_keys(\App\Management\EventSearchService::DATES) as $index => $date)
                            <label>
                                <span>{{ $date }}</span>
                                <div class="form-check icon-check">
                                    <input class="form-check-input" name="dates[]" type="checkbox" value="{{ $date }}" onchange="this.form.submit()" {{ $eventSearchService->checkOption('dates', $date) ? 'checked' : '' }}>
                                    <i class="icon-check-1 far fa-square color-gray-dark font-16"></i>
                                    <i class="icon-check-2 far fa-check-square font-16 color-highlight"></i>
                                </div>
                            </label>
                        @endforeach
                    </div>
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
                        {{ html()->text('location', $eventSearchService->getOption('location'))->class('autocomplete-input')->id('location')->placeholder('Search location') }}
                        {{ html()->hidden('place_id', $eventSearchService->getOption('place_id')) }}
                        <ul class="autocomplete-result-list" style="visibility: hidden"></ul>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" style="position: absolute; left: -9999px"/>
    </form>
    <div class="content">
        @if($intro)
            @if($userSports->isNotEmpty())
                <div class="d-flex mt-3">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-18"><i class="fa fa-thumbtack"></i> Your sports</h1>
                    </div>
                </div>
                <div class="row mb-0">
                    @foreach($userSports->pluck('sport') as $key => $sport)
                        @php
                            $search = $sport->searchAround();
                            $query = $search->query();
                            $height = 170;
                        @endphp
                        @if($userSportsTotal === 3)
                            @if($key === 0)
                                @php
                                    $height = 350;
                                @endphp
                                <div class="col-6 pe-1">
                                    @elseif($key === 1)
                                </div>
                                <div class="col-6">
                                    @endif
                                    @elseif(($key === 0 || ($userSportsTotal % 2) === 1) && $loop->last)
                                        <div class="col-12">
                                            @else
                                                <div class="col-6">
                                                    @endif
                                                    @php
                                                        $total = $query->count();
                                                    @endphp
                                                    <a href="{{ $search->link() }}"
                                                       class="card card-style mx-0 {{ ($userSportsTotal === 3 && $key === 1) ? 'mb-2' : (($userSportsTotal > 3) ? 'mb-4' : '') }}"
                                                       style="background-image: url({{ $sport->image() }}); height: {{ $height }}px;"
                                                       data-card-height="{{ $height }}">
                                                        <div class="card-bottom p-3">
                                                            <h2 class="color-white">{{ $sport->name }}</h2>
                                                            <p class="color-white opacity-60 line-height-s">
                                                                @if(auth()->user()->place !== null)
                                                                    {{ $total . (($total === 1) ? ' upcoming event near you' : ' upcoming events near you') }}
                                                                @else
                                                                    {{ $total . (($total === 1) ? ' upcoming event' : ' upcoming events') }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="card-overlay bg-gradient opacity-30"></div>
                                                        <div class="card-overlay bg-gradient"></div>
                                                    </a>
                                                    @if($userSportsTotal === 3 && $key !== 2)
                                                    @else
                                                </div>
                                            @endif
                                            @endforeach
                                        </div>

                                    @endif
                                    <a href="{{ route('events.make') }}"
                                       class="btn btn-full gradient-highlight font-13 mt-3 btn-m font-600 rounded-s">Create
                                        Event</a>
                                </div>
                            </div>
                            @else
                </div>
                @forelse($events as $event)
                    @include('events.components.event-card')
                @empty
                    <div class="card card-style">
                        <h4 class="font-28 text-center color-theme font-800 pt-3 mt-3">We didn't find any results</h4>
                        <p class="boxed-text-l mb-4">
                            Make sure everything is spelled correctly or try different keywords.
                        </p>
                    </div>
                @endforelse

                {!! $events->links() !!}

                <a href="{{ route('events.make') }}"
                   class="btn btn-full btn-margins gradient-highlight font-13 btn-m font-600 rounded-s">Create Event</a>
            @endif
    </div>

@endsection

@section('after:scripts')
    <script>
        sportM4te.places('.autocomplete', function () {
            var input = this.querySelector('input');

            input.form.submit();
        });
</script>
@endsection
