<ul>
    <div class="loader"></div>
    <?php
        $check=0;
    ?>
    @foreach ($messages as $item)
    <?php
        if ($item->has_read==0 && $item->sender_id !=Auth::id()) {
            $check+=1;
        }
        if ($check==1) {
            ?>
    <div class="unread">
        <div class="unread2">{{@$total_unread->not_read}} UNREAD MESSAGES</div>
    </div>
    <?php
        }
    ?>
    <li class="@if ($item->sender_id == Auth::id()) sent @else replies @endif">
        <img src="{{asset('storage/profile_pict/'.$item->sender_pp) }}" alt="" />
        @if($item->type==null)
        <p>{{$item->text}}</p>
        @else
        @if($item->type=="image")
        <div class="file-preview" @if ($item->sender_id == Auth::id()) style="float:left !important;color: #f5f5f5;"
            @else
            style="float:right !important;background:#f5f5f5 !important" @endif>
            <img class="file-show image-show" src="{{asset('storage/file/'.$item->file)}}" title="{{$item->text}}"
                alt="image error" />
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
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>
<script>
    
    var modal = document.getElementById("myModal");
    
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
      
    $(document).on("click", ".image-show", function(e) {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.title;
        });
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
      modal.style.display = "none";
    }
</script>