<style>
    .custom-alert-container {
        max-width: 650px;      
        margin: 1rem auto; 
    }
    .custom-alert {
        border-radius: 0.5rem;
        padding: 0.75rem 1.25rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        font-size: 1rem;
    }
</style>

<div class="custom-alert-container">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
         </div>
    <?php endif; ?>


</div>
