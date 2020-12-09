<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Chat Interface Concept</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet'
        type='text/css'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://use.typekit.net/hoy3lrg.js"></script>
    <script>
        try{Typekit.load({ async: true });}catch(e){}
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('css/chat.css')}}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<style>
    
</style>

<body>
    <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
    <div id="frame">
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <img id="profile-img" src="{{asset('storage/profile_pict/'.$myprofile->profile_picture)}}"
                        class="online" alt="" />
                    @php
                    $name =explode(' ',$myprofile->name);
                    @endphp
                    <p><?php echo $name[0]." ".$name[1] ?> </p>
                    <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                    <div id="status-options">
                        <ul>
                            <li id="status-online" class="active"><span class="status-circle"></span>
                                <p>Online</p>
                            </li>
                            <li id="status-away"><span class="status-circle"></span>
                                <p>Away</p>
                            </li>
                            <li id="status-busy"><span class="status-circle"></span>
                                <p>Busy</p>
                            </li>
                            <li id="status-offline"><span class="status-circle"></span>
                                <p>Offline</p>
                            </li>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    LOGOUT
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </ul>
                    </div>
                    <div id="expanded">
                        <label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
                        <input name="twitter" type="text" value="mikeross" />
                        <label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
                        <input name="twitter" type="text" value="ross81" />
                        <label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
                        <input name="twitter" type="text" value="mike.ross" />
                    </div>
                </div>
            </div>
            <div id="search">
                <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                <input type="text" placeholder="Search contacts..." />
            </div>
            <div id="contacts">
                <ul>
                    @foreach ($contacts as $item)
                    <?php
                    $last = DB::table('messages as m')
                        ->select('m.*')
                        ->where([
                            ['m.recipient_id', '=', $item->id],
                            ['m.sender_id', '=', Auth::id()],
                         ])
                        ->orWhere([
                            ['m.recipient_id', '=', Auth::id()],
                            ['m.sender_id', '=', $item->id],
                        ])
                        ->orderBy('m.id', 'desc')
                        ->first();
                    ?>
                    <li class="contact" id="{{ $item->id }}">
                        <div class="wrap">
                            <span class="contact-status online"></span>
                            <img src="{{asset('storage/profile_pict/'.$item->profile_picture)}}" alt="" />
                            <div class="meta">
                                <p class="name">{{$item->name}}</p>
                                <p class="preview">@if (@$last->sender_id == Auth::id()) <span>You: </span> @endif
                                    {{@$last->text }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div id="bottom-bar">
                <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add
                        contact</span></button>
                <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
            </div>
        </div>
        <div class="content" id="content">

        </div>
    </div>
    <!-- partial -->
</body>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    var my_id = "{{ Auth::id() }}";
    var recepient_id = '';
    $(document).ready(function () {
        Pusher.logToConsole = true;
        var pusher = new Pusher('ea26d6c5f6515d01e62a', {
            cluster: 'ap1'
        });
        //Live channel
        var channel = pusher.subscribe('my-channel');
        channel.bind('message-sent', function(data) {
            // alert("idku "+ my_id + ",gambardiklik " + recepient_id + ",channel.from " + data.from + ",channel.to " + data.to);
            if(data.to == my_id  && data.from == recepient_id){
                loadChat();
                loadContact();
            }else if(data.from == my_id && data.to == recepient_id){
                loadChat();
                loadContact();
            }else{
                loadContact();
            }
         });
       
    });
</script>
<script type="text/javascript">
    $(document).on("click", ".contact", function(e) {
            $('.contact').removeClass('active');
            $(this).addClass('active');
            recipient_id = $(this).attr('id');
            // isi variable global kontak yang di klik
            recepient_id=recipient_id;
            $.ajax({
                type: "get",
                url: "chat/" + recipient_id, // get content
                data: "",
                cache: false,
                success: function (data) {
                    $('#content').html(data);
                    loadChat();
                }
            });
        });

    function loadChat(){
        $.ajax({
                type: "get",
                url: "chat/" + recipient_id + "/showMessages", // get content
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);
                    scrollToBottom();
                }
            });
    }
    function scrollToBottom(){
        $(".messages").animate({ 
            scrollTop: $(document).height() 
        }, 0);
    }

    function loadContact(){
        $.ajax({
                type: "get",
                url: "showContact", 
                data: "",
                cache: false,
                success: function (data) {
                    $('#contacts').html(data);
                }
            });
    }
</script>
<script>
    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
        
    });
    function submit() {
        newMessage();
    }

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
        newMessage();
        return false;
        }
    });
    function newMessage() {
        message = $("#text").val();
        if (message != '' && recepient_id != '') {
            $("#text").val('');
            $.ajax({
                type: "POST",
                url: "chat",
                data: {
                    _token: $("#csrf").val(),
                    recepient_id:recepient_id,text:message
                },
                cache: false,
                success: function (data) {
                },
                error: function (jqXHR, status, err) {
                },
                complete: function () {
                    scrollToBottom();
                }
            });
        }
    }


// $(".expand-button").click(function() {
//   $("#profile").toggleClass("expanded");
// 	$("#contacts").toggleClass("expanded");
// });

// $("#status-options ul li").click(function() {
// 	$("#profile-img").removeClass();
// 	$("#status-online").removeClass("active");
// 	$("#status-away").removeClass("active");
// 	$("#status-busy").removeClass("active");
// 	$("#status-offline").removeClass("active");
// 	$(this).addClass("active");
	
// 	if($("#status-online").hasClass("active")) {
// 		$("#profile-img").addClass("online");
// 	} else if ($("#status-away").hasClass("active")) {
// 		$("#profile-img").addClass("away");
// 	} else if ($("#status-busy").hasClass("active")) {
// 		$("#profile-img").addClass("busy");
// 	} else if ($("#status-offline").hasClass("active")) {
// 		$("#profile-img").addClass("offline");
// 	} else {
// 		$("#profile-img").removeClass();
// 	};
	
// 	$("#status-options").removeClass("active");
// });




</script>

</html>