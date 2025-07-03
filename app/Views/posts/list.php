<?= view('users/header') ?>

<div class="container mt-5 p-4 shadow rounded" style="background-color: #fff; border: 1px solid #eee;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold mb-0" style="color: rgb(240, 131, 6);">All Blog Posts</h3>

        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('posts/my-posts') ?>" class="btn text-white"
               style="background-color: rgb(240, 131, 6);">
                <i class="bi bi-arrow-left-circle me-1"></i> My Posts
            </a>
            <button id="createPostBtn" class="btn text-white" style="background-color: rgb(240, 131, 6);">
                <i class="bi bi-plus-circle me-1"></i> Create New Post
            </button>


        </div>
    </div>

    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control shadow-sm"
               placeholder="🔍 Search by Author Name...">
    </div>

    <?php if (!empty($posts)): ?>
        <div class="row" id="postsContainer">
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

                <div class="col-12 post-card mb-4" data-author="<?= strtolower($post['author']) ?>">
                    <div class="card shadow-sm border-0" style="transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 0.75rem; overflow: hidden;">

                        <div class="card-body" style="background: rgb(214, 252, 252); cursor: pointer;">
                            <!-- Post title and action buttons -->
                            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                                <h4 class="card-title fw-bold mb-2" style="color: rgba(0, 128, 128, 1);">
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

                            <!-- Post content -->
                            <p class="truncate-text card-text text-muted mb-3"><?= esc(strip_tags($post['content'])) ?></p>

                            <!-- Author info -->
                            <div class="text-end small text-secondary">
                                Created by: 
                                <a href="<?= base_url('posts/author/' . urlencode($post['author'])) ?>"
                                   class="fw-semibold text-decoration-none"
                                   style="color: rgba(0, 128, 128, 1);">
                                   <?= esc($post['author']) ?>
                                </a>
                                | <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($pager)) : ?>
            <div class="d-flex justify-content-center mt-4 px-2">
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">No posts found.</div>
    <?php endif; ?>
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

<!-- Edit Post Modal Window -->
<div id="editPostModal" class="custom-modal-overlay" style="display: none;">
  <div class="custom-modal">
    <span class="close-btn" onclick="closeEditModal()">&times;</span>
    <div id="editPostContent" class="p-3">
      <div class="text-center text-muted">Loading Editor...</div>
    </div>
  </div>
</div>

<!-- Create Post Modal -->
<div id="createPostModal" class="custom-modal-overlay" style="display: none;">
  <div class="custom-modal" style="background: #fff; padding: 20px; border-radius: 10px; max-width: 700px; margin: 5% auto; position: relative;">
    <span class="close-btn" onclick="document.getElementById('createPostModal').style.display='none'" style="position:absolute;top:10px;right:15px;font-size:24px;cursor:pointer;">&times;</span>
    <div id="createPostContent">
      <div class="text-center text-muted">Loading form...</div>
    </div>
  </div>
</div>


<?= view('users/footer') ?>

<script src="<?= base_url('assets/js/jquery.js') ?>"></script>
<script src="<?= base_url('assets/js/post.js') ?>?v=<?= time() ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Search filter
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.post-card').forEach(card => {
            const author = card.getAttribute('data-author');
            card.style.display = author.includes(query) ? '' : 'none';
        });
    });

    // Prevent buttons from triggering card click
    document.querySelectorAll('.post-card .btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    });

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

<!-- for create -->
<script>
document.getElementById('createPostBtn').addEventListener('click', function () {
    const modal = document.getElementById('createPostModal');
    const content = document.getElementById('createPostContent');

    modal.style.display = 'block';
    content.innerHTML = '<div class="text-center text-muted">Loading form...</div>';

    fetch('<?= base_url('posts/create') ?>')
        .then(res => res.text())
        .then(html => {
            content.innerHTML = html;

            // Wait a moment before initializing CKEditor
            setTimeout(() => {
                if (CKEDITOR.instances['content']) {
                    CKEDITOR.instances['content'].destroy(true);
                }
                CKEDITOR.replace('content');
            }, 100);
        })
        .catch(err => {
            console.error(err);
            content.innerHTML = '<div class="text-danger">Failed to load form.</div>';
        });
});
</script>

