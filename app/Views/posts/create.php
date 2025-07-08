<form id="createPostForm" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" id="content" class="form-control" rows="8" required></textarea>
    </div>
    <button type="submit" class="btn text-white" style="background: rgba(0, 128, 128, 1);">Publish</button>

    <script>
        setTimeout(() => {
            if (CKEDITOR.instances['content']) {
                CKEDITOR.instances['content'].destroy(true);
            }
            CKEDITOR.replace('content');
        }, 100);
    </script>
</form>
