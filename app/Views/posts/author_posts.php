<?= view('users/header') ?>

<div class="container py-4">
    <div class="card shadow rounded-3 border-0">
        <!-- Author Info Header -->
        <div class="card-header bg-white py-4 text-center border-bottom">
            <div class="d-flex justify-content-center align-items-center mb-3 gap-2">
                <img src="<?= base_url('assets/images/blog.png') ?>" alt="Blogify Logo" width="40" height="40">
                <h1 class="fw-bold m-0" style="color: rgb(240, 131, 6); font-size: 2.2rem;">Blogify</h1>
            </div>
            <p class="text-muted fs-5 mb-1">Post Author</p>
            <h3 class="fw-bold" style="color: rgba(0, 128, 128, 1);"><?= esc($authorName) ?></h3>
            <p class="text-secondary mb-0"><?= $postCount ?> Post<?= $postCount != 1 ? 's' : '' ?> Published</p>
        </div>

        <!-- Author Posts List -->
        <div class="card-body px-4">
            <?php if (!empty($posts)): ?>
                <div class="row g-4">
                    <?php foreach ($posts as $post): ?>
                        <?php 
                            $actionbtns = '';
                            if ($post['user_id'] == $_SESSION['user_id']) {
                                $actionbtns = '
                                    <button type="button" class="btn btn-sm text-white btn-edit-post"
                                        data-id="'. $post['id'] .'" style="background-color: orange;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-post" data-id="' . $post['id'] . '" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>';
                            }
                        ?>
                        <div class="col-12 post-card">
                            <div class="card shadow-sm border-0" style="border-left: 4px solid rgb(240, 131, 6); background-color: rgb(214, 252, 252);">
                                <div class="card-body" style="background: rgb(214, 252, 252);">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                        <h4 class="fw-bold mb-2" style="color: rgba(0, 128, 128, 1);">
                                            <?= esc($post['title']) ?>
                                        </h4>
                                        <div class="d-flex flex-wrap gap-2" onclick="event.stopPropagation();">
                                            <button type="button" class="btn btn-sm text-white view-post-btn"
                                                    data-id="<?= $post['id'] ?>" style="background-color: teal;" title="View">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <?= $actionbtns ?>
                                        </div>
                                    </div>
                                    <p class=" truncate-text card-text text-muted mb-3"><?= esc(strip_tags($post['content'])) ?></p>
                                    <div class="text-end small text-secondary">
                                        <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center mt-4">No posts found for this author.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Custom Modal -->
<div id="viewPostModal" class="custom-modal-overlay" style="display:none;">
    <div class="custom-modal">
        <span class="close-btn">&times;</span>
        <div id="viewPostContent" class="p-3">
            <div class="text-center text-muted">Loading...</div>
        </div>
    </div>
</div>

<!-- Edit Post Modal -->
<div id="editPostModal" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <div id="editPostContent" class="p-3">
            <div class="text-center text-muted">Loading Editor...</div>
        </div>
    </div>
</div>

<?= view('users/footer') ?>

<script src="<?= base_url('assets/js/jquery.js') ?>"></script>
<script src="<?= base_url('assets/js/post.js') ?>?v=<?= time() ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // AJAX Delete
    document.querySelectorAll('.delete-post').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const id = this.dataset.id;
            const postCard = this.closest('.post-card');

            if (confirm('Are you sure you want to delete this post?')) {
                fetch(`/posts/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: '_method=DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'deleted') {
                        alert('Post deleted successfully.');
                        postCard.remove();
                    } else {
                        alert('Failed to delete post.');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Error deleting post.');
                });
            }
        });
    });
});
</script>
