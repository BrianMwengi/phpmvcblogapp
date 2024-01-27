<!-- admin/categories/posts.php -->
<div>
    <h2>Posts in Category: <?php echo htmlspecialchars($category->name, ENT_QUOTES); ?></h2>
    <?php if (!empty($posts)): ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h3>
                    <p><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
                    <!-- Add links for edit, delete, view, etc. here -->
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No posts found in this category.</p>
    <?php endif; ?>
</div>
