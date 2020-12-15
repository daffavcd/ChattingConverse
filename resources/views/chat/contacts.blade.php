<ul>
    @foreach ($contacts as $item)
    <?php
     $notif=DB::table('messages as m')
        ->select(DB::raw('count(*) as not_read'))
        ->where([
            ['m.recipient_id', '=', Auth::id()],
            ['m.sender_id', '=', $item->id],
        ])
        ->where('has_read',0)
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
    <li class="contact @if (@$recipient_id == $item->id) active @endif" id="{{ $item->id }}">
        <div class="wrap" @if($notif->not_read==null) style="float:none" @endif>
            <span class="contact-status online"></span>
            <img src="{{asset('storage/profile_pict/'.$item->profile_picture)}}" alt="" />
            <div class="meta">
                <p class="name">{{$item->name}}</p>
                <p class="preview">
                    @if(@$last==null)
                    <span>Type your first conversation </span>
                    @else
                    @if(@$last->sender_id == Auth::id())
                    <span>You: </span>
                    @endif
                    @endif
                    @if(@$item->type=='image')
                    <i class="fa fa-camera "></i>Photo</p>
                @elseif(@$item->type=='file')
                <i class="fa fa-file-text "></i>{{$item->file}}</p>
                @else
                {{$item->text}}</p>
                @endif
            </div>
        </div>
        @if($notif->not_read!=null)
        <div class="notif">
            <span class="badge badge-light">{{@$notif->not_read}}</span>
        </div>
        @endif
    </li>
    @endforeach
</ul>