<?php
if (!$comment) {
    echo "<div class='alert alert-warning' role='alert'>Comment not found</div>";
    return;
}
?>
<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
    ?>
<div class="container mt-3">
    <form method="POST" action="/admin/comments/update/<?php echo $comment->id; ?>" class="needs-validation" novalidate>
        <input type="hidden" name="id" value="<?php echo $comment->id; ?>">
        <input type="hidden" name="post_id" value="<?php echo $comment->post_id; ?>">

        <div class="mb-3">
            <label for="content" class="form-label">Comment Content</label>
            <textarea id="content" name="content" class="form-control" required><?php echo htmlspecialchars($comment->content, ENT_QUOTES); ?></textarea>
            <div class="invalid-feedback">
                Please enter a comment content.
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
</div>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php';
?>