<!DOCTYPE html>
<html class="wide" lang="en">

<head>

    <meta charset="UTF-8">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SportM4te</title>
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="./../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./../favicon-16x16.png">

    <meta name="msapplication-TileColor" content="#da532c">
    <link rel="shortcut icon" href="./../favicon.ico">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/webfonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <script src="{{ asset('assets/vendors/jquery/jquery-3.5.0.min.js') }}"></script>
    <style type="text/css">
        img[onload^="SVGInject("] {
            visibility: hidden;
        }

    </style>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-database.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>



    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>

    <script>
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "AIzaSyDqxV_jk9KLPDN3zCoSmL6w3BpzU_WhMUI",
            authDomain: "sport-e3c0c.firebaseapp.com",
            databaseURL: "https://sport-e3c0c-default-rtdb.firebaseio.com",
            projectId: "sport-e3c0c",
            storageBucket: "sport-e3c0c.appspot.com",
            messagingSenderId: "810945622049",
            appId: "1:810945622049:web:6a788c3aa2672f4d49f360",
            measurementId: "G-B1KTRZC1KF"
        };
        firebase.initializeApp(firebaseConfig);
        // firebase.analytics();

        var ref = firebase.database().ref("user_id_{{ auth()->user()->id }}/web_notification");

        let newItems = false;
        ref.on('child_added', function(snapshot) {
            var snotificaton = snapshot.val();
            if (snotificaton.url == "block") {
                var blockkks =
                    '<li class="list-group-item"><div class="media"><div class="btn btn-danger btn-icon rounded-circle text-light mr-2"><i class="fa fa-ban" style="color:white;font-size:50px;"></i></div><div class="media-body"><h6><a href="#">' +
                    snotificaton.text + '</a></h6><p class="text-muted mb-0">25 mins ago</p></div></div></li>';
            } else {
                var blockkks =
                    '<li class="list-group-item"><div class="media"><div class="btn btn-primary btn-icon rounded-circle text-light mr-2"><!-- Default :: Inline SVG --><svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><!-- Alternate :: External File link --><!-- <img class="injectable hw-24" src="./../assets/media/heroicons/outline/check-circle.svg" alt=""> --></div><div class="media-body"><h6><a href="#">' +
                    snotificaton.text + '</a></h6><p class="text-muted mb-0">25 mins ago</p></div></div></li>';


            }
            $('#notifiy').append(blockkks);
            if (!newItems) {
                return
            }

            toastr.options.progressBar = false;
            console.log(snotificaton);
            if (snotificaton.blocked == "1" || snotificaton.un_blocked == "1") {
                location.reload();
            } else {
                toastr.success('<a href=' + snotificaton.url + '>' + snotificaton.text + '</a>');

            }

        });


        ref.once('value', () => {
            newItems = true
        })
    </script>



</head>

