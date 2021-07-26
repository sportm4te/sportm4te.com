@extends('layouts.app')

@section('title', 'Sport Preferences')

@section('title', 'Sport Preferences')

@section('title_html')
    <h1>Sport Preferences</h1>
@endsection

@section('content')
    <div class="sports">
        <form action="{{ route('api.user.sport-choose.store') }}" method="post" data-hook="basic-response-redirect">
            @csrf
            <div class="card card-style">
                <div class="content">
                    <p>Choose your favourite sports by priority.</p>
                </div>
            </div>
            @foreach($sports as $sport)
                <div class="card card-style" data-card-height="150" style="height: 150px;background-image: url({{ $sport->image() }})">
                    <div class="card-center ps-3">
                        <h1 class="color-white mb-n1 font-30">{{ $sport->name }}</h1>
                    </div>
                    <div class="card-center">
                        <span class="float-end bg-theme color-black me-3 rounded-xl {{ empty($preferences[$sport->id]) ? 'd-none' : null }} order-circle">{{ $preferences[$sport->id] ?? '' }}</span>
                    </div>
                    <div class="card-overlay bg-black opacity-60"></div>
                    <input type="hidden" name="preference[{{ $sport->id }}]" value="{{ $preferences[$sport->id] ?? null }}">
                </div>
            @endforeach

            <div class="d-flex flex-column">
                {{ html()->submit('Save preferences')->class('btn btn-margins btn-full mb-2 gradient-highlight font-13 btn-m font-600 rounded-s') }}
            </div>
        </form>
    </div>

    <style>
        .order-circle {
            width: 40px;
            height: 40px;
            line-height: 41px;
            font-size: 26px;
            text-align: center;
        }
    </style>

    <script>
        setTimeout(function() {
        var order={{ $preferences->max() + 1 }};
        document.querySelectorAll('.card').forEach(function(link) {
            link.addEventListener('click', function () {
                var circle = this.querySelector('.order-circle'),
                    input = this.querySelector('input');
                if (!circle.classList.contains('d-none')) {
                    if ((circle.innerHTML) != (order-1)) {
                        return ;
                    }
                    circle.classList.add('d-none');
                    order--;
                    circle.innerHTML = '';
                    input.value = '';
                    return;
                }
                input.value = order;
                circle.innerHTML = (order++);
                circle.classList.remove('d-none');
            })
        })
        }, 1000)
    </script>
@endsection


