<style>
    .file-preview {
        border-radius: 2px;
        transition: 0.3s;
        max-width: 270px;
        background: #435f7a;
        display: inline-block;
    }

    .container-file {
        padding: 8px 14px 8px 12px;
        color: #f5f5f5;
        line-height: 130%;
    }

    .file-show {
        border-top-left-radius: 2px !important;
        border-top-right-radius: 2px !important;
        width: 100% !important;
        margin: 0 !important;
        border-radius: 0 !important;
        float: none !important;
    }
</style>
<ul>
    @foreach ($messages as $item)
    <li class="@if ($item->sender_id == Auth::id()) sent @else replies @endif">
        <img src="{{asset('storage/profile_pict/'.$item->sender_pp) }}" alt="" />
        @if($item->type==null)
        <p>{{$item->text}}</p>
        @else
        <div class="file-preview">
            <img class="file-show" src="{{asset('storage/file/'.$item->file)}}" alt="image error" />
            @if($item->text!==null)
            <div class="container-file">
                {{$item->text}}
            </div>
            @endif
        </div>
        @endif
    </li>
    @endforeach
</ul>