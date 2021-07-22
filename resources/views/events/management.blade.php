<form action="{{ $event->exists ? route('api.events.update', [$event->id]) : route('api.events.create') }}" method="post" data-hook="{{ $event->exists ? 'basic-response' : 'basic-response-redirect' }}">
    @csrf
    @php
        $today = \Carbon\Carbon::today()->toDateString();
    @endphp
    @if($event->exists && $readonly)
        <div class="alert me-3 ms-3 rounded-s bg-yellow-dark" role="alert">
            <span class="alert-icon color-white"><i class="fa fa-exclamation-triangle font-18"></i></span>
            <h4 class="color-white font-">Warning</h4>
            <strong class="alert-icon-text color-white">Past events information cannot be edited.</strong>
        </div>
    @endif

    <div class="card card-style">
        <div class="content mb-2">
            <h5>Event Details</h5>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="event" class="color-highlight">Event name</label>
                {{ html()->text('name', old('name', $event->name))->id('event')->placeholder('Event name')->readonly($readonly) }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4">
                <label for="category" class="color-highlight">Category</label>
                {{ html()->select('category', ['' => 'Category'] + $categories, old('category', $event->category))->id('category')->readonly($readonly) }}
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4">
                <label for="category" class="color-highlight">Level</label>
                {{ html()->select('level', ['' => 'Level'] + $levels, old('level', $event->level))->id('level')->readonly($readonly) }}
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 autocomplete">
                <label for="location" class="color-highlight">Location</label>
                {{ html()->text('location', old('location', $event->location))->class('autocomplete-input')->id('location')->placeholder('Search location')->readonly($readonly) }}
                {{ html()->hidden('place_id', old('place_id', $event->place_id)) }}
                <ul class="autocomplete-result-list" style="visibility: hidden"></ul>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4">
                <label for="description" class="color-highlight">Description</label>
                {{ html()->textarea('description', old('description', $event->description))->id('description')->placeholder('Description')->readonly($readonly) }}
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mb-2">
            <h5>Event Privacy</h5>
            <p>Choose who can join this event.</p>
            <div class="row mb-0 px-3 privacy-chooser">
                <div class="col-6 p-0">
                    <label for="public" class="card me-1 mb-0 p-3 {{ (($event->isPublic()) ? 'gradient-highlight' : '') }}">
                        <i class="fa fa-globe fa-3x color-mute text-center"></i>
                        <p class="font-11 text-center pt-2 mb-0 color-mute">Public</p>
                    </label>
                    {{ html()->radio('privacy', old('privacy', $event->privacy) != \App\Models\User\Event::PRIVACY_PRIVATE, \App\Models\User\Event::PRIVACY_PUBLIC)->class('invisible')->id('public')->readonly($readonly) }}
                </div>
                <div class="col-6 p-0">
                    <label for="private" class="card ms-1 mb-0 p-3 {{ (($event->isPrivate()) ? 'gradient-highlight' : '') }}">
                        <i class="fa fa-lock fa-3x color-mute text-center"></i>
                        <p class="font-11 text-center pt-2 mb-0 color-mute">Private</p>
                    </label>
                    {{ html()->radio('privacy', old('privacy', $event->privacy) == \App\Models\User\Event::PRIVACY_PRIVATE, \App\Models\User\Event::PRIVACY_PRIVATE)->class('invisible')->id('private')->readonly($readonly) }}
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mb-0">
            <h1>Cover Photo</h1>
            <p>
                Upload an image and get all the data inside it placed nicely.
            </p>
            <div class="file-data pb-5">
                <input type="file" id="file-upload" name="image" class="upload-file bg-highlight" accept="image/*">
                <p class="upload-file-text color-white">Choose Image</p>
            </div>
            <div class="list-group list-custom-large upload-file-data disabled">
                <img id="image-data" src="images/empty.png" class="img-fluid">
                <a href="#" class="border-0">
                    <i class="fa font-14 fa-info-circle color-blue-dark"></i>
                    <span>File Name</span>
                    <strong class="upload-file-name"></strong>
                </a>
                <a href="#" class="border-0">
                    <i class="fa font-14 fa-weight-hanging color-brown-dark"></i>
                    <span>File Size</span>
                    <strong class="upload-file-size"></strong>
                </a>
                <a href="#" class="border-0">
                    <i class="fa font-14 fa-tag color-red-dark"></i>
                    <span>File Type</span>
                    <strong class="upload-file-type"></strong>
                </a>
                <a href="#" class="border-0 pb-4">
                    <i class="fa font-14 fa-clock color-blue-dark"></i>
                    <span>Modified Date</span>
                    <strong class="upload-file-modified"></strong>
                </a>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mb-2">
            <h5>Date</h5>
            <p>
                <i class="fa fa-globe"></i> Time zone set by the location
            </p>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="start" class="color-highlight">Start Date</label>
                {{ html()->date('start', old('start', $event->start()))->id('start')->attribute('min', $today)->placeholder('Start date')->readonly($readonly) }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="start_at" class="color-highlight">Start Time</label>
                {{ html()->time('start_at', old('start_at', $event->start()?->format('H:i')), false)->readonly($readonly) }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="end" class="color-highlight">End Date</label>
                {{ html()->date('end', old('end', $event->end()))->id('end')->attribute('min', $today)->placeholder('End date')->readonly($readonly) }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="end_at" class="color-highlight">End Time</label>
                {{ html()->time('end_at', old('end_at', $event->end()?->format('H:i')), false)->readonly($readonly) }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mb-2">
            <h5>Settings</h5>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="deadline" class="color-highlight">Deadline</label>
                {{ html()->date('deadline', old('deadline', $event->deadline))->id('deadline')->attribute('min', $today)->placeholder('Deadline')->readonly($readonly) }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="registration_limit" class="color-highlight">Registration Limit</label>
                {{ html()->number('registration_limit', old('registration_limit', $event->registration_limit))->id('deadline')->placeholder('Registration limit')->readonly($readonly) }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mt-2 mb-2">
            <div class="list-group list-custom-large mb-n2 mt-n2">
                <a data-trigger-switch="recurring" class="border-0" href="#" id="recurring_toggle">
                    <i class="fa font-14 fa-clock shadow-s bg-red-dark color-white rounded-sm"></i>
                    <span>Create a recurring event</span>
                    <strong>When you create an event, you can make it repeat on certain days.</strong>
                    <div class="custom-control scale-switch ios-switch">
                        {{ html()->checkbox('recurring', old('recurring', $event->recurring))->id('recurring')->class('ios-input') }}
                        <label class="custom-control-label" for="recurring"></label>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="card card-style {{ ((!old('recurring', $event->recurring)) ? 'd-none' : '') }}" id="recurring_box">
        <div class="content mb-2">
            <h5>Recurring settings</h5>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="recurring_start" class="color-highlight">Repeat Start Time</label>
                {{ html()->time('recurring_start', old('recurring_start', $event->recurring->start ?? null))->id('recurring_start')->placeholder('Repeat start time') }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                <label for="recurring_end" class="color-highlight">Repeat End Time</label>
                {{ html()->time('recurring_end', old('recurring_end', $event->recurring->end ?? null))->id('recurring_end')->placeholder('Repeat end time') }}
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>
            <div class="list-group list-custom-small list-menu ms-0 me-2">
                @foreach(['monday'=>'Monday', 'tuesday'=>'Tuesday', 'wednesday'=>'Wednesday', 'thursday'=>'Thursday', 'friday'=>'Friday', 'saturday'=>'Saturday', 'sunday'=>'Sunday'] as $key => $day)
                    <a href="#" data-trigger-switch="{{$key}}">
                        <span>{{ $day }}</span>
                        <div class="custom-control scale-switch ios-switch small-switch">
                            {{ html()->checkbox('recurring_day['.$key.']', old('recurring_day.'.$key, $event->recurring->{$key} ?? null))->id($key)->class('ios-input') }}
                            <label class="custom-control-label" for="{{$key}}"></label>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex flex-column">
        {{ html()->submit($event->exists ? 'Update event' : 'Create event')->class('btn btn-margins btn-full mb-2 gradient-highlight font-13 btn-m font-600 rounded-s') }}
    </div>
</form>


@section('after:scripts')
    <script>
        sportM4te.places('.autocomplete');

        var privacy = document.getElementsByName('privacy');

        function privacyFn() {
            if(this.value == 1) {
                privacy[0].previousElementSibling.classList.add('gradient-highlight');
                privacy[1].previousElementSibling.classList.remove('gradient-highlight');
            } else {
                privacy[0].previousElementSibling.classList.remove('gradient-highlight');
                privacy[1].previousElementSibling.classList.add('gradient-highlight');
            }
        }

        privacy[0].addEventListener('change', privacyFn);
        privacy[1].addEventListener('change', privacyFn);

        recurring_toggle.addEventListener('click', function() {console.log(1)
            if (recurring.checked) {
                recurring_box.classList.add('d-none');
            } else {
                recurring_box.classList.remove('d-none');
            }
        });

        var reset1 = true;
        start_at.addEventListener('change', function () {
            if (reset1 || !recurring_start.value) {
                recurring_start.value = this.value;
            }
        });

        recurring_start.addEventListener('change', function () {
            reset1 = false;
        });

        var reset2 = true;
        end_at.addEventListener('change', function () {
            if (reset2 || !recurring_end.value) {
                recurring_end.value = this.value;
            }
        });

        recurring_end.addEventListener('change', function () {
            reset2 = false;
        });

        var reset3 = true;
        start.addEventListener('change', function () {
            reset4 = false;
            if (reset3 || !end.value) {
                end.value = this.value;
            }
        });

        var reset4 = true;
        end.addEventListener('change', function () {
            reset3 = false;
            if (reset4 || !start.value) {
                start.value = this.value;
            }
        });
    </script>
@endsection

