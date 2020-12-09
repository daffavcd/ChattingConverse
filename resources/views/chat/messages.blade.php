<ul>
    @foreach ($messages as $item)

    <li class="@if ($item->sender_id == Auth::id()) sent @else replies @endif">
        <img src="{{asset('storage/profile_pict/'.$item->sender_pp) }}" alt="" />
        <p>{{$item->text}}</p>
    </li>
    @endforeach

</ul>