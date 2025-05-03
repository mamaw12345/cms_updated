<div>
    <script src="https://cdn.tiny.cloud/1/0r2d7yxc2qi93i6zu1szgj6e1nhjff1gzi2kaab18b8nw7wb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinymce-editor',
            height: 300,
            menubar: false,
            plugins: 'lists link image preview code',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | preview code',
            branding: false,
            setup: function(editor) {
                editor.on('input', function() {
                    if (typeof updatePreview === 'function') {
                        updatePreview();
                    }
                });
                editor.on('change', function() {
                    if (typeof updatePreview === 'function') {
                        updatePreview();
                    }
                });
            },
            init_instance_callback: function(editor) {
                if (typeof updatePreview === 'function') {
                    updatePreview();
                }
            }
        });
    </script>
</div>
