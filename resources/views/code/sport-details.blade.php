@extends('layouts.app')
@section('title', 'Sport Center')

@section('title_html')
    <h1>Sport Center</h1>
@endsection

@section('content')
    
@php 

$today = date('l');
$number = count($images);



@endphp




        <div class="card card-style">
            <div class="card mb-0 rounded-0 bg-24" data-card-height="250" style="background-image: url('https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}')">
            </div>
            <div class="content">
                <h1 class="font-30 font-800">{{$center->name}}</h1>
                <p class="font-14 mb-3">
                    {{$center->description}}
                </p>
                <p class="opacity-80">
                    <i class="fa icon-30 text-center far fa-clock pe-2"></i>@if ($today == $center->open_monday) Today is open From {{$center->time_from_monday}} To {{$center->time_to_monday}} @elseif ($today == $center->open_tuesday) Today is open From {{$center->time_from_tuesday}} To {{$center->time_to_tuesday}} @elseif ($today == $center->open_wednesday) Today is open From {{$center->time_from_wednesday}} To {{$center->time_to_wednesday}} @elseif ($today == $center->open_thursday) Today is open From {{$center->time_from_thursday}} To {{$center->time_to_thursday}} @elseif ($today == $center->open_friday) Today is open From {{$center->time_from_friday}} To {{$center->time_to_friday}} @elseif ($today == $center->open_friday) Today is open From {{$center->time_from_saturday}} To {{$center->time_to_saturday}} @elseif ($today == $center->open_saturday) Today is open @elseif ($today == $center->open_sunday) Today is open From {{$center->time_from_sunday}} To {{$center->time_to_sunday}} @else Today is close @endif <br>
                    <i class="fa icon-30 text-center fa-map-marker pe-2"></i>City: {{$center->city}} <br>
                    <i class="fa icon-30 text-center fa-map-marker pe-2"></i>Street: {{$center->street}}
                </p>
            </div>
        </div>
        
        <div class="card card-style">
            <div class="content">
            <h1>Gallery</h1>
                <div class="row mb-0">
                @if ($number == 1)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})"></a>
                    </div>
                @endif
                @if ($number == 2)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})"></a>
                    </div>
                    <div class="col-6">
                     <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}})"></a>
                    </div>
                @endif
                @if ($number == 3)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})"></a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}})"></a>
                    </div>
                    <div class="col-6">
                     <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}})"></a>
                    </div>
                @endif
                @if ($number == 4)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})">
                        </a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}})"></a>
                    </div>
                    <div class="col-6">
                     <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}})"></a>
                          <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}})"></a>
                    </div>
                @endif
                @if ($number == 5)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})">
                        </a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}})"></a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}})"></a>
                    </div>
                    <div class="col-6">
                     <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}})"></a>
                          <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}})"></a>
                    </div>
                @endif
                @if ($number == 6)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})">
                        </a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}})"></a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}})"></a>
                    </div>
                    <div class="col-6">
                     <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}})"></a>
                    <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}})"></a>
                    <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[5]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[5]->name}})"></a>

                    </div>
                @endif
                @if ($number == 7)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})">
                        </a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}})"></a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}})"></a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[6]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[6]->name}})"></a>

                    </div>
                    <div class="col-6">
                     <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}})"></a>
                    <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}})"></a>
                    <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[5]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[5]->name}})"></a>

                    </div>
                @endif
                @if ($number == 8)
                    <div class="col-6 pe-0">
                        <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[0]->name}})">
                        </a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[2]->name}})"></a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[4]->name}})"></a>
                       <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[6]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[6]->name}})"></a>

                    </div>
                    <div class="col-6">
                     <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[1]->name}})"></a>
                    <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[3]->name}})"></a>
                    <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[5]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[5]->name}})"></a>
                    <a class="card mx-0 mb-2 card-style default-link" data-card-height="130" data-gallery="gallery-b" href="https://partner.sportm4te.com/storage/uploads/{{$images[7]->name}}" style="background-image:url(https://partner.sportm4te.com/storage/uploads/{{$images[7]->name}})"></a>

                    </div>
                @endif
                </div>
            </div>
        </div>
        
        @if ($center->url != null)
        <a href="{{$center->url}}" class="btn btn-full btn-margins rounded-sm gradient-highlight font-14 font-600 btn-xl">Reserve this Sport Center</a>
        @endif
        @if ($center->phone != null)
        <a href="tel:11111111" class="btn btn-full btn-margins rounded-sm gradient-highlight font-14 font-600 btn-xl">Call to this Sport Center</a>
        @endif



<!-- Page content ends here-->

<!-- Main Menu--> 
    

@endsection

