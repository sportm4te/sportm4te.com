@extends('layouts.app')

@section('html-class', 'full-height')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" data-hook="basic-response">
        @csrf
        <div data-card-height="cover-full" class="card mb-0" style="background-image: url(/images/sport/tennis.jpg); height: inherit;">
            <div class="card-center">
                <div class="text-center">
                    <p class="font-600 color-highlight mb-1 font-16">Reset Account</p>
                    <h1 class="font-40 color-white">Forgot password</h1>
                    <p class="boxed-text-xl color-white opacity-50 pt-3 font-15">
                        Enter your email account associated with your account and we'll send you the reset instructions!
                    </p>
                </div>
                <div class="content px-4">
                    <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                        <i class="fa fa-at"></i>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror validate-name" id="form1a" placeholder="E-mail Address">
                        <label for="form1a" class="color-highlight">E-mail Address</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <button type="submit" class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Send Reset Instructions</button>
                    </div>
                    <div class="row pt-3 mb-3">
                        <div class="col-6 text-start font-11">
                            <a class="color-white opacity-50" href="{{ route('login') }}">Sign In</a>
                        </div>
                        <div class="col-6 text-end font-11">
                            <a class="color-white opacity-50" href="{{ route('register') }}">Create Account</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-overlay bg-black opacity-85"></div>
        </div>
    </form>

@endsection
