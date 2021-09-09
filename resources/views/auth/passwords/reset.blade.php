@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" data-hook="basic-response">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="card mb-0" style="background-image: url(/images/sport/tennis.jpg); height: 734px;">
            <div class="card-top">
                <div class="text-center">
                    <img src="/images/logo.svg" style="width: 180px;padding: 70px 0 20px 0!important;">
                    <p class="font-600 color-highlight mb-1 font-16">Reset Password</p>
                    <h1 class="font-40 color-white">Reset Password</h1>
                </div>
                <div class="content px-4">
                    <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror is-invalid" id="password" placeholder="E-Mail Address" value="{{ $email ?? old('email') }}">
                        <label for="email" class="color-highlight">E-Mail Address</label>
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
                    <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror validate-password" id="password_confirmation" placeholder="Password Confirmation">
                        <label for="password_confirmation" class="color-highlight">Password Confirmation</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <button type="submit" class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Reset Password</button>
                    </div>
                </div>
            </div>
            <div class="card-overlay bg-black opacity-85"></div>
        </div>
    </form>
@endsection
