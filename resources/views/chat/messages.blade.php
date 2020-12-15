<ul>
    @foreach ($messages as $item)
    <li class="@if ($item->sender_id == Auth::id()) sent @else replies @endif">
        <img src="{{asset('storage/profile_pict/'.$item->sender_pp) }}" alt="" />
        @if($item->type==null)
        <p>{{$item->text}}</p>
        @else
        @if($item->type=="image")
        <div class="file-preview" @if ($item->sender_id == Auth::id()) style="float:left !important;color: #f5f5f5;"
            @else
            style="float:right !important;background:#f5f5f5 !important" @endif>
            <img class="file-show" src="{{asset('storage/file/'.$item->file)}}" alt="image error" />
            @if($item->text!==null)
            <div class="container-file">
                {{$item->text}}
            </div>
            @endif
        </div>
        @elseif($item->type=="file")
        <div class="file-preview-2" @if ($item->sender_id == Auth::id()) style="float:left !important;color: #f5f5f5;"
            @else
            style="float:right !important;background:#f5f5f5 !important" @endif>
            <a href="{{asset('storage/file/'.$item->file)}}" class="link-file" target="_blank">
                <i class="fa fa-file" id="file_preview" aria-hidden="true">
                </i>
                <p style="padding:0px" class="link-file">&nbsp;{{$item->file}}</p>
            </a>
        </div>
        @endif

        @endif
    </li>
    @endforeach
</ul>