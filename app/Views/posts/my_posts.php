<?= view('users/header') ?>

<div class="container mt-5 p-4 shadow rounded" style="background-color: #fff; border: 1px solid #eee;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold mb-0" style="color: rgb(240, 131, 6);">My Blog Posts</h3>
        <a href="<?= base_url('posts/list') ?>" class="btn text-white" style="background-color: rgb(240, 131, 6);">
            <i class="bi bi-arrow-left-circle me-1"></i> Back to All Posts
        </a>
    </div>

    <?php if (!empty($posts)): ?>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-12 post-card">
                    <div class="card shadow-sm border-0" style="transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 0.75rem; overflow: hidden;">
                        <div class="card-body" style="background-color: rgb(214, 252, 252); cursor: pointer;">
                            <!-- Title + Action Buttons -->
                            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                                <h4 class="card-title fw-bold mb-2" style="color: rgba(0, 128, 128, 1);">
                                    <?= esc($post['title']) ?>
                                </h4>
                                <div class="d-flex flex-wrap gap-2" onclick="event.stopPropagation();">
                                    <button type="button" class="btn btn-sm text-white view-post-btn"
                                            data-id="<?= $post['id'] ?>" style="background-color: teal;" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm text-white btn-edit-post"
                                            data-id="<?= $post['id'] ?>" style="background-color: orange;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-post"
                                            data-id="<?= $post['id'] ?>" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Post content -->
                            <p class="truncate-text card-text text-muted mb-3">
                                <?= esc(strip_tags($post['content'])) ?>
                            </p>

                            <!-- Author and timestamps -->
                            <div class="text-end small text-secondary">
                                Created by:
                                <a href="<?= base_url('posts/author/' . urlencode($post['author'])) ?>"
                                   class="fw-semibold text-decoration-none" style="color: rgba(0, 128, 128, 1);">
                                    <?= esc($post['author']) ?>
                                </a>
                                | Created: <?= date('d M Y h:i A', strtotime($post['created_at'])) ?> |
                                Updated: <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($pager)) : ?>
            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">🛑 You haven't created any posts yet.</div>
    <?php endif; ?>
</div>

<!-- View Modal -->
<div id="viewPostModal" class="custom-modal-overlay" style="display:none;">
    <div class="custom-modal">
        <span class="close-btn">&times;</span>
        <div id="viewPostContent" class="p-3">
            <div class="text-center text-muted">Loading...</div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
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

    // Delete button with AJAX
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
