<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
    ?>
    <div class="container mt-4">
      <div class="row">
        <div class="col text-end">
            <!-- Create Post Button -->
            <a href="/admin/categories/create" class="btn btn-success me-2">Create Category</a>
            <!-- Create Category Button -->
            <a href="/admin/posts/" class="btn btn-success">View Posts</a>
        </div>
    </div>

    <h2 class="card-title">Categories</h2>
    <?php foreach ($categories as $category): ?>
        <div class="mb-3 mt-2 card">
          <div class="card-body">
            <p class="card-text"><?php echo htmlspecialchars($category->name, ENT_QUOTES); ?></p>
                <a href="/admin/categories/edit/<?php echo $category->id; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/admin/categories/posts/<?php echo $category->id; ?>" class="btn btn-warning btn-sm">View Post</a>
                <form method="POST" action="/admin/categories/delete/<?php echo $category->id ?>" class="d-inline">
                    <button type="button" onclick="deleteCategory(<?php echo $category->id ?>)" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php';
?>