<!-- Main Layout Start -->
<div class="main-layout">
    <!-- Navigation Start -->
    <div class="navigation navbar navbar-light bg-primary">
        <!-- Logo Start -->
        <a class="d-none d-xl-block bg-light rounded p-1" href="./../index.html">
            <!-- Default :: Inline SVG -->
            <svg height="30" width="30" viewBox="0 0 512 511">
                <g>
                    <path
                        d="m120.65625 512.476562c-7.25 0-14.445312-2.023437-20.761719-6.007812-10.929687-6.902344-17.703125-18.734375-18.117187-31.660156l-1.261719-41.390625c-51.90625-46.542969-80.515625-111.890625-80.515625-183.992188 0-68.816406 26.378906-132.101562 74.269531-178.199219 47.390625-45.609374 111.929688-70.726562 181.730469-70.726562s134.339844 25.117188 181.730469 70.726562c47.890625 46.097657 74.269531 109.382813 74.269531 178.199219 0 68.8125-26.378906 132.097657-74.269531 178.195313-47.390625 45.609375-111.929688 70.730468-181.730469 70.730468-25.164062 0-49.789062-3.253906-73.195312-9.667968l-46.464844 20.5c-5.035156 2.207031-10.371094 3.292968-15.683594 3.292968zm135.34375-471.976562c-123.140625 0-216 89.816406-216 208.925781 0 60.667969 23.957031 115.511719 67.457031 154.425781 8.023438 7.226563 12.628907 17.015626 13.015625 27.609376l.003906.125 1.234376 40.332031 45.300781-19.988281c8.15625-3.589844 17.355469-4.28125 25.921875-1.945313 20.132812 5.554687 41.332031 8.363281 63.066406 8.363281 123.140625 0 216-89.816406 216-208.921875 0-119.109375-92.859375-208.925781-216-208.925781zm-125.863281 290.628906 74.746093-57.628906c5.050782-3.789062 12.003907-3.839844 17.101563-.046875l55.308594 42.992187c16.578125 12.371094 40.304687 8.007813 51.355469-9.433593l69.519531-110.242188c6.714843-10.523437-6.335938-22.417969-16.292969-14.882812l-74.710938 56.613281c-5.050781 3.792969-12.003906 3.839844-17.101562.046875l-55.308594-41.988281c-16.578125-12.371094-40.304687-8.011719-51.355468 9.429687l-69.554688 110.253907c-6.714844 10.523437 6.335938 22.421874 16.292969 14.886718zm0 0"
                        data-original="#000000" class="active-path" data-old_color="#000000" fill="#665dfe">
                    </path>
                </g>
            </svg>

            <!-- Alternate :: External File link -->
            <!-- <img class="injectable" src="./../assets/media/logo.svg" alt=""> -->
        </a>
        <!-- Logo End -->

        <!-- Main Nav Start -->
        <ul class="nav nav-minimal flex-row flex-grow-1 justify-content-between flex-xl-column justify-content-xl-center"
            id="mainNavTab" role="tablist">

            <!-- Chats Tab Start -->
            <li class="nav-item">
                <a class="nav-link p-0 py-xl-3 active" id="chats-tab" href="#chats-content" title="Chats">
                    <!-- Default :: Inline SVG -->
                    <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                        </path>
                    </svg>

                    <!-- Alternate :: External File link -->
                    <!-- <img class="injectable hw-24" src="./../assets/media/heroicons/outline/chat-alt-2.svg" alt="Chat icon"> -->
                </a>
            </li>
            <!-- Chats Tab End -->

            <!-- Home Tab Start -->
            <li class="nav-item">
                <a class="nav-link p-0 py-xl-3" href="/" title="Home" onclick="go_home()">
                    <!-- Default :: Inline SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" viewBox="0 0 50 50"
                        style=" height:1.5rem;width:1.5rem;">
                        <path
                            d="M 25 1.0507812 C 24.7825 1.0507812 24.565859 1.1197656 24.380859 1.2597656 L 1.3808594 19.210938 C 0.95085938 19.550938 0.8709375 20.179141 1.2109375 20.619141 C 1.5509375 21.049141 2.1791406 21.129062 2.6191406 20.789062 L 4 19.710938 L 4 46 C 4 46.55 4.45 47 5 47 L 19 47 L 19 29 L 31 29 L 31 47 L 45 47 C 45.55 47 46 46.55 46 46 L 46 19.710938 L 47.380859 20.789062 C 47.570859 20.929063 47.78 21 48 21 C 48.3 21 48.589063 20.869141 48.789062 20.619141 C 49.129063 20.179141 49.049141 19.550938 48.619141 19.210938 L 25.619141 1.2597656 C 25.434141 1.1197656 25.2175 1.0507812 25 1.0507812 z M 35 5 L 35 6.0507812 L 41 10.730469 L 41 5 L 35 5 z" />
                    </svg>
                    <!-- Alternate :: External File link -->
                    <!-- <img class="injectable hw-24" src="./../assets/media/heroicons/outline/chat-alt-2.svg" alt="Chat icon"> -->
                </a>
            </li>
            <!-- Home Tab End -->

        </ul>
        <!-- Main Nav End -->
    </div>
    <!-- Navigation End -->
    <script>
        function go_home() {

            // Simulate a mouse click:
            window.location.href = "/";
        }
    </script>
    <!-- Sidebar Start -->
    <aside class="sidebar">
        <!-- Tab Content Start -->
        <div class="tab-content">
            <!-- Chat Tab Content Start -->
            <div class="tab-pane active" id="chats-content">
                <div class="d-flex flex-column h-100">
                    <div class="hide-scrollbar h-100" id="chatContactsList">

                        <!-- Chat Header Start -->
                        <div class="sidebar-header sticky-top p-2">

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Chat Tab Pane Title Start -->
                                <h5 class="font-weight-semibold mb-0">Chats</h5>
                                <!-- Chat Tab Pane Title End -->

                                <ul class="nav flex-nowrap">

                                    <li class="nav-item list-inline-item mr-1">
                                        <a class="nav-link text-muted px-1" href="#" title="Notifications" role="button"
                                            data-toggle="modal" data-target="#notificationModal">
                                            <!-- Default :: Inline SVG -->
                                            <svg class="hw-20" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                                </path>
                                            </svg>

                                            <!-- Alternate :: External File link -->
                                            <!-- <img src="./../assets/media/heroicons/outline/bell.svg" alt="" class="injectable hw-20"> -->
                                        </a>
                                    </li>

                                    <li class="nav-item list-inline-item mr-0">
                                        <div class="dropdown">
                                            <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="hw-20" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img src="./../assets/media/heroicons/outline/dots-vertical.svg" alt="" class="injectable hw-20"> -->
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item" href="#" role="button" data-toggle="modal"
                                                    data-target="#createGroup">Create Group</a>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>


                            <!-- Sidebar Header Start -->
                            <div class="sidebar-sub-header">
                                <!-- Sidebar Header Dropdown Start -->
                                <div class="dropdown mr-2">
                                    <!-- Dropdown Button Start -->
                                    <button class="btn btn-outline-default dropdown-toggle" type="button"
                                        data-chat-filter-list="" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        All Chats
                                    </button>
                                    <!-- Dropdown Button End -->

                                    <!-- Dropdown Menu Start -->
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" data-chat-filter="" data-select="all-chats"
                                            href="#">All Chats</a>

                                        <a class="dropdown-item" data-chat-filter="" data-select="groups"
                                            href="#">Groups</a>

                                    </div>
                                    <!-- Dropdown Menu End -->
                                </div>
                                <!-- Sidebar Header Dropdown End -->

                                <!-- Sidebar Search Start -->
                                <form class="form-inline">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control search border-right-0 transparent-bg pr-0"
                                            placeholder="Search users...">
                                        <div class="input-group-append">
                                            <div class="input-group-text transparent-bg border-left-0" role="button">
                                                <!-- Default :: Inline SVG -->
                                                <svg class="text-muted hw-20" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>

                                                <!-- Alternate :: External File link -->
                                                <!-- <img class="injectable hw-20" src="./../assets/media/heroicons/outline/search.svg" alt=""> -->
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- Sidebar Search End -->
                            </div>
                            <!-- Sidebar Header End -->
                        </div>
                        <!-- Chat Header End -->
                        @php
                            $conversation = App\Models\ChatConvo::where('sender_id', Auth::user()->id)
                                ->orwhere('reciever_id', Auth::user()->id)
                                ->orderBy('id', 'DESC')
                                ->get();
                            $count_conversation = App\Models\ChatConvo::where('sender_id', Auth::user()->id)
                                ->orwhere('reciever_id', Auth::user()->id)
                                ->count();
                            $all_group = App\Models\GroupParticipant::where('participant_id', Auth::user()->id)
                                ->orderBy('id', 'DESC')
                                ->get();
                            $all_group_count = App\Models\GroupParticipant::where('participant_id', Auth::user()->id)->count();
                            
                        @endphp

                        <!-- Chat Contact List Start -->
                        <ul class="contacts-list" id="chatContactTab" data-chat-list="">
                            <!-- Chat Item Start -->



                            @if ($count_conversation > 0)
                                @foreach ($conversation as $contact)
                                    @php
                                        if ($contact->reciever_id == Auth::user()->id) {
                                            $contact_details = App\Models\User::where('id', $contact->sender_id)->first();
                                        } else {
                                            $contact_details = App\Models\User::where('id', $contact->reciever_id)->first();
                                        }
                                        
                                    @endphp
                                    <!-- Chat Item Start -->
                                    <li class="contacts-item">
                                        <a class="contacts-link"
                                            href="/Conversation/{{ $contact_details->id }}/{{ str_replace(' ', '-', $contact_details->username) }}">
                                            <div class="avatar avatar-online">
                                                <img src="{{ $contact_details->image() }}"
                                                    alt="{{ $contact_details->image() }}">
                                            </div>
                                            <div class="contacts-content">
                                                <div class="contacts-info">
                                                    <h6 class="chat-name">
                                                        {{ $contact_details->username }}</h6>
                                                    <div class="chat-time">
                                                        <span>{{ $contact->created_at->format('d/m/yy') }}</span>
                                                    </div>
                                                </div>
                                                <div class="contacts-texts">
                                                    <p class="text-truncate">
                                                        {{ $contact->message }}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- Chat Item End -->
                                @endforeach
                            @else
                                <li class="contacts-item archived">

                                    No Contact Found.
                                </li>

                            @endif

                            @if ($all_group_count > 0)
                                @foreach ($all_group as $all_groups)
                                    <!-- Chat Item Start -->
                                    @php
                                        $group_details = App\Models\Group::where('id', $all_groups->group_id)->first();
                                    @endphp
                                    <li class="contacts-item groups">
                                        <a class="contacts-link"
                                            href="/Group/{{ $group_details->id }}/{{ str_replace(' ', '-', $group_details->group_name) }}">
                                            <div class="avatar bg-success text-light">
                                                <span>
                                                    <!-- Default :: Inline SVG -->
                                                    <img src="{{ asset('/group_thumb') }}/{{ $group_details->group_thumb }}"
                                                        alt="" class="img">

                                                    <!-- Alternate :: External File link -->
                                                    <!-- <img class="injectable" src="./../assets/media/heroicons/outline/user-group.svg" alt=""> -->
                                                </span>
                                            </div>
                                            <div class="contacts-content">
                                                <div class="contacts-info">
                                                    <h6 class="chat-name">{{ $group_details->group_name }}
                                                    </h6>
                                                    <div class="chat-time">
                                                        <span>{{ $group_details->updated_at->format('d/m/yy') }}</span>
                                                    </div>
                                                </div>
                                                <div class="contacts-texts">
                                                    <p class="text-truncate"><span>Jeny: </span>That’s pretty
                                                        common. I
                                                        heard that a lot of people had the same experience.</p>
                                                    <div class="d-inline-flex align-items-center ml-1">
                                                        <!-- Default :: Inline SVG -->
                                                        @if ($group_details->group_privacy == 'private')
                                                            <svg class="hw-16 text-muted" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        @endif

                                                        <!-- Alternate :: External File link -->
                                                        <!-- <img class="injectable hw-16 text-muted" src="./../assets/media/heroicons/solid/lock-closed.svg" alt=""> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- Chat Item End -->
                                @endforeach
                            @endif
                        </ul>
                        <!-- Chat Contact List End -->
                    </div>
                </div>
            </div>
            <!-- Chats Tab Content End -->

            <!-- Tab Content End -->
    </aside>
    <!-- Sidebar End -->

    <!-- Modal 2 :: Create Group -->
    <div class="modal modal-lg-fullscreen fade" id="createGroup" tabindex="-1" role="dialog"
        aria-labelledby="createGroupLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
            <form method="post" id="create_group_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title js-title-step" id="createGroupLabel">&nbsp;</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body py-0 hide-scrollbar">
                        <div class="row hide pt-2" data-step="1" data-title="Create a New Group">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="groupName">Group name</label>
                                    <input type="text" name="group_name" class="form-control form-control-md"
                                        id="groupName" placeholder="Type group name here">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Choose profile picture</label>
                                    <div class="custom-file">
                                        <input type="file" name="files" class="custom-file-input"
                                            id="profilePictureInput" accept="image/*">
                                        <label class="custom-file-label" for="profilePictureInput">Choose
                                            file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-0">
                                            <label>Group privacy</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group rounded p-2 border">
                                            <div class="custom-control custom-radio">
                                                <input class="form-check-input" type="radio" name="group_privacy"
                                                    id="exampleRadios1" value="public" checked="">
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Public group
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group rounded p-2 border">
                                            <div class="custom-control custom-radio">
                                                <input class="form-check-input" type="radio" name="group_privacy"
                                                    id="exampleRadios2" value="private">
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Private group
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer col-sm-12">
                                <button type="button" class="btn btn-link text-muted js-btn-step mr-auto"
                                    data-orientation="cancel" data-dismiss="modal"></button>
                                <button type="button" class="btn btn-secondary  js-btn-step"
                                    data-orientation="previous"></button>
                                <button type="submit" class="btn btn-primary js-btn-step"
                                    data-orientation="next"></button>
                            </div>

                        </div>
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
            </form>


            <div class="row hide pt-2" data-step="2" data-title="Add Group Members">
                <div class="col-12 px-0">
                    <!-- Search Start -->
                    <div class="input-group w-100 bg-light">
                        <input type="text"
                            class="form-control form-control-md search border-right-0 transparent-bg pr-0"
                            placeholder="Search...">
                        <div class="input-group-append">
                            <div class="input-group-text transparent-bg border-left-0" role="button">
                                <!-- Default :: Inline SVG -->
                                <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>

                                <!-- Alternate :: External File link -->
                                <!-- <img class="injectable hw-20" src="./../assets/media/heroicons/outline/search.svg" alt=""> -->
                            </div>
                        </div>
                    </div>
                    <!-- Search End -->
                </div>
                <form method="post" id="add_member_form" class="col-sm-12">
                    <input type="hidden" id="token" value="{{ csrf_token() }}">

                    <div class="col-12 px-0">
                        <!-- List Group Start -->
                        <ul class="list-group list-group-flush">
                            @php
                                $all_user = App\Models\User::where('id', '!=', Auth::user()->id)->get();
                            @endphp

                            @foreach ($all_user as $all_users)

                                <!-- List Group Item Start -->
                                <li class="list-group-item">
                                    <div class="media">
                                        <div class="avatar avatar-online mr-2">
                                            <img src="{{ $all_users->image() }}" alt="">
                                        </div>

                                        <div class="media-body">
                                            <h6 class="text-truncate">
                                                <a href="#" class="text-reset">{{ $all_users->username }}</a>
                                            </h6>

                                        </div>

                                        <div class="media-options">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox"
                                                    name="participants_id" value="{{ $all_users->id }}"
                                                    id="chx-user-{{ $all_users->id }}">
                                                <label class="custom-control-label"
                                                    for="chx-user-{{ $all_users->id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="media-label" for="chx-user-{{ $all_users->id }}"></label>
                                </li>


                                <script>
                                    // Add record
                                    $('#add_member_form').submit(function(e) {


                                        e.preventDefault();
                                        var form = new FormData(document.getElementById('add_member_form'));
                                        var token = $('#token').val();
                                        form.append('_token', token);
                                        var checked_box = document.getElementById("chx-user-{{ $all_users->id }}");

                                        if (checked_box.checked == true) {

                                            $.ajax({
                                                url: '/add_member/{{ $all_users->id }}',
                                                type: 'post',
                                                data: form,
                                                cache: false,
                                                contentType: false, //must, tell jQuery not to process the data
                                                processData: false,

                                                success: function(response) {

                                                }
                                            });
                                        }

                                    });
                                </script>

                            @endforeach
                            <!-- List Group Item End -->
                            <input type="hidden" id="group_id" name="group_id">

                        </ul>
                        <!-- List Group End -->
                    </div>

                    <div class="modal-footer col-sm-12">
                        <button type="button" class="btn btn-link text-muted js-btn-step mr-auto"
                            data-orientation="cancel" data-dismiss="modal"></button>

                        <button type="submit" class="btn btn-primary js-btn-step" data-orientation="next"></button>
                    </div>
                </form>
            </div>

            <div class="row pt-2 h-100 hide" data-step="3" data-title="Finished">
                <div class="col-12">
                    <div class="d-flex justify-content-center align-items-center flex-column h-100">
                        <div class="btn btn-success btn-icon rounded-circle text-light mb-3">
                            <!-- Default :: Inline SVG -->
                            <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>

                            <!-- Alternate :: External File link -->
                            <!-- <img class="injectable hw-24" src="./../assets/media/heroicons/outline/check.svg" alt=""> -->
                        </div>
                        <h6>Group Created Successfully</h6>
                        <p class="text-muted text-center">Lorem ipsum dolor sit amet consectetur
                            adipisicing elit. Dolores cumque laborum fugiat vero pariatur provident!</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>



