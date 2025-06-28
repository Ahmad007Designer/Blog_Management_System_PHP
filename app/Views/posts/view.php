<?= view('auth/header') ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-white" style="background:rgba(0, 128, 128, 1);">
            <h4><strong>Title:</strong> <?= esc($post['title']) ?></h4>
        </div>
        <div class="card-body">
            <p><strong>Author:</strong> <?= esc($post['author']) ?></p>
            <p><strong>Created At:</strong> <?= date('d M Y h:i A', strtotime($post['created_at'])) ?></p>
            <p><strong>Updated At:</strong> <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?></p>
            <hr>
            <div><?= $post['content'] ?></div>
            <a href="<?= base_url('posts/list') ?>" class="btn mt-3 text-white" style="background:rgb(240, 131, 6);">Back to Posts</a>
        </div>
    </div>
</div>

<?= view('auth/footer') ?>
