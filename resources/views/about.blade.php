@extends('layouts.app')

@section('title', 'About')

@section('title_html')
    <h1>About</h1>
@endsection

@section('content')
    <div class="page-content">
        <div>
            <div class="card card-style">
                <div class="text-center pt-3 mt-3">
                    <img src="/images/logo.svg" width="180px" class="logo-dark m-auto">
                    <img src="/images/logo-dark.svg" width="180px" class="logo-light m-auto">
                </div>
                <p class="boxed-text-l mb-4">
                    {{ $version }}
                </p>
                <div class="text-center mb-4">
                    <a href="https://facebook.com/sportm4te" class="icon icon-xs rounded-sm shadow-l mr-1 bg-facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://instagram.com/sportm4te" class="icon icon-xs rounded-sm shadow-l mr-1 bg-instagram"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="divider mb-3"></div>
                <div class="row text-center mb-3 pl-3 pr-3">
                    <a class="font-11 col-6" href="{{ route('terms') }}">Privacy Policy</a>
                    <a class="font-11 col-6" href="{{ route('terms') }}">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
@endsection