<!-- Modal 4 :: Notifications -->
<div class="modal modal-lg-fullscreen fade" id="notificationModal" tabindex="-1" role="dialog"
    aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 hide-scrollbar">
                <div class="row">

                    <div class="col-12">
                        <!-- List Group Start -->
                        <ul class="list-group list-group-flush  py-2">


                            <!-- List Group Item Start -->
                            <div id="notifiy"></div>
                            <!-- List Group Item End -->


                        </ul>
                        <!-- List Group End -->
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-link text-muted" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>







@yield('content')




<script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendors/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/vendors/svg-inject/svg-inject.min.js') }}"></script>
<script src="{{ asset('assets/vendors/modal-stepes/modal-steps.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>


<script type="text/javascript">
    var x = document.getElementById("image_display");
    x.style.display = "none";

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(100);
            };
            var name = document.getElementById('image');
            x.style.display = "block";
            $('#files').val(name.files.item(0).name);
            reader.readAsDataURL(input.files[0]);
        }
    }



    function myFunction() {
        var xdiv = document.getElementById("image_display");
        xdiv.style.display = "none";
        $('#send_container_messge')[0].reset();
    }
</script>

<script>
    // Add record
    $('#create_group_form').submit(function(e) {


        e.preventDefault();
        var form = new FormData(document.getElementById('create_group_form'));
        var token = $('#token').val();
        form.append('_token', token);
        var x = document.getElementById("myAudio");

        $.ajax({
            url: '/create_group',
            type: 'post',
            data: form,
            cache: false,
            contentType: false, //must, tell jQuery not to process the data
            processData: false,

            success: function(response) {
                console.log(response);
                document.getElementById('group_id').value = response;
            }
        });


    });
</script>

<!-- Add Firebase products that you want to use -->
