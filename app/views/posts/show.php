<?php
// Generate the specific content for this page
ob_start(); // Start output buffering
    ?>
<!-- show.php -->
<div class="container mt-4 mb-5">
    <div class="card">
        <div class="card-header">
            <h2><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
        </div>

        <div class="card-body">
            <?php if ($post->image): ?>
                <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" class="img-fluid mb-3">
            <?php endif; ?>
            <p class="card-text"><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>
        </div>

        <div class="card-footer ">
            <h3>Comments</h3>
            <?php foreach ($comments as $comment): ?>
                <div class="mb-2">
                    <p class="card-text"><?php echo htmlspecialchars($comment->content, ENT_QUOTES); ?></p>
                </div>
            <?php endforeach; ?>

            <form action="/comments/store" method="post" class="mt-4">
                <div class="mb-3">
                    <label for="content" class="form-label">Content:</label>
                    <textarea id="content" name="content" class="form-control"></textarea>
                </div>
                <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>


