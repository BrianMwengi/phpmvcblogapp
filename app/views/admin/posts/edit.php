<!--views/admin/posts/edit.php-->

<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
?>
<div class="container mt-4">
    <?php if ($post === null): ?>
        <div class="alert alert-warning">Post not found</div>
        <?php return; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['form_errors'] as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['form_errors']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/posts/update/<?php echo $post->id ?>" enctype="multipart/form-data" class="mb-3">
        <input type="hidden" name="id" value="<?php echo $post->id ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post->title, ENT_QUOTES); ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea id="content" name="content" class="form-control"><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" id="image" name="image" class="form-control">
            <?php if (!empty($post->image)): ?>
            <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" class="img-fluid mt-2" style="max-width: 200px;">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category:</label>
            <select id="category_id" name="category_id" class="form-select">
            <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category->id; ?>" <?php echo $category->id == $post->category_id ? 'selected' : ''; ?>>
            <?php echo $category->name; ?>
            </option>
            <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
<?php
$content = ob_get_clean(); // Store buffered content in $content
// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>

        
