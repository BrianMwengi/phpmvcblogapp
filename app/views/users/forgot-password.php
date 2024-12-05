<!-- app/views/users/forgot-password.php -->
<?php ob_start(); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Reset Password</h3>
                    <!-- Display any form validation errors here -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <div id="message" class="alert alert-info">
                            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                        </div>
                    <?php endif; ?>
                    <form action="/users/reset-password-request" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="/users/login">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
include BASE_DIR . '/public/Layouts/layout.php';
?>