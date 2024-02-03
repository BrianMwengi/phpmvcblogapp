<!-- admin/categories/posts.php -->
<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
?>
<div class="container mt-4">
    <h2 class="mb-3">Posts in Category: <?php echo htmlspecialchars($category->name, ENT_QUOTES); ?></h2>
    <?php if (!empty($posts)): ?>
        <div class="list-group">
            <?php foreach ($posts as $post): ?>
                <div class="list-group-item list-group-item-action">
                    <h3 class="h5"><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h3>
                    <p><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
                    <!-- Add links for edit, delete, view, etc. here -->
                    <!-- Example links (adjust href as necessary) -->
                    <a href="/admin/posts/edit/<?php echo $post->id; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <button type="button" onclick="deletePost(<?php echo $post->id; ?>)" class="btn btn-danger btn-sm">Delete</button>
                    <a href="/admin/posts/show/<?php echo $post->id; ?>" class="btn btn-secondary btn-sm">View</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="alert alert-info">No posts found in this category.</p>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean(); // Store buffered content in $content
// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>
