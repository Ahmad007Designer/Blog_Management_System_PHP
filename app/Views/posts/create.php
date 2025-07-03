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
document.getElementById('createPostForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.set('content', CKEDITOR.instances['content'].getData());

    fetch('<?= base_url('posts/store') ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Post created successfully!');
            location.reload();
        } else {
            alert('Failed to create post.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error creating post.');
    });
});
</script>
