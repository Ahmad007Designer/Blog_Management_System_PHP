<?= view('auth/header') ?>

<div class="container mt-5">
   <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="fw-bold mb-0">All Posts</h3>
    
    <div class="d-flex flex-wrap gap-2">
        <a href="<?= base_url('posts/my-posts') ?>" class="btn text-white" style="background-color: rgb(240, 131, 6);">
            <i class="bi bi-arrow-left-circle me-1"></i> Back My Posts
        </a>
        <a href="<?= base_url('posts/create') ?>" class="btn text-white" style="background-color: rgb(240, 131, 6);">
            <i class="bi bi-plus-circle me-1"></i> Create New Post
        </a>
    </div>
</div>


    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Author Name...">
    </div>

    <?php if (!empty($posts)): ?>
        <div class="row" id="postsContainer" >
            <?php foreach ($posts as $post): ?>
                <div class="col-md-12 mb-4 post-card" data-author="<?= strtolower($post['author']) ?>" >
                   <div class="card shadow-sm border-0 cursor-pointer"
                        onclick="window.location.href='<?= base_url('posts/view/' . $post['id']) ?>'"
                        style="transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 0.5rem; overflow: hidden;">

                        <div class="card-body" style="background: rgb(214, 252, 252);">
                            <h4 class="card-title fw-bold" style="color: rgba(0, 128, 128, 1);"><?= esc($post['title']) ?></h4>
                            <p class="truncate-text card-text text-muted"><?= esc(strip_tags($post['content'])) ?></p>
                            <div class="text-end small text-secondary">
                                Created by: <strong style="color: rgba(0, 128, 128, 1);"><?= esc($post['author']) ?></strong> |
                                <?= date('d M Y h:i A', strtotime($post['updated_at'])) ?>
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
        <div class="alert alert-info text-center">No posts found.</div>
    <?php endif; ?>
</div>

<script src="<?= base_url('assets/js/jQuery.js') ?>"></script>

<script>
    // Search filter
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.post-card').forEach(card => {
            const author = card.getAttribute('data-author');
            card.style.display = author.includes(query) ? '' : 'none';
        });
    });
</script>

<style>
    .cursor-pointer {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .cursor-pointer:hover {
        transform: scale(1.01);
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
</style>

<?= view('auth/footer') ?>
