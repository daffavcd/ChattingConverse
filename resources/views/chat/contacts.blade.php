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
            <p class="preview">@if (@$last->sender_id == Auth::id()) <span>You: </span> @endif {{@$last->text }}</p>
            </div>
        </div>
    </li>
    @endforeach
</ul>