<div class="contact-profile">
    <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
    <p>Harvey Specter</p>
    <div class="social-media">
        <i class="fa fa-facebook" aria-hidden="true"></i>
        <i class="fa fa-twitter" aria-hidden="true"></i>
        <i class="fa fa-instagram" aria-hidden="true"></i>
    </div>
</div>
<div class="messages">
    <ul>
        @foreach ($messages as $item)
        <li class="@if ($item->sender_id == Auth::id()) sent @else replies @endif">
            <img src="@if ($item->sender_id == Auth::id()){{ asset('storage/profile_pict/'.$item->sender_pp) }} @else {{ asset('storage/profile_pict/'.$item->recipient_pp ) }} @endif"
                alt="" />
            <p>{{$item->text}}</p>
        </li>
        @endforeach

    </ul>
</div>
<div class="message-input">
    <div class="wrap">
        <form method="POST" autocomplete="off" action="/chat" enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="Write your message..." />
            <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
            <button type="submit" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
</div>