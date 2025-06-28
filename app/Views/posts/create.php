<?= view('auth/header') ?>

<div class="editor-wrapper mt-5">
  <div class="header-bar d-flex justify-content-end gap-2 mb-3">
    <div class="action-buttons">
      <a href="<?=base_url('posts/list') ?>" >View Post</a>
      <button type="submit" form="postForm" class="save-btn">Save Post</button>


    </div>
  </div>

  <form action="" method="POST" id="postForm">
    <label for="title">Post Title:</label>
    <input type="text" name="title" class="title" placeholder="Latest Insights in Tech" required>
    
    <label for="content">Content:</label>
    <textarea name="content" id="content" required></textarea>
  </form>
</div>

<script>
$(document).ready(function () {
  $('.save-btn').click(function () {
    $('#postForm').submit();
  });
});

</script>


<?= view('auth/footer') ?>
