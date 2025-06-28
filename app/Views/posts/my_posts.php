<?= view('auth/header') ?>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center bg-light border-bottom">
            <h4 class="mb-0">My Posts</h4>

            <a href="<?= base_url('posts/list') ?>" class="btn text-white" style="background-color: rgb(240, 131, 6);">
                <i class="bi bi-arrow-left-circle"></i> Back to All Posts
            </a>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Author</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= esc($post['id']) ?></td>
                            <td><?= esc($post['title']) ?></td>
                            <td class="text-start text-truncate" style="max-width: 300px;">
                                <?= esc(strip_tags($post['content'])) ?>
                            </td>
                            <td><?= esc($post['author']) ?></td>
                            <td><?= esc($post['created_at']) ?></td>
                            <td>
                                <a href="<?= base_url('posts/view/' . $post['id']) ?>"
                                    class="btn btn-sm text-white" title="View" style="background-color: rgba(0, 128, 128, 1)">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= base_url('posts/edit/' . $post['id']) ?>"
                                    class="btn btn-sm text-white " title="Edit" style="background-color: rgb(240, 131, 6);">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('posts/delete/' . $post['id']) ?>"
                                    class="btn btn-sm btn-danger" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-muted">You haven't created any posts yet.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($pager)) : ?>
            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links('default', 'default_full') ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= view('auth/footer') ?>