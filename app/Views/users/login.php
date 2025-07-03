<?= view('users/header') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg" style="background-color: rgba(245, 245, 245, 1); border: none;">
                <div class="card-header text-center" style="background-color: transparent; border-bottom: none;">
                    <img src="<?= base_url('assets/images/blog.png') ?>" alt="Logo" class="img-fluid" style="max-height: 50px;">
                    <h2 style="color: rgba(0, 128, 128, 1); font-size: 2.5rem; font-weight: bold;">Login</h2>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('users/login') ?>" method="post">
                        <div class="mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" style="border: 1px solid rgba(190, 200, 200, 1); background-color: rgba(220, 230, 230, 0.4); padding: 0.50rem 1rem;" required>
                        </div>

                        <div class="mb-4"> <input type="password" name="password" id="password" class="form-control " placeholder="Password" style="border: 1px solid rgba(190, 200, 200, 1); background-color: rgba(220, 230, 230, 0.4); padding: 0.50 rem 1rem;" required>
                        </div>

                        <div class="d-grid mb-3"> <button
                                style="background: rgba(240, 131, 6); color: white; padding: 0.50rem 1rem; font-size: 1.25rem; font-weight: bold; border: none; border-radius: 0.3rem;"
                                type="submit" class="btn">Login</button>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="<?=base_url('users/register')?>" style="color: rgba(0, 128, 128, 1); font-size: 1.1rem; text-decoration: none;">Create an account?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('users/footer') ?>