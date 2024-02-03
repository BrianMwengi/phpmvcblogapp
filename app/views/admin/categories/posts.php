<!-- admin/categories/posts.php -->
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
                    <a href="/path/to/edit/<?php echo $post->id; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="/path/to/delete/<?php echo $post->id; ?>" class="btn btn-danger btn-sm">Delete</a>
                    <a href="/path/to/view/<?php echo $post->id; ?>" class="btn btn-secondary btn-sm">View</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="alert alert-info">No posts found in this category.</p>
    <?php endif; ?>
</div>
