@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('provider.register-setup') }}" data-hook="basic-response">
        @csrf
        <div class="card mb-0" style="background-image: url(/images/category/tennis.jpg); height: 734px;">
            <div class="card-top">
                <div class="text-center">
                    <img src="/images/logo.svg" style="width: 180px;padding: 70px 0 20px 0!important;">
                    <h1 class="font-40 color-white">Completion of Registration</h1>
                </div>
                <div class="content px-4">
                    <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                        <i class="fa fa-user"></i>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror validate-name" value="{{ old('username', $userSocial->getNickname()) }}" id="username" placeholder="Username">
                        <label for="username" class="color-highlight">Username</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                    </div>
                    <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                        <i class="fa fa-at"></i>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror validate-name" value="{{ old('email', $userSocial->getEmail()) }}" id="email" placeholder="E-mail Address">
                        <label for="email" class="color-highlight">E-mail Address</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                    </div>
                    <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                        <i class="fa fa-calendar"></i>
                        <input type="text" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror validate-birthdate" id="birthdate" placeholder="Birthdate" onfocus="this.type='date'">
                        <label for="birthdate" class="color-highlight">Birthdate</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                    </div>
                    <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                        <i class="fa fa-user"></i>
                        {{ html()->select('gender', $genders)->id('gender')->attributes(['style' => 'color:inherit!important', 'onchange' => "this.removeAttribute('style')"]) }}
                        <label for="gender" class="color-highlight">Gender</label>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                    <div>
                        <label class="form-check icon-check" for="terms">
                            <input class="form-check-input" type="checkbox" name="terms" value="on" id="terms">
                            <i class="icon-check-1 fa fa-square color-gray-dark font-16"></i>
                            <i class="icon-check-2 fa fa-check-square font-16 color-highlight"></i>
                            <span>I Agree To The <a href="{{ route('terms') }}" class="color-white text-decoration-underline">Terms & Conditions</a></span>
                        </label>
                    </div>
                    <div class="d-flex flex-column">
                        <button type="submit" class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Sign Up</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="avatar" value="{{ $userSocial->getAvatar() }}">
            <input type="hidden" name="provider_id" value="{{ $userSocial->getId() }}">
            <input type="hidden" name="provider" value="{{ $provider }}">
            <input type="hidden" name="timezone">
            <div class="card-overlay bg-black opacity-85"></div>
        </div>
    </form>

    <script>
        document.querySelector('[name=timezone]').value=sportM4te.guessTimezone()
    </script>

@endsection
