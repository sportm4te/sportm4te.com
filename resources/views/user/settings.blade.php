@extends('layouts.app')
@section('title', 'Settings')

@section('title_html')
    <h1>Settings</h1>
@endsection

@section('content')
    @include('components.errors')
    <form method="post" action="{{ route('api.user.settings.update') }}" data-hook="basic-response">
        @csrf
        <div class="card card-style">
            <div class="content mb-2">
                <h5>Account Details</h5>
                <div class="list-group list-custom-large upload-file-data mb-2">
                    <img id="image-data" src="{{ $user->image() }}" class="rounded-circle m-auto" width="80">
                </div>
                <div class="file-data pb-5">
                    <input type="file" id="file-upload" name="image" class="upload-file" accept="image/*">
                    <p class="upload-file-text">Choose Avatar</p>
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                    <label for="name" class="color-highlight">Username</label>
                    {{ html()->text('name', old('username', $user->username))->id('username')->placeholder('Username')->disabled() }}
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em>
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4">
                    <label for="description" class="color-highlight">Bio</label>
                    {{ html()->textarea('bio', old('bio', $user->bio))->id('bio')->placeholder('Bio') }}
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                    <label for="email" class="color-highlight">E-mail Address</label>
                    {{ html()->email('email', old('email', $user->email))->id('email')->placeholder('E-mail address') }}
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em>
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                    <label for="birthdate" class="color-highlight">Birthdate</label>
                    {{ html()->date('birthdate', old('birthdate', $user->birthdate))->id('birthdate')->placeholder('Birthdate')->disabled() }}
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em>
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 autocomplete">
                    <label for="location" class="color-highlight">Location</label>
                    {{ html()->text('location', old('location', $user->place->formatted_address ?? null))->class('autocomplete-input')->id('location')->placeholder('Search location') }}
                    {{ html()->hidden('place_id', old('place_id', $user->place_id)) }}
                    <ul class="autocomplete-result-list" style="visibility: hidden"></ul>
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 autocomplete">
                    <label for="gender" class="color-highlight">Gender</label>
                    {{ html()->select('gender', $genders, old('gender', $user->unit))->id('gender') }}
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 autocomplete">
                    <label for="unit" class="color-highlight">Unit</label>
                    {{ html()->select('unit', $units, old('unit', $user->unit))->id('unit') }}
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
                <i class="fa fa-globe"></i> Time zone set by the location
                <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                    <label for="timezone" class="color-highlight">Timezone</label>
                    {{ html()->select('timezone', $timezones, old('timezone', $user->timezone_id))->id('timezone')->readonly($user->place !== null) }}
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em>
                </div>
                <div class="d-flex flex-column">
                    {{ html()->submit('Update settings')->class('btn btn-full mb-2 gradient-highlight font-13 btn-m font-600 rounded-s') }}
                </div>
            </div>
        </div>
    </form>
    <form method="post" action="{{ route('api.user.settings.password') }}" data-hook="basic-response">
        <div class="card card-style">
            <div class="content mb-2">
                <h5>Password</h5>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                    <label for="password" class="color-highlight">New Password</label>
                    {{ html()->password('password')->id('password') }}
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em>
                </div>
                <div class="input-style has-borders no-icon input-style-always-active mb-4 mt-2">
                    <label for="password_confirmation" class="color-highlight">Password Confirmation</label>
                    {{ html()->password('password_confirmation')->id('password_confirmation') }}
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em>
                </div>
                <div class="d-flex flex-column">
                    {{ html()->submit('Change password')->class('btn btn-full mb-2 gradient-highlight font-13 btn-m font-600 rounded-s') }}
                </div>
            </div>
        </div>
    </form>
@endsection

@section('after:scripts')
    <script>
        sportM4te.places('.autocomplete')
    </script>
@endsection

