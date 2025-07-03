<form id="editPostForm" method="POST">
    <input type="hidden" name="id" value="<?= $post['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= esc($post['title']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea id="content" name="content" class="form-control" rows="6"><?= $post['content'] ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Update Post</button>
</form>

<!-- CKEditor Script -->
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<script>
function initCKEditor4() {
    console.log("Initializing CKEditor...");
    if (CKEDITOR.instances.content) {
        CKEDITOR.instances.content.destroy(true);
    }
    CKEDITOR.replace('content');
}
initCKEditor4(); // ✅ Call on load
</script>
