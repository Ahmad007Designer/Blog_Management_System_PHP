<?= view('auth/header') ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h4 class="mb-0">Edit Post</h4>
            <a href="<?= base_url('posts/my-posts') ?>" class="btn text-white" style="background-color: rgb(240, 131, 6);">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to My Posts
            </a>
        </div>

        <div class="card-body">
            <form id="postForm" action="<?= base_url('posts/update/' . $post['id']) ?>" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Title</label>
                    <input type="text" name="title" id="title" value="<?= esc($post['title']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label fw-semibold">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="6" required><?= esc($post['content']) ?></textarea>
                </div>

                <div class="text-end">
                    <button type="button" id="updateBtn" class="btn text-white px-4" style="background-color: rgb(240, 131, 6);">
                        <i class="bi bi-save me-1"></i> Update Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CKEditor Script -->
<script src="<?= base_url('assets/ckeditor/ckeedit.js') ?>"></script>

<!-- Init CKEditor and Submit Handler -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('content')) {
            CKEDITOR.replace('content');
        }

        document.getElementById('updateBtn').addEventListener('click', function () {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement(); // Sync CKEditor content
            }

            document.getElementById('postForm').submit();
        });
    });
</script>

<?= view('auth/footer') ?>
