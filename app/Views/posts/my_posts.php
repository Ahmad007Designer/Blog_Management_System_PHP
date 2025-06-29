<?= view('auth/header') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center border-bottom bg-white py-3">
            <h4 class="mb-2 mb-md-0">My Posts</h4>
            <a href="<?= base_url('posts/list') ?>" class="btn text-white mt-2 mt-md-0" style="background-color: rgb(240, 131, 6);">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to All Posts
            </a>
        </div>

        <div class="card-body">
            <?php if (!empty($posts)): ?>
                <div class="row g-3">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-12">
                            <div class="card shadow-sm border-0" >
                                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3" style="background:rgb(214, 252, 252); border-radius:10px">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1"><?= esc($post['title']) ?></h5>
                                        <p class="truncate-text card-text mb-1"><?= esc(strip_tags($post['content'])) ?></p><small>By:</small>
                                        <small class="text fw-bold" style="color: rgba(0, 128, 128, 1);"> <?= esc($post['author']) ?> </small> </br>
                                        <small class="text">Created At: <?= date('d M Y h:i A', strtotime($post['created_at'])) ?></small> </br>
                                        <small class="text">Updated At: <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?></small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="<?= base_url('posts/view/' . $post['id']) ?>" class="btn btn-sm text-white" style="background-color: teal;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('posts/edit/' . $post['id']) ?>" class="btn btn-sm text-white" style="background-color: orange;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger delete-post" data-id="<?= esc($post['id']) ?>" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">You haven't created any posts yet.</p>
            <?php endif; ?>

            <?php if (!empty($pager)) : ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links('default', 'default_full') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- AJAX DELETE -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('click', '.delete-post', function () {
    const postId = $(this).data('id');
    const card = $(this).closest('.col-12');

    if (confirm('Are you sure you want to delete this post?')) {
        $.ajax({
            url: '<?= base_url('posts/delete') ?>/' + postId,
            type: 'POST',
            data: {
                _method: 'DELETE',
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            success: function (response) {
                if (response.status === 'success') {
                    card.fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('Server error. Try again.');
            }
        });
    }
});
</script>

<?= view('auth/footer') ?>
