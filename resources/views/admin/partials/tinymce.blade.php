<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '.tinymce',
    height: 480,
    menubar: false,
    plugins: 'lists link image table code',
    toolbar: 'undo redo | blocks | bold italic | bullist numlist | link image table | code',
    images_upload_url: '{{ route('admin.images.store') }}',
    images_upload_credentials: true,
    automatic_uploads: true,
    images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
        const data = new FormData();
        data.append('file', blobInfo.blob(), blobInfo.filename());
        fetch('{{ route('admin.images.store') }}', {
            method: 'POST',
            body: data,
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        }).then(r => r.json()).then(json => {
            tinymce.activeEditor?.notificationManager.open({text: json.message || 'Image uploaded successfully.', type: 'success'});
            resolve(json.location);
        }).catch(() => reject('Upload failed'));
    })
});
</script>
