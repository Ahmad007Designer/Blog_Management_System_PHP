<?= view('users/header') ?>

<div class="container py-4">
    <div class="card shadow rounded-3 border-0">
        <div class="card-header bg-white py-4 text-center border-bottom">
            <div class="d-flex justify-content-center align-items-center mb-3 gap-2">
                <img src="<?= base_url('assets/images/blog.png') ?>" alt="Blogify Logo" width="40" height="40">
                <h1 class="fw-bold m-0" style="color: rgb(240, 131, 6); font-size: 2.2rem;">Blogify</h1>
            </div>
            <p class="text-muted fs-5 mb-1">Post Author</p>
            <h3 class="fw-bold" style="color: rgba(0, 128, 128, 1);"><?= esc($authorName) ?></h3>
            <p class="text-secondary mb-0">
                <span id="postCount"><?= $postCount ?></span> 
                Post<span id="postCountLabel"><?= $postCount != 1 ? 's' : '' ?></span> Published
            </p>
        </div>
        <div class="card-body px-4">
            <?php if (!empty($posts)): ?>
                <div class="row">
                     <?php foreach ($posts as $post): ?>
                        <div class="col-12 post-card mb-4" id="postctr-<?= $post['id']; ?>" data-author="<?= strtolower($post['author']) ?>">
                            <div class="card shadow-sm border-0" style="border-left: 4px solid rgb(240, 131, 6); background-color: rgb(214, 252, 252);">
                                <div class="card-body" style="background: rgb(214, 252, 252);">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2 ">
                                        <h4 class="fw-bold mb-2" style="color: rgba(0, 128, 128, 1);">
                                            <?= esc($post['title']) ?>
                                        </h4>
                                        <div class="d-flex flex-wrap gap-2" onclick="event.stopPropagation();">
                                            <button type="button" class="btn btn-sm text-white view-post-btn"
                                                    data-id="<?= $post['id'] ?>" style="background-color: teal;" title="View">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class=" truncate-text card-text text-muted mb-3"><?= esc(strip_tags($post['content'])) ?></p>
                                    <div class="text-end small text-secondary">
                                        <div>Created: <?= date('d M Y h:i A', strtotime($post['created_at'])) ?></div>
                                        <div>Updated: <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?></div>
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

<<!-- view  Modal -->
<div id="viewPostModal" class="custom-modal-overlay" style="display:none;">
    <div class="custom-modal">
        <span class="close-btn">&times;</span>
        <div id="viewPostContent" class="p-3">
            <div class="text-center text-muted">Loading...</div>
        </div>
    </div>
</div>

<?= view('users/footer') ?>

