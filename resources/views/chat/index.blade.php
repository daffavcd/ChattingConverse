<div class="contact-profile">
    <img src="{{ asset('storage/profile_pict/'.$to->profile_picture) }}" alt="" />
    <p>{{$to->name}}</p>
    <div class="social-media">
        <i class="fa fa-facebook" aria-hidden="true"></i>
        <i class="fa fa-twitter" aria-hidden="true"></i>
        <i class="fa fa-instagram" aria-hidden="true"></i>
    </div>
</div>
<div class="messages" id="messages">

</div>
<div class="preview" id="preview" style="display: none">
    <div class="tampil-content">
        <div class="tampil-header">
            <span class="tampil-close" onclick="closePreview()" style="cursor: pointer">&times;</span>
            <h2>Preview</h2>
        </div>
        <div class="tampil-body">
            <img class="tampung" id="image_preview" src="" alt="image error" />
            <i class="fa fa-file fa-2x" style="margin-top: 150px" id="file_wew" aria-hidden="true"></i><br><br>
            <p class="tampung" id="text_preview">awdwad.txt</p>
        </div>
    </div>
</div>
<div class="message-input">
    <div class="wrap">
        @csrf
        <input type="text" autocomplete="off" id="text" name="text" placeholder="Write your message..." />
        <input type="hidden" id="type">
        <input type="file" id="upload" style="display:none;"><i class="fa fa-paperclip attachment" id="upload_link"
            aria-hidden="true"></i></input>
        <button onclick="submit()" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </div>
</div>
</div>
<script>
    var text_name =null;
    $(function(){
    $("#upload_link").on('click', function(e){
        e.preventDefault();
        $("#upload:hidden").trigger('click');
        });
    });    
    function readURL(input) {
        var file = input.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];

        const size =  (input.files[0].size / 1024 / 1024).toFixed(2); 
        if(size > 2){
            alert('File must be less than 2 MB!');
            $('#upload').val(null);
        }else{
        if ($.inArray(fileType, validImageTypes) < 0) {
            $("#text").prop('disabled', true);
            $('#text').attr("placeholder", "You can't add caption on a document file.");
            $('#type').val('file');
            $('#file_wew').show();
            $('#image_preview').hide();
            $('#messages').hide();
            $('#text_preview').html(text_name);
            $('#preview').fadeIn();
        }else{
            if (input.files && input.files[0]) {
                $("#text").prop('disabled', false);
                $('#text').attr("placeholder", "Add a caption...");
                var reader = new FileReader();
                reader.onload = function (e) {
                   $('#image_preview').show();
                   $('#image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
                $('#file_wew').hide();
                $('#type').val('photo');
               $('#messages').hide();
               $('#text_preview').html(text_name);
               $('#preview').fadeIn();
           }
        }
    }
    
    }

$("#upload").change(function(){
    text_name =$("#upload").val().split('\\').pop();
    readURL(this);
});

function closePreview(){
    $('#preview').fadeOut();
    $("#text").prop('disabled', false);
    $('#text').attr("placeholder", "Write your message...");
    $('#messages').show();
    $('#upload').val(null);
}
</script>