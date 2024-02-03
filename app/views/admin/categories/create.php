<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
    ?>
<div class="container mt-4">
    <!-- View Category Button -->
    <div class="mb-4 text-end">
        <a href="/admin/categories/" class="btn btn-success">View Categories</a>
    </div>
    <form method="POST" action="/admin/categories/store" class="mb-3">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>