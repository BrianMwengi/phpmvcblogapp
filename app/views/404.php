<?php
// Start output buffering to capture the 404 message
ob_start();
?>
<div class="container mt-4">
    <div class="text-center">
        <h1 class="display-1">404</h1>
        <p class="lead">Oops! The page you are looking for cannot be found.</p>
        <p>It might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="/" class="btn btn-primary">Go to Homepage</a>
    </div>
</div>
<?php
// End buffering and store the content in $content
$content = ob_get_clean();

// Include the layout, which uses $content
include BASE_DIR . '/public/Layouts/layout.php';
?>
