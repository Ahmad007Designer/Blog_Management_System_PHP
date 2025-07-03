<div>
    <h4 class="fw-bold text-teal"><?= esc($post['title']) ?></h4>
    <p class="text-muted"><small>Created on <?= date('d M Y h:i A', strtotime($post['created_at'])) ?></small></p>
    <p class="mb-0"><strong>Author:</strong>
        <span class="text-teal"><?= esc($post['author']) ?></span>
    </p>
    <hr>
    <div><?= $post['content'] ?></div>
    <hr>
    
</div>
