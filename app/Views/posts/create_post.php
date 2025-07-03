<form id="createPostForm" method="POST">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" id="content" rows="10" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Publish</button>
</form>

<script>
(function () {
    const form = document.getElementById('createPostForm');
    if (!form) return;

    // Initialize CKEditor
    if (CKEDITOR.instances['content']) {
        CKEDITOR.instances['content'].destroy(true);
    }
    CKEDITOR.replace('content');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        formData.set('content', CKEDITOR.instances['content'].getData());

        fetch('<?= base_url('posts/store') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            // ✅ Close the modal
            document.getElementById('createPostModal').style.display = 'none';

            // ✅ Update the post list in the background
            const newDoc = new DOMParser().parseFromString(html, 'text/html');
            const updatedPosts = newDoc.querySelector('#postsContainer');
            if (updatedPosts) {
                document.getElementById('postsContainer').innerHTML = updatedPosts.innerHTML;
            }

            // ✅ Optional success alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3 shadow';
            alertDiv.style.zIndex = '9999';
            alertDiv.innerHTML = '✅ Post created and list updated!';
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        })
        .catch(err => {
            console.error(err);
            alert('❌ Error creating post.');
        });
    });
})();
</script>
