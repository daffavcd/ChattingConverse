<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet'
        type='text/css'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://use.typekit.net/hoy3lrg.js"></script>
    <script>
        try {
            Typekit.load({
                async: true
            });
        } catch (e) {}
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <link rel="stylesheet" href="{{asset('css/chat.css')}}">
    <script src="{{ asset('js/app.js') }}"></script>

    <link rel="icon" href="{!! asset('image-core/title-icon.jpg') !!}">

</head>
<style>
    .btn .badge {
        position: relative;
        top: -1px;
    }

    .badge-light {
        color: #212529;
        background-color: #f8f9fa;
    }

    .badge {
        display: inline-block;
        padding: .25em .4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25rem;
        margin-top: 20px;
    }
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
                    <p><?php echo $name[0] . " " . $name[1] ?> </p>

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
                <input type="text" id="find_contact" placeholder="Search contacts..." />
            </div>
            <div id="contacts">
                <div style="text-align: center;display: none" id="loading_image">
                    <i class="fa fa-circle-o-notch fa-spin"
                        style="font-size:24px;font-size: 30px;margin-top: 25px;"></i>
                </div>
                <ul id="get_contact">
                    @foreach ($contacts as $item)
                    <?php
                    $notif = DB::table('messages as m')
                        ->select(DB::raw('count(*) as not_read'))
                        ->where([
                            ['m.recipient_id', '=', Auth::id()],
                            ['m.sender_id', '=', $item->id],
                        ])
                        ->where('has_read', 0)
                        ->first();
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
                        <div class="wrap" @if($notif->not_read==null) style="float:none" @endif>
                            <span class="contact-status online"></span>
                            <img src="{{asset('storage/profile_pict/'.$item->profile_picture)}}" alt="" />
                            <div class="meta" style="color: #e1f4f3">
                                <p class="name">{{$item->name}}</p>
                                <p class="preview">
                                    @if(@$last==null)
                                    <span>Type your first conversation </span>
                                    @else
                                    @if(@$last->sender_id == Auth::id())
                                    <span>You: </span>
                                    @endif
                                    @endif
                                    @if(@$last->type=='image')
                                    <i class="fa fa-camera "></i>&nbsp Photo
                                </p>
                                @elseif(@$last->type=='file')
                                <i class="fa fa-file-text "></i>&nbsp{{$last->file}}</p>
                                @else
                                {{@$last->text}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="notif" @if($notif->not_read==null) style="display:none" @endif>
                            <span class="badge badge-light">{{@$notif->not_read}}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div id="bottom-bar">
                <button id="addcontact">
                    <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>
                    <span>Add contact</span>
                </button>
                <!-- <button type="button" id="settings" data-toggle="modal" data-target="#settingsModal"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>          -->
                <a href="{{ route('logout') }}" id="settings" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="fa fa-cog fa-fw" aria-hidden="true"></i>Logout</span></a>
                </a>    

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- </button> -->
                {{-- @include('chat.settings') --}}
            </div>
        </div>
        <div class="content" id="content">
            <img src="{!! asset('image-core/doodledevil.jpg') !!}" style="width: 300px;margin-left: 330px;margin-top: 115px;" class="img-fluid" alt="bgchat">
        </div>
    </div>
    <!-- partial -->
</body>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
<script>
    $( "#find_contact" ).keyup(function() {
        key = $(this).val();
        if(key==''){
            key = 'kosong';
        }
        $.ajax({
            type: "get",
            url: "findContact/" + key, 
            data: "",
            cache: false,
            beforeSend: function() {
            $('#loading_image').show();
            $('#get_contact').hide();
            },
            success: function(data) {
                $('#get_contact').html(data);
                $('#get_contact').show();
                $('#loading_image').hide();
            }
        });
});
</script>
{{-- SCRIPT REALTIME --}}
<script>
    var my_id = "{{ Auth::id() }}";
    var recepient_id = null;
    $(document).ready(function() {

        Pusher.logToConsole = true;
        var pusher = new Pusher('ea26d6c5f6515d01e62a', {
            cluster: 'ap1'
        });
        //Live channel
        var channel = pusher.subscribe('my-channel_' + my_id);
        channel.bind('message-sent_' + my_id, function(data) {
            // alert("idku "+ my_id + ",gambardiklik " + recepient_id + ",channel.from " + data.from + ",channel.to " + data.to);
            if (recepient_id == data.from) {
                loadChat();
                loadContact(recepient_id);
            } else {
                loadContact(recepient_id);
            }
        });

    });
</script>

{{-- SCRIPT LOAD-LOAD GET --}}
<script type="text/javascript">
    $(document).on("click", ".contact", function(e) {
        $('.contact').removeClass('active');
        $(this).addClass('active');
        recipient_id = $(this).attr('id');
        // isi variable global kontak yang di klik
        recepient_id = recipient_id;
        $.ajax({
            type: "get",
            url: "chat/" + recipient_id, // get content
            data: "",
            cache: false,
            success: function(data) {
                $('#content').html(data);
                loadChat();
            }
        });
    });

    function loadChat() {
        $.ajax({
            type: "get",
            url: "chat/" + recipient_id + "/showMessages", // get content
            data: "",
            cache: false,
            success: function(data) {
                loadContact(recepient_id);
                $('#messages').html(data);
                scrollToBottom();
            }
        });
    }

    function scrollToBottom() {
        $(".messages").animate({
            scrollTop: $(".messages")[0].scrollHeight
        }, 0);
    }

    function loadContact(key) {
        $.ajax({
            type: "get",
            url: "showContact/" + key, //karena jika habis load html element tidak tercantum di dom.
            data: "",
            cache: false,
            success: function(data) {
                $('#get_contact').html(data);
            }
        });
    }
</script>
{{-- SCRIPT ACTION INPUT FORM --}}
<script>
    function submit() {
        newMessage();
    }

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
            newMessage();
            return false;
        }
    });
