@if($member instanceof \App\Models\Event\Team)
    @php
        $scoreId = 'score_team_' . $member->id;
        $title = 'Team Score';
    @endphp
@else
    @php
        $scoreId = 'score_member_' . $member->user->id;
        $title = 'Player Score';
    @endphp
@endif
<div id="{{ $scoreId }}" class="menu menu-box-bottom rounded-m bg-theme" data-menu-height="390">
    <div class="menu-title">
        <p class="color-highlight">Score Setup</p>
        <h1 class="font-22 font-800">{{ $title }}</h1>
        <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
    </div>
    <div class="content">
        <form action="{{ route('api.events.score', [$event->id]) }}" method="post" data-hook="basic-response-redirect">
            <div class="divider mt-n2"></div>
            <div class="d-flex align-items-center mb-4">
                @if($member instanceof \App\Models\Event\Team)
                    <div class="w-100 ms-3">
                        <h6 class="font-500 font-14">{{ $member->name }}
                            <span class="badge bg-transparent border border-red-dark color-red-dark ms-2 d-inline-block">{{ $member->formatTotalMembers() }}</span>
                        </h6>
                        <div>{{ $member->formatMembers() }}</div>
                    </div>
                    <input type="hidden" name="team_id" value="{{ $member->id }}">
                @else
                    <div>
                        <img src="{{ $member->user->image() }}" class="rounded-sm" width="40">
                    </div>
                    <div class="w-100 ms-3">
                        <h6 class="font-500 font-14">{{ $member->user->formatName() }}</h6>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $member->user->id }}">

                @endif
            </div>
            <div class="row mb-0">
                <div class="col-12">
                    <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                        <input type="number" class="form-control validate-number" id="score" name="score" value="{{ $member->score->score ?? '' }}">
                        <label for="score" class="color-highlight">Score</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <em></em>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column">
                <button class="btn btn-full gradient-blue font-13 btn-m font-600 mt-3 rounded-s">Save</button>
            </div>
        </form>
    </div>
</div>
