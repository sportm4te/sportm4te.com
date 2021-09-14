   @extends('layouts.messenger_layout')

   @section('content')

       <!-- Main Start -->
       <main class="main main-visible">

           <!-- Chats Page Start -->
           <div class="chats">
               <!-- Chat Body Start -->
               <div class="chat-body">

                   <!-- Chat Header Start-->
                   <div class="chat-header">
                       <!-- Chat Back Button (Visible only in Small Devices) -->
                       <button class="btn btn-secondary btn-icon btn-minimal btn-sm d-xl-none" type="button" data-close="">
                           <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                           </svg>
                           <!-- <img class="injectable hw-20" src="./../assets/media/heroicons/outline/arrow-left.svg" alt=""> -->
                       </button>

                       <!-- Chat participant's Name -->
                       <div class="media chat-name align-items-center text-truncate">
                           <div class="avatar bg-success text-light d-none d-sm-inline-block mr-3">
                               <span>

                                   <img class="injectable"
                                       src="{{ asset('/group_thumb') }}/{{ $group_details->group_thumb }}" alt="">
                               </span>
                           </div>

                           <div class="media-body align-self-center ">
                               <h6 class="text-truncate mb-0">{{ $group_details->group_name }}</h6>
                               <small class="text-muted">{{ $count_members }} Participants</small>
                           </div>
                       </div>

                       <!-- Chat Options -->
                       <ul class="nav flex-nowrap">

                           <li class="nav-item list-inline-item d-none d-sm-block mr-0">
                               <div class="dropdown">
                                   <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                           </path>
                                       </svg>
                                       <!-- <img src="./../assets/media/heroicons/outline/dots-vertical.svg" alt="" class="injectable hw-20"> -->
                                   </a>

                                   <div class="dropdown-menu dropdown-menu-right" style="">
                                       <a class="dropdown-item align-items-center d-flex" href="/leave_group"
                                           data-chat-info-toggle="">
                                           <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                   d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                               </path>
                                           </svg>

                                           <!-- <img src="./../assets/media/heroicons/outline/information-circle.svg" alt="" class="injectable hw-20 mr-2"> -->
                                           <span>View Info</span>
                                       </a>

                                       <a class="dropdown-item align-items-center d-flex text-danger" href="/leave_group">
                                           <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                   d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                               </path>
                                           </svg>

                                           <!-- <img src="./../assets/media/heroicons/outline/ban.svg" alt="" class="injectable hw-20 mr-2"> -->
                                           <span>Leave Group</span>
                                       </a>
                                   </div>
                               </div>
                           </li>
                           <li class="nav-item list-inline-item d-sm-none mr-0">
                               <div class="dropdown">
                                   <a class="nav-link text-muted px-1" href="#" role="button" title="Details"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                           </path>
                                       </svg>
                                       <!-- <img src="./../assets/media/heroicons/outline/dots-vertical.svg" alt="" class="injectable hw-20"> -->
                                   </a>

                                   <div class="dropdown-menu dropdown-menu-right">


                                       <a class="dropdown-item align-items-center d-flex" href="#" data-chat-info-toggle="">
                                           <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                   d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                               </path>
                                           </svg>

                                           <!-- <img src="./../assets/media/heroicons/outline/information-circle.svg" alt="" class="injectable hw-20 mr-2"> -->
                                           <span>View Info</span>
                                       </a>
                                       <a class="dropdown-item align-items-center d-flex text-danger" href="#">
                                           <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                   d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                               </path>
                                           </svg>

                                           <!-- <img src="./../assets/media/heroicons/outline/ban.svg" alt="" class="injectable hw-20 mr-2"> -->
                                           <span>Leave Group</span>
                                       </a>
                                   </div>
                               </div>
                           </li>
                       </ul>
                   </div>
                   <!-- Chat Header End-->

                   <!-- Search Start -->
                   <div class="collapse border-bottom px-3" id="searchCollapse">
                       <div class="container-xl py-2 px-0 px-md-3">
                           <div class="input-group bg-light ">
                               <input type="text" class="form-control form-control-md border-right-0 bg-transparent pr-0"
                                   placeholder="Search...">
                               <div class="input-group-append">
                                   <span class="input-group-text bg-transparent border-left-0">
                                       <svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                       </svg>

                                       <!-- <img class="injectable hw-20" src="./../assets/media/heroicons/outline/search.svg" alt="Search icon"> -->
                                   </span>
                               </div>
                           </div>
                       </div>

                   </div>
                   <!-- Search End -->

                   <!-- Chat Content Start-->
                   <div class="chat-content p-2">
                       <div class="container">

                           <div id="message-container"></div>
                       </div>

                       <!-- Scroll to finish -->
                       <div class="chat-finished" id="chat-finished"></div>
                   </div>
                   <!-- Chat Content End-->

                   <form method="post" enctype="multipart/form-data" id="send_container_messge">
                       <!-- Chat Footer Start-->
                       <div class="chat-footer">
                           <div class="form-row">
                               <!-- Chat Input Group Start -->
                               <div class="col">
                                   <div class="input-group">
                                       <!-- Attachment Start -->
                                       <div class="input-group-prepend mr-sm-2 mr-1">
                                           <div class="dropdown">
                                               <button
                                                   class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted text-muted"
                                                   type="button" data-toggle="dropdown" aria-haspopup="true"
                                                   aria-expanded="false">
                                                   <!-- Default :: Inline SVG -->
                                                   <svg class="hw-20" fill="none" viewBox="0 0 24 24"
                                                       stroke="currentColor">
                                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                           d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z">
                                                       </path>
                                                   </svg>

                                                   <!-- Alternate :: External File link -->
                                                   <!-- <img class="injectable hw-20" src="./../assets/media/heroicons/outline/plus-circle.svg" alt=""> -->
                                               </button>
                                               <div class="dropdown-menu">
                                                   <div class="file_choosen_trigger">
                                                       <a class="dropdown-item" href="#">
                                                           <!-- Default :: Inline SVG -->
                                                           <svg class="hw-20 mr-2" fill="none" viewBox="0 0 24 24"
                                                               stroke="currentColor">
                                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                                   stroke-width="2"
                                                                   d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                           </svg>

                                                           <!-- Alternate :: External File link -->
                                                           <!-- <img class="injectable hw-20 mr-2" src="./../assets/media/heroicons/outline/photograph.svg" alt=""> -->
                                                           <span><input type="file" class="hide_file" name="files"
                                                                   onchange="readURL(this);" id="image"
                                                                   style="display: none;">
                                                               Gallery</span>
                                                       </a>
                                                   </div>

                                               </div>
                                           </div>
                                       </div>
                                       <!-- Attachment End -->
                                       <input type="hidden" id="token" value="{{ csrf_token() }}">

                                       <!-- Textarea Start-->
                                       <input type="text" required autocomplete="off" name="message"
                                           class="form-control transparent-bg border-0 no-resize hide-scrollbar"
                                           placeholder="Write your message..." rows="1">
                                       <!-- Textarea End -->
                                   </div>
                               </div>
                               <input type="hidden" value="{{ Auth::user()->name }}" name="last_msg_from">
                               <!-- Chat Input Group End -->

                               <!-- Submit Button Start -->
                               <div class="col-auto">
                                   <button type="submit" class="btn btn-primary btn-icon rounded-circle text-light mb-1"
                                       role="button">
                                       <!-- Default :: Inline SVG -->
                                       <svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                               d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                       </svg>

                                       <!-- Alternate :: External File link -->
                                       <!-- <img src="./../assets/media/heroicons/outline/arrow-right.svg" alt="" class="injectable hw-24"> -->
                                   </button>
                               </div>
                               <!-- Submit Button End-->
                           </div>
                       </div>
                       <div class="container shadow p-3 mb-5 bg-white rounded" id="image_display">
                           <button type="reset" onclick="myFunction()" class="close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                           <img class="injectable hw-20 img-thumbnail" id="blah" src="#">

                       </div>
               </div>
               <!-- Chat Body End -->
               </form>

               <!-- Chat Info Start -->
               <div class="chat-info">
                   <div class="d-flex h-100 flex-column">

                       <!-- Chat Info Header Start -->
                       <div class="chat-info-header px-2">
                           <div class="container-fluid">
                               <ul class="nav justify-content-between align-items-center">
                                   <!-- Sidebar Title Start -->
                                   <li class="text-center">
                                       <h5 class="text-truncate mb-0">Group Details</h5>
                                   </li>
                                   <!-- Sidebar Title End -->

                                   <!-- Close Sidebar Start -->
                                   <li class="nav-item list-inline-item">
                                       <a class="nav-link text-muted px-0" href="#" data-chat-info-close="">

                                           <svg class="hw-22" fill="none" viewBox="0 0 24 24"
                                               stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                   d="M6 18L18 6M6 6l12 12"></path>
                                           </svg>

                                           <!-- <img class="injectable hw-22" src="./../assets/media/heroicons/outline/x.svg" alt=""> -->

                                       </a>
                                   </li>
                                   <!-- Close Sidebar End -->
                               </ul>
                           </div>
                       </div>
                       <!-- Chat Info Header End  -->

                       <!-- Chat Info Body Start  -->
                       <div class="hide-scrollbar flex-fill">
                           <!-- User Profile Start -->
                           <div class="border-bottom text-center p-3">

                               <!-- User Profile Picture -->
                               <div class="avatar bg-success text-light avatar-xl mx-5 mb-3">
                                   <span>
                                       <img class="injectable hw-50"
                                           src="{{ asset('/group_thumb') }}/{{ $group_details->group_thumb }}" alt="">
                                   </span>
                               </div>

                               <!-- User Info -->
                               <h5 class="mb-1">{{ $group_details->group_name }}</h5>
                               <p class="text-muted d-flex align-items-center justify-content-center">
                                   <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                           d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                       </path>
                                   </svg> &nbsp;

                                   <!-- <img class="injectable mr-1 hw-18" src="./../assets/media/heroicons/outline/location-marker.svg" alt=""> -->
                                   <span>{{ $count_members }} Participants</span>
                               </p>
                           </div>
                           <!-- User Profile End -->


                           <!-- Participants Start -->
                           <div class="chat-info-group">
                               <a class="chat-info-group-header" data-toggle="collapse" href="#participants-list"
                                   role="button" aria-expanded="true" aria-controls="participants-list">
                                   <h6 class="mb-0">Group Participants</h6>

                                   <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                           d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                       </path>
                                   </svg>
                                   <!-- <img class="injectable text-muted hw-20" src="./../assets/media/heroicons/outline/user-group.svg" alt=""> -->
                               </a>

                               <div class="chat-info-group-body collapse show" id="participants-list">
                                   <div class="chat-info-group-content list-item-has-padding">
                                       <!-- List Group Start -->
                                       <ul class="list-group list-group-flush">
                                           @foreach ($member as $members)
                                               @php
                                                   $member_details = App\Models\User::where('id', $members->participant_id)->first();
                                               @endphp
                                               <!-- List Group Item Start -->
                                               <li class="list-group-item">
                                                   <div class="media align-items-center">
                                                       <div class="avatar mr-2">
                                                           <img src="{{ $member_details->image() }}" alt="">
                                                       </div>

                                                       <div class="media-body">
                                                           <h6 class="text-truncate">
                                                               <a href="#"
                                                                   class="text-reset">{{ $member_details->username }}</a>
                                                           </h6>
                                                       </div>

                                                       <div class="media-options ml-1">
                                                           <div class="dropdown">
                                                               <button
                                                                   class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted"
                                                                   type="button" data-toggle="dropdown" aria-haspopup="true"
                                                                   aria-expanded="false">
                                                                   <svg class="hw-20" fill="none"
                                                                       viewBox="0 0 24 24" stroke="currentColor">
                                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                                           stroke-width="2"
                                                                           d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                                       </path>
                                                                   </svg>
                                                                   <!-- <img class="injectable hw-20" src="./../assets/media/heroicons/outline/dots-vertical.svg" alt=""> -->
                                                               </button>
                                                               <div class="dropdown-menu">
                                                                   @if ($group_details->group_host == Auth::user()->id)
                                                                       <a class="dropdown-item"
                                                                           href="/make_host/{{ $member_details->id }}/{{ $group_details->id }}">Make
                                                                           host</a>
                                                                       <a class="dropdown-item"
                                                                           href="/kick_out/{{ $member_details->id }}/{{ $group_details->id }}">Kick
                                                                           out
                                                                           from
                                                                           group</a>
                                                                   @endif
                                                                   <a class="dropdown-item"
                                                                       href="/Conversation/{{ $member_details->id }}/{{ str_replace(' ', '-', $member_details->name) }}">Message</a>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </li>

                                               <!-- List Group Item End -->
                                           @endforeach

                                       </ul>
                                       <!-- List Group End -->
                                   </div>
                               </div>
                           </div>
                           <!-- Participants End -->

                           <!-- Shared Media Start -->
                           <div class="chat-info-group">
                               <a class="chat-info-group-header" data-toggle="collapse" href="#shared-media" role="button"
                                   aria-expanded="true" aria-controls="shared-media">
                                   <h6 class="mb-0">Last Media</h6>

                                   <!-- Default :: Inline SVG -->
                                   <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                           d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                       </path>
                                   </svg>

                                   <!-- Alternate :: External File link -->
                                   <!-- <img class="injectable text-muted hw-20" src="./../assets/media/heroicons/outline/photograph.svg" alt=""> -->

                               </a>

                               <div class="chat-info-group-body collapse show" id="shared-media">
                                   <div class="chat-info-group-content">
                                       <!-- Shared Media -->
                                       <div class="form-row" id="shared-media">

                                       </div>
                                   </div>
                               </div>
                           </div>
                           <!-- Shared Media End -->

                           <!-- Shared Files Start -->
                           <div class="chat-info-group">
                               <a class="chat-info-group-header" data-toggle="collapse" href="#shared-files" role="button"
                                   aria-expanded="true" aria-controls="shared-files">
                                   <h6 class="mb-0">Documents</h6>
                                   <!-- Default :: Inline SVG -->
                                   <svg class="hw-20 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                           d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                       </path>
                                   </svg>

                                   <!-- Alternate :: External File link -->
                                   <!-- <img class="injectable text-muted hw-20" src="./../assets/media/heroicons/outline/document.svg" alt=""> -->
                               </a>

                               <div class="chat-info-group-body collapse show" id="shared-files">
                                   <div class="chat-info-group-content list-item-has-padding">
                                       <!-- List Group Start -->
                                       <ul class="list-group list-group-flush" id="shared-docs">

                                           <!-- List Group Item End -->

                                       </ul>
                                       <!-- List Group End -->
                                   </div>
                               </div>
                           </div>
                           <!-- Shared Files End -->


                       </div>
                       <!-- Chat Info Body Start  -->

                   </div>
               </div>
               <!-- Chat Info End -->
           </div>

           <div class="backdrop"></div>

           <!-- All Modals End -->
           </div>
           <!-- Main Layout End -->

           <script>
               // Add record
               $('#send_container_messge').submit(function(e) {


                   e.preventDefault();
                   var username = $('#message_content').val();

                   var form = new FormData(document.getElementById('send_container_messge'));
                   var token = $('#token').val();
                   form.append('_token', token);
                   var x = document.getElementById("myAudio");

                   $.ajax({
                       url: '/send_message_to_group/{{ $id }}',
                       type: 'post',
                       data: form,
                       cache: false,
                       contentType: false, //must, tell jQuery not to process the data
                       processData: false,

                       success: function(response) {


                           var xdiv = document.getElementById("image_display");
                           xdiv.style.display = "none";

                           document.getElementById("send_container_messge").reset();

                           $("#message-container").animate({
                               scrollTop: $('#message-container').get(0).scrollHeight
                           }, 3000);
                           // console.log({'message': username});

                       }
                   });


               });
           </script>


           <script>
               var reff = firebase.database().ref(
                   "group_id_{{ $id }}/group_messages");
               reff.on('child_added', function(snapshot) {

                   var AuthName = '{{ auth()->user()->username }}'
                   var myname = "{{ Auth::user()->username }}";



                   var name = (myname == snapshot.val().sender_name) ? myname : snapshot.val().sender_name;




                   var image_tag = "";
                   if (snapshot.val().file == "") {

                       image_tag = "";
                   } else if (snapshot.val().file_type == "image") {

                       var recent_images =
                           '<div class="col-4 col-md-2 col-xl-4"><a href="#"><img src="{{ asset('/message_media') }}/' +
                           snapshot.val().files + '" class="img-fluid rounded border" alt=""></a></div>';

                       $("#shared-media").append(recent_images);

                       image_tag = '<a class="popup-media" href="{{ asset('/message_media') }}/' + snapshot.val()
                           .files +
                           '"><img class="img-fluid rounded" src="{{ asset('/message_media') }}/' + snapshot.val()
                           .files +
                           '"></a>';

                   } else if (snapshot.val().file_type == "video") {

                       var recent_images =
                           '<div class="col-4 col-md-2 col-xl-4"><a href="#"><video class="img-fluid rounded border" width="400" controls><source src="{{ asset('/message_media') }}/' +
                           snapshot.val().files + '" type="video/mp4"><source src="{{ asset('/message_media') }}/' +
                           snapshot.val().files + '" type="video/ogg"></video></a></div>';

                       $("#shared-media").append(recent_images);

                       image_tag =
                           '   <div class="document"><div class="btn btn-primary btn-icon rounded-circle text-light mr-2"><svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div><div class="document-body"><h6><a href="#" class="text-reset" title="' +
                           snapshot.val().files + '">' + snapshot.val().files + '</a></h6></div></div>';

                   } else if (snapshot.val().file_type == "document") {
                       var recent_docs =
                           '<li class="list-group-item"><div class="document"><div class="btn btn-primary btn-icon rounded-circle text-light mr-2"><svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg> </div><div class="document-body"><h6 class="text-truncate"><a href="#" class="text-reset" title="' +
                           snapshot.val().files + '">' + snapshot.val().files +
                           '</a></h6><ul class="list-inline small mb-0"><li class="list-inline-item"><span class="text-muted text-uppercase">docs</span></li></ul></div><div class="document-options ml-1"><div class="dropdown"><button class="btn btn-secondary btn-icon btn-minimal btn-sm text-muted" type="button"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg class="hw-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg> </button><div class="dropdown-menu"><a class="dropdown-item" href="{{ asset('/message_media') }}/' +
                           snapshot.val().files + '" download="{{ asset('/message_media') }}/' + snapshot.val().files +
                           '">Download</a></div></div></div></div></li>';


                       image_tag =
                           '<div class="document"><div class="btn btn-primary btn-icon rounded-circle text-light mr-2"><svg class="hw-24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div><div class="document-body"><h6><a href="#" class="text-reset" title="' +
                           snapshot.val().files + '">' + snapshot.val().files + '</a></h6></div></div>';
                       $("#shared-docs").append(recent_docs);
                   }

                   if (name == AuthName) {

                       var block =
                           '  <div class="message self"><div class="message-wrapper"><div class="message-content"><h6 class="text-light">' +
                           snapshot.val().sender_name + '</h6><span>' + snapshot.val().text + '</span>' + image_tag +
                           '</div></div><div class="message-options"><div class="avatar avatar-sm"><img alt="" src="{{ Auth::user()->image() }}"></div><span class="message-date">'
                       snapshot.val().date + '</span></div></div>';

                       $("#message-container").append(block);
                       window.scrollTo(0, document.body.scrollHeight);


                   } else {

                       var block2 =
                           '<div class="message"><div class="message-wrapper"><div class="message-content"><h6 class="text-dark">' +
                           snapshot.val().sender_name + '</h6><span>' + snapshot.val().text + '</span>' + image_tag +
                           '</div></div><div class="message-options"><div class="avatar avatar-sm"><img alt="" src="./../assets/media/avatar/1.png"></div><span class="message-date">'
                       snapshot.val().date + '</span></div></div> ';

                       $("#message-container").append(block2);

                       window.scrollTo(0, document.body.scrollHeight);

                   }

               });
           </script>




           <script type="text/javascript">
               $('.file_choosen_trigger').bind("click", function() {

                   $('#image')[0].click();
               });
           </script>
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

       @endsection
