<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
?>
<!-- Display message -->
<?php if (isset($_SESSION['message'])): ?>
    <div id="message" class="alert <?php echo strpos($_SESSION['message'], 'error') !== false ? 'alert-danger' : 'alert-success' ?> text-center">
        <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']);
            ?>
            </div>
<?php endif; ?>

    <div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Login</h4>
                    <!-- Login form -->
                    <form method="POST" action="/users/authenticate">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </form>
                                <div class="text-center mt-3">
                                <a href="/users/register">Not a member? Create Account</a>
                        </div>
                        <div class="text-center mt-2">
                            <a href="/users/forgot-password">Forgot Password?</a>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>

<script>
// JavaScript Timeout functionality for admin posts
window.onload = function() {
    setTimeout(function() {
        var messageElement = document.getElementById('message');
        if (messageElement) {
            messageElement.style.display = 'none';
        }
    }, 5000); // 5000 milliseconds = 5 seconds
};
</script>