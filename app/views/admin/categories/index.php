<div>
    <div style="text-align: right; margin-bottom: 20px;">
        <!-- Create Category Button -->
        <a href="/admin/categories/create">Create Category</a>
        <!-- View Posts Button -->
        <a href="/admin/posts/">View Posts</a>
    </div>

    <?php foreach ($categories as $category): ?>
        <div style="margin-bottom: 20px; margin-top: 20px;">
            <div>
                <h2>Categories</h2>
                <p><?php echo htmlspecialchars($category->name, ENT_QUOTES); ?></p>
                <a href="/admin/categories/edit/<?php echo $category->id; ?>">Edit</a>
                <a href="/admin/categories/posts/<?php echo $category->id; ?>">View Posts</a>
                <form action="/admin/categories/delete/<?php echo $category->id; ?>" method="POST" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
