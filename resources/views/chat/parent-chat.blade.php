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

<body>
    <div id="frame">
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <img id="profile-img" src="{{asset('storage/profile_pict/'.$myprofile->profile_picture)}}"
                        class="online" alt="" />
                    <p>{{ $myprofile->name}}</p>
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
                    <li class="contact" id="{{ $item->id }}">
                        <div class="wrap">
                            <span class="contact-status online"></span>
                            <img src="{{asset('storage/profile_pict/'.$item->profile_picture)}}" alt="" />
                            <div class="meta">
                                <p class="name">{{$item->name}}</p>
                                <p class="preview">You just got LITT up, Mike.</p>
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
@yield('script')
<script>
    $('.contact').click(function () {
            $('.contact').removeClass('active');
            $(this).addClass('active');
            recipient_id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "chat/" + recipient_id, // get content
                data: "",
                cache: false,
                success: function (data) {
                    $('#content').html(data);
                    // scrollToBottomFunc();
                }
            });
    });
</script>
<script>
    $(".messages").animate({ scrollTop: $(document).height() }, "fast");

$("#profile-img").click(function() {
	$("#status-options").toggleClass("active");
});

$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
	$("#contacts").toggleClass("expanded");
});

$("#status-options ul li").click(function() {
	$("#profile-img").removeClass();
	$("#status-online").removeClass("active");
	$("#status-away").removeClass("active");
	$("#status-busy").removeClass("active");
	$("#status-offline").removeClass("active");
	$(this).addClass("active");
	
	if($("#status-online").hasClass("active")) {
		$("#profile-img").addClass("online");
	} else if ($("#status-away").hasClass("active")) {
		$("#profile-img").addClass("away");
	} else if ($("#status-busy").hasClass("active")) {
		$("#profile-img").addClass("busy");
	} else if ($("#status-offline").hasClass("active")) {
		$("#profile-img").addClass("offline");
	} else {
		$("#profile-img").removeClass();
	};
	
	$("#status-options").removeClass("active");
});

function newMessage() {
	message = $(".message-input input").val();
	if($.trim(message) == '') {
		return false;
	}
	$('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
	$('.message-input input').val(null);
	$('.contact.active .preview').html('<span>You: </span>' + message);
	$(".messages").animate({ scrollTop: $(document).height() }, "fast");
};

$('.submit').click(function() {
  newMessage();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    newMessage();
    return false;
  }
});
</script>

</html>