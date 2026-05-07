@push('scripts')
<script>
tinymce.init({
    selector: '#content',
    height: 500,
    plugins: 'image media link lists table code codesample preview wordcount',
    toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link image media | table codesample | preview code',
    image_title: true,
    automatic_uploads: true,
    file_picker_types: 'image',
    images_upload_url: '{{ route('admin.upload.image') }}',
    images_upload_credentials: true,
    images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('admin.upload.image') }}');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        xhr.upload.onprogress = (event) => progress(event.loaded / event.total * 100);
        xhr.onload = () => {
            if (xhr.status < 200 || xhr.status >= 300) {
                reject('Upload failed: ' + xhr.status);
                return;
            }
            const json = JSON.parse(xhr.responseText);
            resolve(json.location);
        };
        xhr.onerror = () => reject('Image upload failed.');
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    }),
    license_key: 'gpl'
});
</script>
@endpush
