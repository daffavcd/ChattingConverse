<div class="contact-profile">
    <img src="{{ asset('storage/profile_pict/'.$to->profile_picture) }}" alt="" />
    <p>{{$to->name}}</p>
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
            <img src="{{asset('storage/profile_pict/'.$item->sender_pp) }}" alt="" />
            <p>{{$item->text}}</p>
        </li>
        @endforeach

    </ul>
</div>
<div class="message-input">
    <div class="wrap">
        @csrf
        <input type="text" autocomplete="off" id="text" name="text" placeholder="Write your message..." />
        <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
        <button onclick="submit()" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </div>
</div>
</div>