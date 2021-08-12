<div class="card card-style">
    <div class="card mb-0 rounded-0" data-card-height="250" style="height: 250px;background-image: url({{ $event->image() }})">
        <div class="card-bottom">
            @if($event->isOwner())
                <a href="{{ $event->edit() }}" class="float-end btn btn-m font-700 bg-white rounded-s color-black mb-2 me-2">Edit event</a>
            @elseif($event->registered() && $event->isPrivate())
                <button class="float-end btn btn-m font-700 bg-white rounded-s color-black mb-2 me-2">{{ $event->member()->registerStatusText() }}</button>
            @elseif(!$event->deadlineReached())
                @if(!$event->registered())
                    <form action="{{ $event->register() }}" method="post" data-hook="basic-response-redirect">
                        @csrf

                        <button class="float-end btn btn-m font-700 bg-white rounded-s color-black mb-2 me-2">{{ $event->registerButtonText() }}</button>
                    </form>
                @elseif(!request()->routeIs('events.detail'))
                    <a href="{{ $event->link() }}" class="float-end btn btn-m font-700 bg-white rounded-s color-black mb-2 me-2">Get Directions</a>
                @endif
            @endif
        </div>
    </div>
    <div class="content">
        <div class="font-600 color-highlight mb-n1">
            {{ $event->formatStart() }}
            <div class="float-end">
                <a href="{{ $event->owner->link() }}">
                    <img src="{{ $event->owner->image() }}" class="rounded-xl border border-success" width="50">
                </a>
            </div>
        </div>
        <a href="{{ $event->link() }}"><h1 class="font-30 font-800">{{ $event->name }}</h1></a>
        @if($event->description)
            <p class="font-14 mb-3">
                {{ $event->description }}
            </p>
        @endif
        <div class="opacity-90">
            <i class="fa icon-30 text-center fa-signal pe-2"></i>Looking for {{$event->formatLevel()}}<br>
            <i class="fa icon-30 text-center fa-map-marker pe-2"></i>{{ $event->formatLocation() }}<br>
            <i class="fa icon-30 text-center fa-users pe-2"></i>{{ $event->formatRegistrations() }}<br>
            <i class="fa icon-30 text-center fa fa-ban"></i><a href="https://docs.google.com/forms/d/e/1FAIpQLSdIEC4GhhHLv-ULjB1e31QscYA-l5qmNXJ22dRwSfUd63v28w/viewform?entry.1009799336=&entry.1245967200={{ $event->id }}" target="_blank">Report this event</a>
            @if($event->deadline)
                <div class="color-red-light"><i class="fa icon-30 text-center fa-calendar-times pe-2"></i>Deadline: {{ $event->formatDeadline() }}</div>
            @endif
        </div>
    </div>
</div>
