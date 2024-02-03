<?php
// Start output buffering
ob_start();
?>
  <!-- Display message -->
<?php if (isset($_SESSION['message'])): ?>
        <div id="message" class="<?php echo strpos($_SESSION['message'], 'error') !== false ? 'message-error' : 'message-success' ?> text-center">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>
  
<div class="container mt-4">
    <!-- View all Post Button -->
    <div class="mb-4 text-end">
        <a href="/admin/posts/" class="btn btn-success">View Posts</a>
    </div>
    <h2><?php echo htmlspecialchars($post->title, ENT_QUOTES); ?></h2>
    <!-- Check if the post has an image and display it -->
    <?php if ($post->image): ?>
        <img src="/images/<?php echo htmlspecialchars($post->image, ENT_QUOTES); ?>" alt="Post Image" class="img-fluid mb-3" style="max-width: 200px;"> <!-- Small preview -->
    <?php endif; ?>
    <p><?php echo htmlspecialchars($post->content, ENT_QUOTES); ?></p>

    <h3>Comments</h3>
    <?php foreach ($comments as $comment): ?>
        <div class="mb-2">
            <p><?php echo htmlspecialchars($comment->content, ENT_QUOTES); ?></p>
            <a href="/admin/comments/edit/<?php echo $comment->id; ?>" class="btn btn-warning btn-sm">Edit</a>
            <button onclick="deleteComment(<?php echo $comment->id; ?>)" class="btn btn-danger btn-sm">Delete</button>
        </div>
    <?php endforeach; ?>
        </div>
<?php
$content = ob_get_clean(); // Store buffered content in $content

// Include the layout
include BASE_DIR . '/public/Layouts/layout.php'; ?>
