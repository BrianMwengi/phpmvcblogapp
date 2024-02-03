<?php
// Start output buffering to capture content for this page
ob_start();
?>
<!-- search-results.php -->
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="text-center mb-4">Search Results</h2>
            <?php if (empty($posts)): ?>
                <div class="alert alert-info text-center">No results found for your search.</div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h3>
                        </div>
                        <div class="card-body">
                            <!-- Display post image if available -->
                            <?php if ($post->image): ?>
                                <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" class="img-fluid mb-3">
                            <?php endif; ?>
                            <p class="card-text"><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
                            <!-- Display category if available -->
                            <p class="card-text">
                                <strong>Category:</strong> <?php echo $post->category_name ? htmlspecialchars($post->category_name, ENT_QUOTES) : 'No category'; ?>
                            </p>
                        </div>
                        <div class="card-footer text-muted">
                            <a href="/posts/show/<?php echo $post->id; ?>" class="btn btn-primary">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
// End buffering and store the content in $content
$content = ob_get_clean();

// Include the layout template, assuming it uses $content for page content
include BASE_DIR . '/public/Layouts/layout.php';
?>
