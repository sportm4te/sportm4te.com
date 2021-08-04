@extends('layouts.app')

@section('html-class', 'full-height')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
    <div class="card mb-0" style="background-image: url(/images/category/tennis.jpg); height:inherit">
        <div class="card-center">
            <div class="text-center">
                <img src="/images/logo.svg" style="width: 180px;padding: 30px 0 20px 0!important;">
                <p class="font-600 color-highlight mb-1 font-16">Let's Get Started</p>
                <h1 class="font-40 color-white">Sign In</h1>
            </div>
            <div class="content px-4">
                <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                    <i class="fa fa-at"></i>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror validate-name" id="email" value="{{ old('email') }}" placeholder="E-mail Address">
                    <label for="email" class="color-highlight">E-mail Address</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                </div>
                <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror validate-password" id="password" placeholder="Password">
                    <label for="password" class="color-highlight">Password</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                </div>
                <div class="d-flex flex-column">
                <input type="hidden" name="remember" value="on">
                <button type="submit" class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Sign In</button>
                <a href="{{ route('provider.login', ['facebook']) }}" class="btn btn-full btn-l font-600 font-13 btn-border mt-3 border-blue-dark rounded-s"><i class="fab fa-facebook me-2"></i>Facebook login</a>
                <a href="{{ route('provider.login', ['google']) }}" class="btn btn-full btn-l font-600 font-13 btn-border mt-3 border-red-dark rounded-s"><i class="fab fa-google me-2"></i>Google login</a>
                <a href="{{ route('provider.login', ['apple']) }}" class="btn btn-full btn-l font-600 font-13 btn-border mt-3 border-dark-dark rounded-s"><i class="fab fa-apple me-2"></i>Apple login</a>
                </div>
                <div class="row pt-3 mb-3">
                    <div class="col-6 text-start font-11">
                        <a class="color-white opacity-50" href="{{ route('password.request') }}">Forgot Password?</a>
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
