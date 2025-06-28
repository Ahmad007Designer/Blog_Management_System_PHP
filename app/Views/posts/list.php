<?= view('auth/header') ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center bg-white">
            <h4 class="mb-2 mb-md-0">All Posts</h4>
            <a href="<?= base_url('posts/create') ?>" class="btn btn-teal text-white"style="background-color: rgb(240, 131, 6);" >
                <i class="bi bi-plus-circle me-1"></i> Create New Post
            </a>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Author Name...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="postsTable">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Author</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($posts)): ?>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td><?= esc($post->id) ?></td>
                                    <td><?= esc($post->title) ?></td>
                                    <td class="text-start"><?= esc(strip_tags($post->content)) ?></td>
                                    <td><?= esc($post->author) ?></td>
                                    <td><?= esc($post->created_at) ?></td>
                                    <td>
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            <a href="<?= base_url('posts/view/' . $post->id) ?>" class="btn btn-sm  text-white" style="background-color: rgba(0, 128, 128, 1)" title="View" >
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('posts/edit/' . $post->id) ?>" class="btn btn-sm  text-white" style="background-color: rgb(240, 131, 6);" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="<?= base_url('posts/delete/' . $post->id) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No posts found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            

            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#postsTable tbody tr');

        rows.forEach(row => {
            const author = row.cells[3].textContent.toLowerCase();
            row.style.display = author.includes(query) ? '' : 'none';
        });
    });
</script>

<?= view('auth/footer') ?>
