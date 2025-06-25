<?= view('auth/header') ?>

<div class="editor-wrapper mt-5">
  <div class="header-bar d-flex justify-content-end gap-2 mb-3">
    <div class="action-buttons">
      <a href="#" >View Post</a>
      <a href="#">Delete</a>
      <button type="submit" form="postForm" class="save-btn">Save Post</button>
    </div>
  </div>

  <form action="save-post.php" method="POST" id="postForm">
    <input type="text" name="title" class="title-input" placeholder="Latest Insights in Tech" required>
    <textarea name="content" id="editor"></textarea>
  </form>
</div>

<?= view('auth/footer') ?>
