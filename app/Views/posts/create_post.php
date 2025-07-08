<form id="createPostForm" method="POST">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" id="content" rows="10" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn text-white" style="background: rgba(0, 128, 128, 1);">Publish</button>
</form>
