<?= view('auth/header') ?>

<div class="container mt-5">
    <h2>Edit Post</h2>
    <form action="<?= base_url('posts/update/' . $post['id']) ?>" method="post">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?= esc($post['title']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="5" required><?= esc($post['content']) ?></textarea>
        </div>
        <button class="btn text-white" style="background:rgb(240, 131, 6);">Update Post</button>
    </form>
</div>

<?= view('auth/footer') ?>
