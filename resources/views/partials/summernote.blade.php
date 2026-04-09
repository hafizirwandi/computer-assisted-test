{{-- Summernote partial: @include('partials.summernote') --}}
{{-- Pastikan jQuery sudah dimuat sebelum include partial ini --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    /* Fix z-index issue where fullscreen/modals are hidden behind the Vuexy template */
    .note-editor.note-frame.fullscreen {
        z-index: 9999 !important;
        background-color: #fff !important;
    }

    .note-modal-backdrop {
        z-index: 10000 !important;
    }

    .note-modal {
        z-index: 10001 !important;
    }

    .note-popover.popover {
        z-index: 10002 !important;
    }

    .note-dropdown-menu {
        z-index: 10002 !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    function initSummernote(selector) {
        $(selector).summernote({
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
            callbacks: {
                onImageUpload: function(files) {
                    var editor = $(this);
                    uploadImageToServer(files[0], editor);
                }
            }
        });
    }

    function uploadImageToServer(file, $editor) {
        var formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route('soal.uploadImage') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.url) {
                    $editor.summernote('insertImage', response.url);
                } else {
                    alert('Upload gambar gagal: tidak ada URL yang dikembalikan.');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.error ?
                    xhr.responseJSON.error :
                    'Terjadi kesalahan saat mengupload gambar.';
                alert('Upload gambar gagal: ' + msg);
            }
        });
    }

    $(document).ready(function() {
        initSummernote('.summernote');
    });
</script>
