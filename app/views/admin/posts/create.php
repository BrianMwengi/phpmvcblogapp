<!-- views/admin/posts/create.php -->
<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
?>
<!-- admin/posts/create.php -->
<div class="container mt-4 mb-5">
    <!-- View all Post Button -->
    <div class="mb-4 text-end">
        <a href="/admin/posts/" class="btn btn-success">View Posts</a>
    </div>

    <h1 class="mb-4">Create Post</h1>
    
    <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['form_errors'] as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['form_errors']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/posts/store" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" id="title" name="title" class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea id="content" name="content" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category:</label>
            <select id="category_id" name="category_id" class="form-select">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>

