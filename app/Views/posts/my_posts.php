<?= view('users/header') ?>

<div class="container mt-5 p-4 shadow rounded" style="background-color: #fff; border: 1px solid #eee;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold mb-0" style="color: rgb(240, 131, 6);">My Blog Posts</h3>
        <a href="<?= base_url('posts/list') ?>" class="btn text-white" style="background-color: rgb(240, 131, 6);">
            <i class="bi bi-arrow-left-circle me-1"></i> Back to All Posts
        </a>
    </div>

    <?php if (!empty($posts)): ?>
        <div class="row" id="postsContainer">
            <?php foreach ($posts as $post): ?>
                <div class="col-12 post-card mb-4" id="postctr-<?= $post['id']; ?>" data-author="<?= strtolower($post['author']) ?>">
                    <div class="card shadow-sm border-0" style="transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 0.75rem; overflow: hidden;">
                        <div class="card-body" style="background-color: rgb(214, 252, 252);">
                           
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
                            <p class="truncate-text card-text text-muted mb-3">
                                <?= esc(strip_tags($post['content'])) ?>
                            </p>

                            <div class="text-start small text-secondary">
                                <div>
                                Created by:
                                <a href="<?= base_url('posts/author/' . urlencode($post['author'])) ?>"
                                   class="fw-semibold text-decoration-none" style="color: rgba(0, 128, 128, 1);">
                                    <?= esc($post['author']) ?>
                                </a>
                                </div>
                            </div>
                            <div class="text-end small text-secondary">    
                                <div>Created: <?= date('d M Y h:i A', strtotime($post['created_at'])) ?></div>
                                <div>Updated: <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?></div>
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

<!-- view  Modal -->
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
    <span class="close-btn">&times;</span>
    <div id="editPostContent" class="p-3">
      <div class="text-center text-muted">Loading Editor...</div>
    </div>
  </div>
</div>

<?= view('users/footer') ?>