</script>
<script>
    function newMessage() {
        cek_upload = $("#upload").val()
        message = $("#text").val();
        type = $("#type").val();

        var date = '<?php echo date("ymdhis") ?>';
        var filename = date + '_' + $("#upload").val().split('\\').pop();
        var url = '{{ asset("storage/file") }}' + '/' + filename;

        var file_data = $("#upload").prop("files")[0];
        var form_data = new FormData();
        form_data.append("file", file_data)
        form_data.append("recepient_id", recepient_id) // Adding extra parameters to form_data
        form_data.append("_token", $("#csrf").val())
        form_data.append("text", message)
        form_data.append("type", type)
        form_data.append("date", date) // Adding extra parameters to form_data
        if ((message != '' && recepient_id != '' && cek_upload == '') || (recepient_id != '' && cek_upload != '')) {
            if (type == '') {
                $("#text").val('');

                $('<li class="sent"><img src="{{asset("storage/profile_pict/".$myprofile->profile_picture)}}" alt="" /><p>' +
                    message + '</p></li>').appendTo($('.messages ul'));
                $('.contact.active .preview').html('<span>You: </span>' + message);
            }
            $.ajax({
                type: "POST",
                url: "chat",
                processData: false, // important
                contentType: false, // important
                data: form_data,
                cache: false,
                success: function(data) {},
                error: function(jqXHR, status, err) {},
                complete: function() {
                    if (type == 'photo') {
                        $('#preview').fadeOut();
                        $('#messages').show();
                        $('#upload').val(null);
                        $("#text").prop('disabled', false);
                        $('#text').attr("placeholder", "Write your message...");
                        $("#text").val('');
                        $('<li class="sent"><img src="{{asset("storage/profile_pict/".$myprofile->profile_picture)}}" alt="" /><div class="file-preview" style="float:left !important;color: #f5f5f5;"><img class="file-show image-show" src="' +
                            url + '" title="' + message + '"alt="image error" />' +
                            (message != '' ? '<div class="container-file">' + message + '</div>' : '') +
                            '</div></li>').appendTo($('.messages ul'));
                        $('.contact.active .preview').html('<span>You: </span>' +
                            '<i class="fa fa-camera "></i>&nbspPhoto</p>');
                        $("#type").val('');
                    } else if (type == 'file') {
                        $('#preview').fadeOut();
                        $('#messages').show();
                        $('#upload').val(null);
                        $("#text").prop('disabled', false);
                        $('#text').attr("placeholder", "Write your message...");

                        $('<li class="sent"><img src="{{asset("storage/profile_pict/".$myprofile->profile_picture)}}" alt="" /><div class="file-preview-2" style="float:left !important;color: #f5f5f5;"><a href="' +
                            url +
                            '" class="link-file" target="_blank"><i class="fa fa-file" id="file_preview" aria-hidden="true"></i><p style="padding:0px" class="link-file">&nbsp;' +
                            filename + '</p></a></div></li>').appendTo($('.messages ul'));
                        $('.contact.active .preview').html('<span>You: </span>' +
                            '<i class="fa fa-file-text "></i>&nbsp' + filename + '</p>');
                        $("#type").val('');
                    }
                    scrollToBottom();
                }
            });
        }
    }
</script>
{{-- DROPDOWN SCRIPT --}}
<script>
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

    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");

    });
</script>

</html>