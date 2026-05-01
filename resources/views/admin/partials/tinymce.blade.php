<script src="https://cdn.tiny.cloud/1/hp0zrc2bain21rty7jkk0rlr74to0bvo2hxjlo5v4ylxbg2p/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#content',
    height: 500,
    plugins: 'image link lists table code',
    toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link image | table | code',
    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3',
    images_upload_url: '/admin/upload-image',
    automatic_uploads: true,
    file_picker_types: 'image',
    images_upload_handler: function (blobInfo, success, failure) {
        let formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        fetch('/admin/upload-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(result => {
            success(result.location);
        })
        .catch(() => {
            failure('Image upload failed');
        });
    }
});
</script>
