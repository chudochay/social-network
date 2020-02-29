<!-- Modal -->
<div class="modal fade"
     id="exampleModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{ asset($image->image_path) }}"
                     id="modal-image"
                     class="media-object"
                     alt="{{$image->id}}"
                     width="80%" height="auto"
                >
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Parsing file location using jQuery -->
<script>
    function passToModal(src) {
        $("#exampleModal").modal('show');
        $("#modal-image").attr('src', src)
    }
</script>





















