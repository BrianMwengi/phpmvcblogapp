<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
    ?>
<div class="container mt-4">
    <form method="POST" action="/admin/categories/update/<?php echo $category->id; ?>" class="mb-3">
        <input type="hidden" name="id" value="<?php echo $category->id; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category->name, ENT_QUOTES); ?>" class="form-control" required>
        </div>
        <!-- Add more input fields for other category properties... -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>