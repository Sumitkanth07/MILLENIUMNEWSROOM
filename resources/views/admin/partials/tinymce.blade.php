@push('scripts')
<script>
tinymce.init({
    selector: '#content',
    height: 500,
    plugins: 'image link lists table code',
    toolbar: 'undo redo | bold italic underline | bullist numlist | link image | table | code',
    license_key: 'gpl'
});
</script>
@endpush
