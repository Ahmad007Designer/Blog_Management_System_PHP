<?= view('users/header') ?>

<div class="editor-wrapper mt-5">
  <div class="header-bar d-flex justify-content-end gap-2 mb-3">
    <div class="action-buttons">
      <a href="<?= base_url('posts/list') ?>" class="btn btn-primary">View Post</a>
      <a href="#" class="btn btn-danger">Delete</a>
      <button type="submit" form="postForm" class="btn btn-success">Save Post</button>
    </div>
  </div>

  <form action="<?= base_url('posts/create') ?>" method="POST" id="postForm">
    <div class="mb-3">
      <label for="title" class="form-label">Post Title:</label>
      <input type="text" name="title" class="form-control" placeholder="Latest Insights in Tech" required>
    </div>

    <div class="mb-3">
      <label for="content" class="form-label">Content:</label>
      <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
    </div>
  </form>
</div>

<?= view('users/footer') ?>
